<?php
// Include the Streamtape class
require_once '../src/Streamtape.php';

// Initialize with your Streamtape credentials
$streamtape = new Streamtape('your_login', 'your_api_key');

// Get account info
$accountInfo = $streamtape->AccountInfo();
echo "Account email: " . $accountInfo['email'] . "\n";

// List files
$files = $streamtape->ListFiles();
foreach ($files['files'] as $file) {
    echo "File: " . $file['name'] . "\n";
}
