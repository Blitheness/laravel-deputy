<?php

namespace Blitheness\Deputy;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BaseModel {
    // Resource name
    protected $objectName;
    // Path to Deputy API resource
    protected $path;
    // Request method
    protected $method     = "POST";
    // Whether or not to pre-pend 'resource/' to object name in path
    protected $isResource = true;
    // Can the model be updated?
    protected $readOnly   = false;
    // Has this model been populated with data from the API?
    protected $hasData    = false;
    // Current resource Id that is being worked with
    protected $currentId  = null;
    // Attributes that may be manipulated on this model
    protected $attributes = [];
    // Values retrieved from API or set in constructor
    protected $values     = [];
    // Attributes that must be set to create or update this model
    protected $required   = [];
    // Attributes that must be integers
    protected $integers   = [];
    // Attributes that must be dates
    protected $dates      = [];
    // Attributes that must be timestamps
    protected $timestamps = [];
    // Attributes that must be strings
    protected $strings    = [];
    // Attributes that must be booleans
    protected $booleans   = [];
    // Attributes that have been modified since last save/find
    protected $modifiedAttributes = [];
    // Data to send in a POST request to update a model or perform a search
    protected $payload    = [];
    // Any errors received from the API
    protected $errors     = [];

    /**
     * Initialise
     */
    public function __construct(array $data = null) {
        if($data != null) {
            foreach($data as $k=>$v) {
                if(in_array($k, $this->attributes) && $this->validate($k, $v)) {
                    $this->values[$k] = $v;
                    if($k == 'Id') {
                        $this->currentId = $v;
                    }
                }
            }
        }
    }

    /**
     * Saves the current model
     *
     * TODO allow resource creation as well as updates, by checking if Id is set
     */
    public function save() {
        // If this object hasn't had its values changed, then abort.
        if(!$this->isModified()) {
            return false;
        }

        // Discard cached objects
        $this->invalidateCache();

        foreach($this->modifiedAttributes as $a) {
            $this->payload[$a] = $this->values[$a];
        }

        // Set request method to POST
        $this->method = "POST";

        // Run the request
        // TODO This should return the modified object - use it
        $this->get();
        return true;
    }

    public function invalidateCache() {
        return Cache::forget($this->getCacheKey());
    }

    /**
     * Intercept gets
     */
    public function __get($name) {
        if(!in_array($name, $this->attributes)) {
            throw new \Exception("The attribute {$name} is unavailable on this data model");
        }
        return $this->values[$name];
    }

    /**
     * Intercept sets
     */
    public function __set($name, $value) {
        if($this->readOnly) {
            throw new \Exception("Cannot write to this data model because it is read-only");
        }
        if(!in_array($name, $this->attributes)) {
            throw new \Exception("The attribute {$name} is unavailable on this data model");
        }
        if($this->validate($name, $value)) {
            $this->values[$name] = $value;
            $this->setModified($name);
            return true;
        }
        return false;
    }

