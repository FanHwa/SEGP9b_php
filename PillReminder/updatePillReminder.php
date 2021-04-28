<?php
    require_once dirname( dirname(__FILE__) )."/config.php";

    $id=$_POST['id'];
    
    $type=$_POST['type'];
    
    if($_POST['type'] == 2){
        $frequency = $_POST['frequency'];
        $week_bit = NULL;
    }else if($_POST['type'] == 3){
        $frequency = NULL;
        $week_bit=$_POST['week_bit'];
    }else{
        $frequency = NULL;
        $week_bit = NULL;
    }
    
    $time=$_POST['time'];
    
    $quantity=$_POST['quantity'];
    
    $start_date=$_POST['start_date'];
    
    if($_POST['end_date'] == ""){
        $end_date = NULL;
    }else{
        $end_date=$_POST['end_date'];   
    }
    
    $sql = $mysqli->prepare("UPDATE pillreminder SET type = ?, frequency = ?, week_bit = ?, time = ?, quantity = ?, start_date = ?, end_date = ? WHERE pillreminder_id = ?");
    $sql->bind_param("ssssssss",$type,$frequency,$week_bit,$time,$quantity,$start_date,$end_date,$id);
    
    if($sql->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
    $sql->close();
    mysqli_close($mysqli);

?>