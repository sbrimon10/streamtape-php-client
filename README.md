
```markdown
# Streamtape PHP Client

A simple PHP client for interacting with the [Streamtape API](https://www.streamtape.com/). This client allows you to manage files, retrieve account information, and perform other operations easily via an object-oriented interface.

## Features

- Retrieve account information
- List files and retrieve file details
- Handle both GET and POST requests to the Streamtape API

## Installation

You can install this library either by using Composer or by manually downloading the files.

### 1. Using Composer (recommended)

If you are using Composer, you can add this repository to your `composer.json`:

```bash
composer require yourusername/streamtape-php-client
```

### 2. Manual Installation

If you prefer to manually install, download the `Streamtape.php` file and include it in your project like this:

```php
require_once 'path/to/Streamtape.php';
```

## Usage

### Initialization

To use the client, you need to initialize the `Streamtape` class with your Streamtape credentials: your login and API key.

```php
// Include the Streamtape class
require_once 'path/to/Streamtape.php';

// Initialize with your Streamtape login and API key
$streamtape = new Streamtape('your_login', 'your_api_key');
```

### Get Account Information

You can retrieve your account information (such as balance) by calling the `accountInfo()` method.

```php
// Get account information
$accountInfo = $streamtape->accountInfo();
echo "Account balance: " . $accountInfo['balance'] . "\n";
```

### List Files

To list the files in your account, use the `listFiles()` method. You can specify the folder ID, limit, and page number for pagination.

```php
// List files
$files = $streamtape->listFiles();
foreach ($files['files'] as $file) {
    echo "File: " . $file['filename'] . "\n";
}
```

### Get File Information

To get detailed information about a specific file, you can use the `fileInfo()` method and provide the file ID.

```php
// Get file information
$fileInfo = $streamtape->fileInfo('your_file_id');
echo "File Size: " . $fileInfo['size'] . "\n";
```

### Example Usage

Here’s a full example demonstrating how to use the class:

```php
<?php

// Include the Streamtape class
require_once 'path/to/Streamtape.php';

// Initialize with your Streamtape credentials
$streamtape = new Streamtape('your_login', 'your_api_key');

// Get account information
try {
    $accountInfo = $streamtape->accountInfo();
    echo "Account balance: " . $accountInfo['balance'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// List files
try {
    $files = $streamtape->listFiles();
    foreach ($files['files'] as $file) {
        echo "File: " . $file['filename'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Error Handling

In case of an error (e.g., network issues or invalid credentials), an exception will be thrown. Be sure to handle exceptions in your code.

```php
try {
    // Make an API call
    $response = $streamtape->accountInfo();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Available Methods

- **`accountInfo()`**: Get account information.
- **`fileInfo($fileId)`**: Get information about a specific file. (Requires the file ID)
- **`listFiles($folder = 0, $limit = 100, $page = 0)`**: List files in a specific folder, with pagination options.

For additional API methods, refer to the [Streamtape API documentation](https://www.streamtape.com/docs).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
```

### Key Points:
- The **installation** section explains how to install via Composer or manually.
- The **usage** section covers initializing the client, getting account info, listing files, retrieving file info, and handling errors.
- The **example usage** section shows a real-world example.
- The **methods** section lists the available API methods you can use.

This README provides a complete and user-friendly guide for anyone who wants to use your PHP Streamtape client!