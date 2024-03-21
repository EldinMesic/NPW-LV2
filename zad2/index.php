<?php
session_start();

//generate the unique ID
if (!isset($_SESSION["upload_token"])) {
    $_SESSION["upload_token"] = uniqid();
}

if(isset($_GET['message'])){
    echo $_GET['message'];
}
?>

<form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="hidden" name="upload_token" value="<?php echo $_SESSION["upload_token"]; ?>">
    <label for="file">Select file:</label>
    <br>
    <input type="file" if="file" name="file" accept=".png, .jpeg, .pdf">
    <input type="submit" value="Upload">
</form>

<form action="files.php" method="get">
    <input type="submit" value="List Files">
</form>