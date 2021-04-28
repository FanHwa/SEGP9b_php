<?php
    include dirname(dirname( dirname(__FILE__)))."/config.php";
  
    $user = $_POST['user'];
    $Date="'".$_POST['Date']."'";
    $Time="'".$_POST['Time']."'";
    $Sys=$_POST['SYS'];
    $Dia=$_POST['DIA'];

    $sql = "UPDATE `pressure_record_table` SET SYS=$Sys, DIA=$Dia WHERE Date LIKE $Date AND Time LIKE $Time AND user LIKE '$user'";
  
    if($mysqli->query($sql)){
        echo json_encode('Successfully saved');
    }else{
        echo json_encode('Not saved successfully');
    }

    $mysqli->close();
?>
