# Streamtape PHP Client

A simple PHP client for interacting with the [Streamtape API](https://www.streamtape.com/). This client allows you to manage files, retrieve account information, and perform other operations easily via an object-oriented interface.

## Features

- [Retrieve Account Information](#get-account-information)
- [Upload](#upload)
- [Remote Upload](#remote-upload)
- [Remove Remote Upload](#remove-remote-upload)
- [Check Remote Upload Status](#check-remote-upload-status)
- [File Info](#get-file-information)
- [List Folder/Files](#list-files)
- [Create Folder](#create-new-folder)
- [Rename Folder](#rename-folder)
- [Delete Folder](#delete-folder)
- [Rename File](#rename-file)
- [Move File](#move-file)
- [Delete File](#delete-file)
- [Lists Running Conversions](#running-converts)
- [Lists Failed Conversions](#failed-converts)
- [Get Thumbnail Image](#get-thumbnail-image)

## Installation

You can install this library either by using Composer or by manually downloading the files.

### 1. Using Composer (recommended)

If you are using Composer, you can add this repository to your `composer.json`:

```bash
composer require sbrimon/streamtape-php-client
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
//login= API-Login
//key= API-Key / API-Password
$streamtape = new Streamtape('your_login', 'your_api_key');
```

### Get Account Information

You can retrieve your account information (such as balance) by calling the `AccountInfo()` method.

```php
// Get account information
$AccountInfo = $streamtape->AccountInfo();
echo "Email: " . $AccountInfo['email'] . "\n";
```

### Upload

To upload a file, use the `Upload()` method. You can pass a file, and optionally specify the folder, file name, and SHA256 hash.

```php
// File to upload (using $_FILES array)
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $file = $_FILES['file']; // Ensure 'file' is from an HTML form
   
    $upload = $streamtape->Upload($file,'my video title.mp4','folderid'); //video name and folder id are optional.
    ///json return
    echo "Upload Response: " . $upload->json();
    //or
    //Array Return
    print_r($upload);
}

```
### Remote Upload

To add a remote upload, use the `RemoteUpload()` method by providing a remote URL and optional parameters like folder, custom name, and headers.

```php
// Add a remote upload from a URL
$streamtape->RemoteUpload('https://example.com/myfile.mp4');
echo "Remote Upload Response: " . $streamtape->json();
```

### Remove Remote Upload

To remove a remote upload (or all), call the `RemoveRemoteUpload()` method and pass the remote upload ID or 'all' to delete all.

```php
// Remove a specific remote upload
$streamtape->RemoveRemoteUpload('remote_upload_id');
echo "Remote Upload Removal: " . $streamtape->json();
```

### Check Remote Upload Status

To check the status of a remote upload, use the `RemoteUploadStatus()` method by providing the remote upload ID.

```php
// Check remote upload status
$streamtape->RemoteUploadStatus('remote_upload_id');
echo "Remote Upload Status: " . $streamtape->json();
```

### Get File Information

To retrieve file information, use the `FileInfo()` method with the file ID.

```php
// Get file information
$fileInfo = $streamtape->FileInfo('file_id');
echo "File Info: " . $fileInfo->json();
```

### List Files

You can list files in a specific folder using the `ListFiles()` method.

```php
// List files in a folder
$files = $streamtape->ListFiles('folder_id');
echo "Files: " . $files->json();
```

### Create New Folder

To create a new folder, use the `NewFolder()` method and specify the folder name (and optionally the parent folder ID).

```php
// Create a new folder
$streamtape->NewFolder('new_folder_name');
echo "Folder Creation Response: " . $streamtape->json();
```

### Rename Folder

To rename an existing folder, use the `RenameFolder()` method by providing the folder ID and the new folder name.

```php
// Rename a folder
$streamtape->RenameFolder('folder_id', 'new_folder_name');
echo "Folder Rename Response: " . $streamtape->json();
```

### Delete Folder

To delete a folder, use the `DeleteFolder()` method by providing the folder ID.

```php
// Delete a folder
$streamtape->DeleteFolder('folder_id');
echo "Folder Deletion Response: " . $streamtape->json();
```

### Rename File

To rename a file, use the `RenameFile()` method and provide the file ID and new file name.

```php
// Rename a file
$streamtape->RenameFile('file_id', 'new_file_name');
echo "File Rename Response: " . $streamtape->json();
```

### Move File

You can move a file to a different folder with the `MoveFile()` method, by providing the file ID and the target folder ID.

```php
// Move a file to a folder
$streamtape->MoveFile('file_id', 'folder_id');
echo "File Move Response: " . $streamtape->json();
```

### Delete File

To delete a file, use the `DeleteFile()` method with the file ID.

```php
// Delete a file
$streamtape->DeleteFile('file_id');
echo "File Deletion Response: " . $streamtape->json();
```

### Lists Running Conversions

You can retrieve a list of running conversions using the `RunningConverts()` method.

```php
// Get running conversions
$streamtape->RunningConverts();
echo "Running Conversions: " . $streamtape->json();
```

### Lists Failed Conversions

To list all failed conversions, use the `FailedConverts()` method.

```php
// Get failed conversions
$streamtape->FailedConverts();
echo "Failed Conversions: " . $streamtape->json();
```

### Get Thumbnail Image

To retrieve a thumbnail image for a specific file, use the `Thumbnail()` method and provide the file ID.

```php
// Get thumbnail image for a file
$streamtape->Thumbnail('file_id');
echo "Thumbnail: " . $streamtape->json();
```

### Available Methods
#### 0. `json()`
- this method only use if you need only the json data. if doesnt need json data just use the main method like this 
- **Example** 
    - `$streamtape->ListFiles(); //this will return array data.`
    
    - `$streamtape->ListFiles()->json(); //this will return json data.`

#### 1. `AccountInfo()`
- **Parameters**: None

---

#### 2. `FileInfo($fileId)`
- **Parameters**:
  - `$fileId` (required): The file ID to retrieve information for.

---

#### 3. `ListFiles($folder = null)`
- **Parameters**:
  - `$folder` (optional): Folder ID to list files from. If not provided, lists files from the root.

---

#### 4. NewFolder($name, $pid = null)
- **Parameters**:
  - `$name` (required): The name of the new folder to be created.
  - `$pid` (optional): Parent folder ID (if creating inside another folder).

---

#### 5. `RenameFolder($folder, $name)`
- **Parameters**:
  - `$folder` (required): The folder ID to rename.
  - `$name` (required): The new name for the folder.

---

#### 6. `DeleteFolder($folder)`
- **Parameters**:
  - `$folder` (required): The folder ID to delete.

---

#### 7. `RenameFile($file, $name)`
- **Parameters**:
  - `$file` (required): The file ID to rename.
  - `$name` (required): The new name for the file.

---

#### 8. `MoveFile($file, $folder)`
- **Parameters**:
  - `$file` (required): The file ID to move.
  - `$folder` (required): The folder ID to move the file to.

---

#### 9. `DeleteFile($file)`
- **Parameters**:
  - `$file` (required): The file ID to delete.

---

#### 10. `RunningConverts()`
- **Parameters**: None

---

#### 11. `FailedConverts()`
- **Parameters**: None

---

#### 12. `Thumbnail($file)`
- **Parameters**:
  - `$file` (required): The file ID to get the thumbnail for.

---

#### 13. `RemoteUpload($url, $folder = null, $name = null, $headers = null)`
- **Parameters**:
  - `$url` (required): The remote URL to upload.
  - `$folder` (optional): The folder ID to upload the file to.
  - `$name` (optional): A custom name for the uploaded file.
  - `$headers` (optional): Additional HTTP headers for the request.

---

#### 14. `RemoveRemoteUpload($id)`
- **Parameters**:
  - `$id` (required): The remote upload ID to remove. Pass 'all' to remove all remote uploads.

---

#### 15. `RemoteUploadStatus($id)`
- **Parameters**:
  - `$id` (required): The remote upload ID to check the status of.

---

#### 16. `Upload($videoFile, $fileName = null, $folder = null, $sha256 = null, $httponly = null)`
- **Parameters**:
  - `$videoFile` (required): The file to upload (passed in a `$_FILES` array).
  - `$fileName` (optional): The desired file name on Streamtape.
  - `$folder` (optional): The folder ID to upload the file to.
  - `$sha256` (optional): The SHA256 hash of the file to upload.
  - `$httponly` (optional): Whether or not to make the file available via HTTP only.

For additional API methods, refer to the [Streamtape API documentation](https://www.streamtape.com/docs).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### Key Points:
- The **installation** section explains how to install via Composer or manually.
- The **usage** section covers initializing the client, getting account info, listing files, retrieving file info, and handling errors.
- The **example usage** section shows a real-world example.
- The **methods** section lists the available API methods you can use.

This README provides a complete and user-friendly guide for anyone who wants to use my PHP Streamtape client!
