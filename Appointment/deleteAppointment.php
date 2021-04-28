<?php
    require_once dirname( dirname(__FILE__) )."/config.php";

    $id=$_POST['id'];
    
    $sql = $mysqli->prepare("DELETE FROM appointment WHERE appointment_id = ?");
    $sql->bind_param("i",$id);
    if($sql->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
    $sql->close();
    mysqli_close($mysqli);

?>