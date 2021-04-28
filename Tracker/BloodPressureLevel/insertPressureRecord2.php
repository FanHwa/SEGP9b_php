<?php
  include dirname(dirname( dirname(__FILE__)))."/config.php";
  
  $Date="'".$_POST['Date']."'";
  $Time="'".$_POST['Time']."'";
  $Sys=$_POST['SYS'];
  $Dia=$_POST['DIA'];

  $sql = $mysqli->prepare("INSERT INTO `pressure_record_table` (`Date`, `Time`, `SYS`, `DIA`) VALUES (?,?,?,?)");
  $sql->bind_param("ssss",$Date,$Time,$Sys,$Dia);
  
  if($sql->execute())
    {
        echo json_encode('Successfully saved');
    }else
    {
        echo json_encode('Not saved successfully');
    }
    
    $sql->close();

  $mysqli->close();
?>
