<?php
  include dirname(dirname( dirname(__FILE__)))."/config.php";
  
  $user = $_POST['user'];
  $Date="'".$_POST['Date']."'";
  $Time="'".$_POST['Time']."'";
  $Sys=$_POST['SYS'];
  $Dia=$_POST['DIA'];

  $sql = "INSERT INTO `pressure_record_table` (`user`, `Date`, `Time`, `SYS`, `DIA`) VALUES ('$user',$Date,$Time,$Sys,$Dia) ";
  
  if($mysqli->query($sql))
    {
        echo json_encode('Successfully saved');
    }else
    {
        echo json_encode('Not saved successfully');
    }

  $mysqli->close();
?>
