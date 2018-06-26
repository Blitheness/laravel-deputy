<?php

namespace Blitheness\Deputy;

class BaseModel {
    protected $objectName;
    protected $path;
    protected $method = "POST";
    protected $isResource = true;
    protected $required = [];
    protected $integers = [];
    protected $dates = [];
    protected $timestamps = [];
    protected $strings = [];
    protected $booleans = [];
    protected $modified = [];
    protected $payload = [];

    /**
     * Saves the current model
     */
    public function save() {
        
    }

    /**
     * Finds a model with the specified ID
     */
    public function find(int $id) {
        $this->method = "GET";
        $this->path = $this->objectName . '/' . $id;
        return $this->resource();
    }

    public function search($field, $operator, $value) {
        $this->path = $this->objectName . '/QUERY';
        $searchCount = count($this->payload['search']) ?? 0;
        $this->payload['search']['f' . ($searchCount+1)] = [
            'field' => $field,
            'type' => $operator,
            'data' => $value
        ];
        return $this;
    }

    protected function resource() {
        $url = 'https://' . config('deputy.url') . '/api/v1/' . ($this->isResource?'resource/':'') . $this->path;

        $httpHeader = [
            'Content-type: application/json',
            'Accept: application/json',
            'Authorization: OAuth ' . config('deputy.token'),
            'dp-meta-option: none'
        ];

        $payload = !is_empty($this->payload) ? json_encode($this->payload) : null;

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

        return json_decode(curl_exec($piTrCurlHandle), true);
    }
}
