<?php
/**
 * Streamtape API Client
 * 
 * @author SB Rimon <sbrimon10@gmail.com>
 * @version 1.0.1
 * @package  sbrimon/streamtape-php-client
 * @link https://github.com/sbrimon10/streamtape-api-client GitHub Repository
 * @license MIT
 */
class Streamtape {
    private $apiUrl = 'https://api.streamtape.com';
    private $authParams = [];
    private $data;

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
     * Converts the stored file information to a JSON string.
     * 
     * @return string The file information in JSON format.
     */
    public function json() {
        return json_encode($this->data);
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

    /**
     * Get account information
     * 
     * @return $this
     */
    public function AccountInfo() {
        $this->data = $this->get('/account/info');
        return $this;
    }

    /**
     * Get file information
     * 
     * @param string $fileId File ID to check
     * @return $this
     */
    public function FileInfo($fileId) {
        $this->data = $this->get('/file/info', ['file' => $fileId]);
        return $this;
    }

    /**
     * List files
     * 
     * @param string $folder Folder ID (Optional)
     * @return $this
     */
    public function ListFiles($folder = null) {
        $this->data = $this->get('/file/listfolder', ['folder' => $folder]);
        return $this;
    }

    /**
     * Create New Folder
     * 
     * @param string $name New Folder Name (Required)
     * @param string $pid Parent Folder ID (Optional)
     * @return $this
     */
    public function NewFolder($name, $pid = null) {
        $this->data = $this->get('/file/createfolder', [
            'name' => $name,
            'pid' => $pid
        ]);
        return $this;
    }

    /**
     * Rename Folder
     * 
     * @param string $folder Folder ID (Required)
     * @param string $name Folder Name (Required)
     * @return $this
     */
    public function RenameFolder($folder, $name) {
        $this->data = $this->get('/file/renamefolder', [
            'folder' => $folder,
            'name' => $name
        ]);
        return $this;
    }

    /**
     * Delete Folder
     * 
     * @param string $folder Folder ID (Required)
     * @return $this
     */
    public function DeleteFolder($folder) {
        $this->data = $this->get('/file/deletefolder', ['folder' => $folder]);
        return $this;
    }

    /**
     * Rename a file
     * 
     * @param string $file File ID (Required)
     * @param string $name New file name (Required)
     * @return $this
     */
    public function RenameFile($file, $name) {
        $this->data = $this->get('/file/rename', [
            'file' => $file,
            'name' => $name
        ]);
        return $this;
    }

    /**
     * Move a file to a folder
     * 
     * @param string $file File ID (Required)
     * @param string $folder Folder ID (Required)
     * @return $this
     */
    public function MoveFile($file, $folder) {
        $this->data = $this->get('/file/move', [
            'file' => $file,
            'folder' => $folder
        ]);
        return $this;
    }

    /**
     * Delete a file
     * 
     * @param string $file File ID (Required)
     * @return $this
     */
    public function DeleteFile($file) {
        $this->data = $this->get('/file/delete', ['file' => $file]);
        return $this;
    }

    /**
     * Get running conversions
     * 
     * @return $this
     */
    public function RunningConverts() {
        $this->data = $this->get('/file/runningconverts');
        return $this;
    }

    /**
     * Get failed conversions
     * 
     * @return $this
     */
    public function FailedConverts() {
        $this->data = $this->get('/file/failedconverts');
        return $this;
    }

    /**
     * Retrieve the thumbnail for a specified file.
     * 
     * @param string $file File ID to get the thumbnail for (Required)
     * @return $this
     */
    public function Thumbnail($file) {
        $this->data = $this->get('/file/getsplash', ['file' => $file]);
        return $this;
    }

    /**
     * Add remote upload
     * 
     * @param string $url Remote URL to download (required)
     * @param string|null $folder Folder ID to upload to (optional)
     * @param string|null $name Custom file name (optional)
     * @param string|null $headers Additional HTTP headers (optional)
     * @return $this
     */
    public function RemoteUpload($url, $folder = null, $name = null, $headers = null) {
        $params = [
            'url' => $url,
            'folder' => $folder,
            'headers' => $headers ? urlencode($headers) : null,
            'name' => $name ? urlencode($name) : null,
        ];

        $params = array_filter($params, function($value) {
            return $value !== null;
        });

        $this->data = $this->get('/remotedl/add', $params);
        return $this;
    }

    /**
     * Remove a remote upload
     * if in id pass the "all" it will remove all remote uploads
     * @param string $id Remote upload ID to remove (Required)
     * @return $this
     */
    public function RemoveRemoteUpload($id) {
        $this->data = $this->get('/remotedl/remove', ['id' => $id]);
        return $this;
    }

    /**
     * Check the status of a remote upload
     * 
     * @param string $id Remote upload ID to check the status of (Required)
     * @return $this
     */
    public function RemoteUploadStatus($id) {
        $this->data = $this->get('/remotedl/status', ['id' => $id]);
        return $this;
    }

    /**
     * Upload a file to streamtape
     * 
     * @param array $videoFile A $_FILES style array representing the file to upload (Required)
     * @param string|null $fileName The desired name of the file on streamtape, if different from the name of the file in $videoFile (Optional)
     * @param string|null $folder The ID of the folder on streamtape where the file should be uploaded (Optional)
     * @param string|null $sha256 The SHA256 hash of the file to upload (Optional)
     * @param bool|null $httponly Whether or not to make the file available over HTTP only (Optional)
     * @return $this
     */
    public function Upload($videoFile, $fileName = null, $folder = null, $sha256 = null, $httponly = null) {
        $params = [
            'folder' => $folder,
            'sha256' => $sha256,
            'httponly' => $httponly ? 'true' : null
        ];

        $uploadUrlResponse = $this->post('/file/ul', $params);

        if (!isset($uploadUrlResponse['result']['url'])) {
            throw new Exception("Error retrieving upload URL.");
        }

        $filePath = $videoFile['tmp_name'];
        $fileName = $fileName ?: $videoFile['name'];
        $uploadUrl = $uploadUrlResponse['result']['url'];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $uploadUrl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'file1' => new CURLFile($filePath, mime_content_type($filePath), $fileName)
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $this->data = $this->executeRequest($ch);
        return $this;
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
}