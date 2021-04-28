<?php
     include dirname(dirname( dirname(__FILE__)))."/config.php";
  
    $user = $_POST['user'];
    $Date="'".$_POST['Date']."'";
     $Time="'".$_POST['Time']."'";

     $sql = "DELETE FROM `sugar_record_table` WHERE Date LIKE $Date AND Time LIKE $Time AND user LIKE '$user'";
  
    if($mysqli->query($sql)){
        echo json_encode('Successfully saved');
    }else {
        echo json_encode('Not saved successfully');
    }

    $mysqli->close();
?>

