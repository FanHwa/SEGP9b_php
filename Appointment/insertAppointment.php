<?php
  include dirname( dirname(__FILE__) )."/config.php";
  
  $user = $_POST['user'];
  $date=$_POST['date'];
  $time=$_POST['time'];
  $doctor=$_POST['doctor'];
  $venue=$_POST['venue'];
  $contact=$_POST['contact'];
  $email=$_POST['email'];
  $purpose=$_POST['purpose'];
  $remark=$_POST['remark'];

  $sql = $mysqli->prepare("INSERT INTO `appointment` (`user`, `date`, `time`, `doctor`, `venue`,`contact`,`email`,`purpose`,`remark`) VALUES (?,?,?,?,?,?,?,?,?)");
  $sql->bind_param("sssssisss", $user, $date, $time, $doctor, $venue, $contact, $email, $purpose, $remark);
  
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