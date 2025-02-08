<?php
// Include the Streamtape class
require_once '../src/Streamtape.php';

// Initialize with your Streamtape credentials
$streamtape = new Streamtape('your_login', 'your_api_key');

// Get account info
$accountInfo = $streamtape->accountInfo();
echo "Account balance: " . $accountInfo['balance'] . "\n";

// List files
$files = $streamtape->listFiles();
foreach ($files['files'] as $file) {
    echo "File: " . $file['filename'] . "\n";
}
