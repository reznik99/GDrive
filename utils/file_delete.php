<?php
require 'validate_user.php';

$file = '../cloud/'.htmlspecialchars($_GET['filename']);

if (is_file($file)) {
  chmod($filename, 0777);

  if (unlink($file)) {
    $text = "File deleted successfully!";
  } else {
    $text = "File deletion failed!";
  }
  header("Location: ../index.php?status=".$text);
  exit();
}
?>
