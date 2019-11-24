<?php
  $mysql_con = mysqli_connect("localhost", "root", "password", "GoriniDriveDB");
  // Check connection
  if ($mysql_con->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

?>
