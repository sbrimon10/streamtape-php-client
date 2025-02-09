<?php

class Streamtape {
    private $apiUrl = 'https://api.streamtape.com';
    private $authParams = [];

    /**
     * Initialize Streamtape API client
     * 
     * @param string $login User login credential
     * @param string $key User API key
     * @param string|null $apiUrl Optional custom API URL
     */
    public function __construct($login, $key, $apiUrl = null) {
        $this->authParams = [
            'login' => $login,
            'key' => $key
        ];

        if ($apiUrl !== null) {
            $this->apiUrl = rtrim($apiUrl, '/');
        }
    }

    /**
     * Handle GET requests
     * 
     * @param string $endpoint API endpoint
     * @param array $params Additional parameters
     * @return array Decoded JSON response
     */
    private function get($endpoint, $params = []) {
        $url = $this->buildUrl($endpoint, $params);
        // var_dump($url);
        // die();
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        return $this->executeRequest($ch);
    }

    /**
     * Handle POST requests
     * 
     * @param string $endpoint API endpoint
     * @param array $data POST data
     * @return array Decoded JSON response
     */
    private function post($endpoint, $data = []) {
        $url = $this->buildUrl($endpoint);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        return $this->executeRequest($ch);
    }

    /**
     * Build URL with authentication parameters
     * 
     * @param string $endpoint API endpoint
     * @param array $params Additional GET parameters
     * @return string Complete URL
     */
    private function buildUrl($endpoint, $params = []) {
        $queryParams = array_merge($this->authParams, $params);
        return $this->apiUrl . $endpoint . '?' . http_build_query($queryParams);
    }

    /**
     * Execute cURL request and handle response
     * 
     * @param resource $ch cURL handle
     * @return array Decoded response
     * @throws Exception If request fails
     */
    private function executeRequest($ch) {
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }

        if ($httpCode >= 400) {
            throw new Exception("HTTP Error: Status code $httpCode");
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Decode Error: " . json_last_error_msg());
        }

        return $decoded;
    }

    // Public API Methods

    /**
     * Get account information
     * 
     * @return array Account info
     */
    public function accountInfo() {
        return $this->get('/account/info');
    }

    /**
     * Get file information
     * 
     * @param string $fileId File ID to check
     * @return array File info
     */
    public function fileInfo($fileId) {
        return $this->get('/file/info', ['file' => $fileId]);
    }

    /**
     * List files
     * 
     * @param int $folder Folder ID (default: 0)
     * @param int $limit Number of results (default: 100)
     * @param int $page Page number (default: 0)
     * @return array File list
     */
    public function listFiles($folder = 0, $limit = 100, $page = 0) {
        return $this->get('/file/list', [
            'folder' => $folder,
            'limit' => $limit,
            'page' => $page
        ]);
    }

    // Add more API methods as needed
}