<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SplunkLogger {
    protected $token;
    protected $url;

    public function __construct() {
        // Initialize HEC token and URL
        $this->token = '42534f72-362c-4ec5-99af-b313ba310ed0'; // Replace with your token
        $this->url = 'http://localhost:8088'; // Replace with your Splunk server URL
    }

    public function log($event, $index = 'documents', $sourcetype = 'json') {
        $data = [
            'event' => $event,
            'index' => $index,
            'sourcetype' => $sourcetype
        ];

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Splunk ' . $this->token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode == 200; // Returns true if log sent successfully
    }
}
