<?php

namespace Blitheness\Deputy;

class BaseModel {
    protected $objectName;
    protected $method = "POST";
    protected $required = [];
    protected $integers = [];
    protected $dates = [];
    protected $timestamps = [];
    protected $strings = [];
    protected $booleans = [];
    protected $modified = [];

    /**
     * Saves the current model
     */
    public function save() {
        
    }

    /**
     * Finds a model with the specified ID
     */
    public function find((int) $id) {
        $this->method = "GET";
        $path = $this->objectName . '/' . $id;
        return $this->resource($path);
    }

    protected function resource($path, $payload = null) {
        $url = 'https://' . env('DEPUTY_URL') . '/api/v1/resource/' . $path;

        $httpHeader = [
            'Content-type: application/json',
            'Accept: application/json',
            'Authorization: OAuth ' . env('DEPUTY_TOKEN'),
            'dp-meta-option: none'
        ];

        $payload = $payload ? json_encode($payload) : null;

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
