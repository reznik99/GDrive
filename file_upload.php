<?php
require 'validate_user.php';
if(isset($_POST["submit"])) {
  $uploaddir = 'cloud/';
  $uploadfile = $uploaddir . htmlspecialchars(basename($_FILES['fileToUpload']['name']));
  $text = "File upload failed!";
  if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
    $text = "File uploaded successfully!";
  }
  header("Location: index.php?status=".$text);
  exit();
}
?>
