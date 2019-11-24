<?php
  require 'validate_user.php';
  $data['ls'] = shell_exec("find cloud/ -type f -printf '%s\n%f\n'");
  echo json_encode($data);
?>
