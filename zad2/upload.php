<?php
session_start();
$message = "";
//Upload File if POST
if (isset($_POST["upload_token"]) && $_POST["upload_token"] === $_SESSION["upload_token"] && !empty($_FILES["file"]["name"])) {
    $upload_dir = "files/";
    
    //Get file data
    $file_name = $_FILES["file"]["name"];
    $file_tmp_name = $_FILES["file"]["tmp_name"];

    $new_file_name = uniqid() . "_" . $file_name;
    $upload_path = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp_name, $upload_path)) {

        //Set encryption data
        $encryption_key = md5('4ch3r0nUlt1Cr4sh3sG4m3');
        $cipher = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher);
        $options = 0;
        $encryption_iv = random_bytes($iv_length);
        $_SESSION['iv'] = $encryption_iv;

        //encrypt file
        $encrypted_content = openssl_encrypt(file_get_contents($upload_path), $cipher, $encryption_key, $options, $encryption_iv);

        if ($encrypted_content) {
            $encrypted_file_path = $upload_dir . "encrypted_" . $new_file_name;

            //write new data
            if (file_put_contents($encrypted_file_path, $encrypted_content)) {
                $message = "Upload successful";
                unlink($upload_path);
            } else {
                $message = "An Error has occured";
            }
        }
    } else {
        $message = "An Error has occured";
    }
}
header("Location: index.php?message=$message");

?>