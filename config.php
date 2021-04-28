<?php

  define('DB_SERVER','localhost');
  define('DB_USERNAME','hpyzl1jupiter');
  define('DB_PASSWORD','L_jdaX0rMB@H');
  define('DB_NAME','hpyzl1ju_medPal');

  $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  $mysqli -> set_charset("utf8mb4");

  if($mysqli->connect_error){
    die("ERROR: FAILED TO CONNECT ".$mysqli->connect_error);
  }
  

?>