    /**
     * Checks if the value for an attribute is acceptable
     */
    public function validate($name, $value) {
        if(in_array($name, $this->strings)) {
            if(is_string($value)) {
                return true;
            }
        } else if(in_array($name, $this->booleans)) {
            if(is_bool($value)) {
                return true;
            }
        } else if(in_array($name, $this->integers)) {
            if(is_numeric($value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Mark the given attribute as modified
     *
     * Returns 'true' when marked as modified
     * Returns 'false' if already marked as modified
     */
    public function setModified($name) {
        if(!in_array($name, $this->modifiedAttributes)) {
            $this->modifiedAttributes[] = $name;
            return true;
        }
        return false;
    }

    /**
     * Whether or not this model has been 'filled' with data from the API
     */
    public function hasData() {
        return $this->hasData;
    }

    /**
     * Whether or not this model has been changed locally since last downloaded from the API
     */
    public function isModified() {
        return count($this->modifiedAttributes) > 0;
    }

    /**
     * Finds a model with the specified ID
     */
    public function find(int $id = null) {
        $this->method = "GET";
        if(null == $id) {
            $this->path = $this->objectName;
        } else {
            $this->path = $this->objectName . '/' . $id;
            $this->currentId = $id;
        }
        $output = $this->get();
        return $output;
    }

    public function search($field, $operator, $value) {
        $this->path = $this->objectName . '/QUERY';

        if(!isset($this->payload['search'])) {
            $this->payload['search'] = [];
        }

        $searchCount = count($this->payload['search']) ?? 0;

        $this->payload['search']['f' . ($searchCount+1)] = [
            'field' => $field,
            'type' => $operator,
            'data' => $value
        ];

        $this->method = "POST";

        return $this;
    }

    public function getPath() {
        return ($this->isResource?'resource/':'') . $this->path;
    }

    public function getCacheKey() {
        return 'dp_' . $this->getPath();
    }

    public function get() {
        $path = $this->getPath();
        $cacheKey = $this->getCacheKey();
        $fromCache = false;
        $this->errors = [];

        // Cache GET request result for a while if cache mode is on (in config/deputy.php)
        if($this->method == "GET" && $this->isResource && Cache::has($cacheKey)) {
            \Log::info("[Deputy] Retrieving item from cache: " . $cacheKey);
            $data = Cache::get($cacheKey);
            $fromCache = true;
        } else {
            $data = $this->apiCall($path, $this->method, $this->payload);
            $this->payload = [];
            \Log::info("[Deputy] Made a {$this->method} request to {$path}.");
        }

        // TODO stop relying on wishy thinking; re-write and document this section so it makes sense
        if(is_array($data) && array_key_exists('error', $data)) {
            $this->errors[] = $data['error'];
            \Log::error('[Deputy] API error ' . $data['error']['code'] . ' for path ' . $this->getPath() . ': ' . $data['error']['message']);
            \Log::error('[Deputy] * method: ' . $this->method);
            return $this;
        } else if(is_array($data) && count($data) == count($data, COUNT_RECURSIVE)) {
            if(!$fromCache && $this->method == "GET" && $this->isResource) {
                \Log::info("[Deputy] Adding item to cache for 10 minutes: " . $cacheKey);
                Cache::put($cacheKey, $data, now()->addMinutes(10));
            }
            $this->values = $data;
            $this->hasData = true;
            return $this;
        } else if(is_array($data)) {
            if(array_key_exists('Id', $data)) {
                $this->hasData = true;
                return $this;
            }
            $collection = new Collection();
            $type = 'Blitheness\\Deputy\\Models\\' . $this->objectName;
            foreach($data as $k=>$v) {
                $model = new $type($v);
                $model->hasData = true;
                $collection->push($model);
            }
            return $collection;
        } else {
            $this->errors[] = "No conditions matched in BaseModel::get()";
            return $this;
        }
    }

    private function apiCall($path, $method, $payload) {
        $url = 'https://' . config('deputy.url') . '/api/v1/' . $path;
        $httpHeader = [
            'Content-type: application/json',
            'Accept: application/json',
            'Authorization: OAuth ' . config('deputy.token'),
            'dp-meta-option: none'
        ];
        $payload = !empty($payload) ? json_encode($payload) : null;
        $piTrCurlHandle = curl_init();
        curl_setopt($piTrCurlHandle, CURLOPT_RESUME_FROM,    0);
        curl_setopt($piTrCurlHandle, CURLOPT_URL,            $url);
        curl_setopt($piTrCurlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($piTrCurlHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($piTrCurlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($piTrCurlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($piTrCurlHandle, CURLOPT_TIMEOUT,        500);
        if($method == "POST") {
            curl_setopt($piTrCurlHandle, CURLOPT_POST,    1);
            curl_setopt($piTrCurlHandle, CURLOPT_HTTPGET, 0);
        } else {
            curl_setopt($piTrCurlHandle, CURLOPT_POST,    0);
            curl_setopt($piTrCurlHandle, CURLOPT_HTTPGET, 1);
        }
        if($payload) {
            curl_setopt($piTrCurlHandle, CURLOPT_POSTFIELDS, $payload);
        }
        curl_setopt($piTrCurlHandle, CURLOPT_HTTPHEADER, $httpHeader);
        return json_decode(curl_exec($piTrCurlHandle), true);
    }

    public function hasError() {
        return count($this->errors) >= 1;
    }

    public function getErrors() {
        return $this->errors;
    }
}
