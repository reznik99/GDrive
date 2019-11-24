<?php
   require 'validate_user.php';
   unset($_SESSION['valid']);
   unset($_SESSION['timeout']);
   unset($_SESSION["username"]);

   header('Location: login.php');
?>
