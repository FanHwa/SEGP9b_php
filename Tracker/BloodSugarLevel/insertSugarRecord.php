<?php
  include dirname(dirname( dirname(__FILE__)))."/config.php";
  
  $user = $_POST['user'];
  $Date="'".$_POST['Date']."'";
  $Time="'".$_POST['Time']."'";
  $Level=$_POST['Level'];

  $sql = "INSERT INTO `sugar_record_table` (`user`, `Date`, `Time`, `Level`) VALUES ('$user',$Date,$Time,$Level)";
  
  if($mysqli->query($sql))
    {
        echo ('Successfully saved');
    }else
    {
        echo ('Not saved successfully');
    }
    

  $mysqli->close();
?>

