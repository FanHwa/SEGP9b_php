<?php
     include dirname(dirname( dirname(__FILE__)))."/config.php";
  
    $user = $_POST['user'];
    $Date="'".$_POST['Date']."'";
     $Time="'".$_POST['Time']."'";
    $Level=$_POST['Level'];

     $sql = "UPDATE `sugar_record_table` SET Level=$Level WHERE Date LIKE $Date AND Time LIKE $Time AND user LIKE '$user'";
  
    if($mysqli->query($sql)){
        echo ('Successfully saved');
    }else {
        echo ('Not saved successfully');
    }

    $mysqli->close();
?>

