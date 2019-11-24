<?php
  require 'validate_user.php';
  $f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
  $temp = fgets($f);
  fclose($f);

  $data['temp'] =  'CPU ->'.round($temp/1000);
  // $data['temp'] = shell_exec('./shell_scripts/temperature.sh 2>&1');
  $data['uptime'] = shell_exec("uptime -p");
  echo json_encode($data);
?>
