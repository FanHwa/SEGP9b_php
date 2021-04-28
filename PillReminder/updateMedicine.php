<?php
    require_once dirname( dirname(__FILE__) )."/config.php";

    $id=$_POST['id'];
    
    if($_POST['manufacturer'] == ""){
        $manufacturer = NULL;
    }else{
        $manufacturer=$_POST['manufacturer'];
    }
    
    $dosage=$_POST['dosage'];
    
    if($_POST['purpose'] == ""){
        $purpose = NULL;
    }else{
        $purpose=$_POST['purpose'];
    }
    
    if($_POST['remark'] == ""){
        $remark = NULL;
    }else{
        $remark=$_POST['remark'];
    }
    
    $sql = $mysqli->prepare("UPDATE medicine SET manufacturer=?, dosage=?, purpose=?, medicineRemarks=? WHERE medicineId=?");
    $sql->bind_param("sssss",$manufacturer,$dosage,$purpose,$remark,$id);
    
    if($sql->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
    
    $sql->close();
    mysqli_close($mysqli);

?>