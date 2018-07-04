<?php

namespace Blitheness\Deputy;

use Illuminate\Container\EntryNotFoundException;

class BaseModel {
    protected $objectName;
    protected $path;
    protected $method     = "POST";
    protected $isResource = true;
    protected $readOnly   = false;
    protected $hasData    = false;
    protected $currentId  = null;
    protected $attributes = [];
    protected $values     = [];
    protected $required   = [];
    protected $integers   = [];
    protected $dates      = [];
    protected $timestamps = [];
    protected $strings    = [];
    protected $booleans   = [];
    protected $modifiedAttributes = [];
    protected $payload    = [];

    /**
     * Saves the current model
     */
    public function save() {
        if(!$this->isModified()) {
            return false;
        }
        foreach($this->modifiedAttributes as $a) {
            $this->payload[$a] = $this->values[$a];
        }
        $this->method = "POST";
        $this->get();
        return true;
    }

    /**
     * Intercept gets
     */
    public function __get($name) {
        if(!in_array($name, $this->attributes)) {
            throw new EntryNotFoundException("The attribute {$name} is unavailable on this data model");
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
            throw new EntryNotFoundException("The attribute {$name} is unavailable on this data model");
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
    public function find(int $id) {
        $this->method = "GET";
        $this->path = $this->objectName . '/' . $id;
        $this->currentId = $id;
        return $this->get();
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

    public function get() {
        $url = 'https://' . config('deputy.url') . '/api/v1/' . ($this->isResource?'resource/':'') . $this->path;

        $httpHeader = [
            'Content-type: application/json',
            'Accept: application/json',
            'Authorization: OAuth ' . config('deputy.token'),
            'dp-meta-option: none'
        ];

        $payload = !empty($this->payload) ? json_encode($this->payload) : null;

        $piTrCurlHandle = curl_init();
        curl_setopt($piTrCurlHandle, CURLOPT_HTTPGET, 1);
        curl_setopt($piTrCurlHandle, CURLOPT_RESUME_FROM, 0);
        curl_setopt($piTrCurlHandle, CURLOPT_URL, $url);
        curl_setopt($piTrCurlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($piTrCurlHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($piTrCurlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($piTrCurlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($piTrCurlHandle, CURLOPT_TIMEOUT, 500);

        if($payload) {
            curl_setopt($piTrCurlHandle, CURLOPT_POST, 1);
            curl_setopt($piTrCurlHandle, CURLOPT_POSTFIELDS, $payload);
        }

        curl_setopt($piTrCurlHandle, CURLOPT_HTTPHEADER, $httpHeader);

        $data = json_decode(curl_exec($piTrCurlHandle), true);
        $this->values = $data;
        if(count($data)>0) {
            $this->hasData = true;
        }
        return $this;
    }
}
