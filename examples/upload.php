<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../src/Streamtape.php';
//login= API-Login
//key= API-Key / API-Password
$streamtape = new Streamtape('your_login', 'your_api_key');
    $file = $_FILES['file']; // Ensure 'file' is from an HTML form
    $fileName=$_POST['fileName'];
    $folder=$_POST['folder'];
    $upload = $streamtape->Upload($file,$fileName,$folder); //video name and folder id are optional.
    ///json return
    echo "Upload Response: " . $upload->json();
   
}
?>