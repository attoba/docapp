<?php

class LoggerAppenderSplunkHttp extends LoggerAppender {
    protected $url;
    protected $token;
    protected $index;
    protected $sourcetype;
    protected $source;
    protected $host;
    protected $timeout = 5;
    protected $disableCertificateValidation = true;

    public function activateOptions() {
        if (empty($this->url) || empty($this->token)) {
            throw new LoggerException("Splunk HTTP Appender: URL and Token must be set.");
        }
    }

    public function append(LoggerLoggingEvent $event) {
        $log = $this->getLayout()->format($event);  // Format log message

        // Construct the payload with metadata for Splunk
        $payload = json_encode([
            'event' => $log,                         // The actual log message
            'index' => $this->index,                 // Splunk index
            'sourcetype' => $this->sourcetype,       // Sourcetype in Splunk (log4php)
            'host' => $this->host,                   // Host where logs originate
            'source' => $this->source                // Source for the logs (http-event-logs)
        ]);

        // Initialize cURL
        $ch = curl_init($this->url . '/services/collector');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Splunk ' . $this->token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        // Disable SSL verification if specified
        if ($this->disableCertificateValidation) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        // Execute cURL
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('Error sending log to Splunk: ' . curl_error($ch));
        }
        curl_close($ch);
    }

    // Setters for XML config to work
    public function setUrl($url) { $this->url = $url; }
    public function setToken($token) { $this->token = $token; }
    public function setIndex($index) { $this->index = $index; }
    public function setSourcetype($sourcetype) { $this->sourcetype = $sourcetype; }
    public function setSource($source) { $this->source = $source; }
    public function setHost($host) { $this->host = $host; }
    public function setTimeout($timeout) { $this->timeout = $timeout; }
    public function setDisableCertificateValidation($disable) {
        $this->disableCertificateValidation = filter_var($disable, FILTER_VALIDATE_BOOLEAN);
    }
}
