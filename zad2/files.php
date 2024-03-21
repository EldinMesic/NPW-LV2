<?php
session_start();
?>

<a href="index.php">
   <button>Go Back</button>
</a>

<?php
$upload_dir = "files/";

//load files from directory
$uploaded_files = scandir($upload_dir);
$uploaded_files = array_diff($uploaded_files, array('.', '..'));

echo "<h2>Files:</h2>";
if (!empty($uploaded_files)) {
    echo "<ul>";
    //foreach uploaded file
    foreach ($uploaded_files as $file) {
        if (!is_dir($upload_dir . $file) && isset($_SESSION['iv'])) {
            
            //set decryption options
            $decryption_key = md5('4ch3r0nUlt1Cr4sh3sG4m3');
            $cipher = 'AES-128-CTR';
            $options = 0;
            $decryption_iv = $_SESSION['iv'];

            //get decrypted data
            $data = openssl_decrypt(file_get_contents($upload_dir . $file), $cipher, $decryption_key, $options, $decryption_iv);
            if ($data !== false) {
                $decrypted_file_path = "decrypted_" . basename($file);
                file_put_contents($decrypted_file_path, $data);
                echo "<li><a href='download.php?file={$decrypted_file_path}' target='_blank'>Download {$file}</a></li>";
            } else {
                echo "<li>Error decrypting file: {$file}</li>";
            }
        }
    }
    echo "</ul>";
} else {
    echo "No files uploaded yet.";
}
?>