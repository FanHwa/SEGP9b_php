<?php
  include dirname(dirname( dirname(__FILE__)))."/config.php";
  
  $Date="'".$_POST['Date']."'";
  $Time="'".$_POST['Time']."'";
  $Level=$_POST['Level'];

  $sql = $mysqli->prepare("INSERT INTO `sugar_record_table` (`Date`, `Time`, `Level`) VALUES (?,?,?)");
  $sql->bind_param("sss",$Date,$Time,$Level);
  
  if($sql->execute())
    {
        echo ('Successfully saved');
    }else
    {
        echo ('Not saved successfully');
    }
    
    $sql->close();

  $mysqli->close();
?>