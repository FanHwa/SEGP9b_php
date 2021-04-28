<?php
    require_once dirname( dirname(__FILE__) )."/config.php";

    $user = $_POST['user'];

    // get value from post method
    $medicine=$_POST['medicine'];
    
    if($_POST['manufacturer'] == ""){
        $manufacturer = NULL;
    }else{
        $manufacturer=$_POST['manufacturer'];
    }
    
    $dosage=$_POST['dosage'];
    
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
    
    $sql = $mysqli->prepare("SELECT medicineId FROM medicine WHERE medicineName LIKE ? AND user LIKE ?");
    $sql->bind_param("ss",$medicine,$user);
    $sql->execute();
    $result = $sql->get_result();
    if($result->num_rows > 0){
        $medId = $result->fetch_assoc()["medicineId"]; 
        $sql2 = $mysqli->prepare("INSERT INTO `pillreminder` VALUES (?,NULL,?,?,?,?,?,?,?,?)");
        $sql2->bind_param("sssssssss", $user, $time, $type, $frequency, $week_bit, $medId, $quantity, $start_date, $end_date);
        
        if($sql2->execute()){
            $sql_get_pr_id = "SELECT pillreminder_id FROM pillreminder WHERE user LIKE '$user' AND time LIKE '$time' AND medicineId LIKE $medId AND start_date LIKE '$start_date'";
            $id = $mysqli->query($sql_get_pr_id)->fetch_assoc()['pillreminder_id'];
            echo json_encode("1,$medId,$id");
        }else{
            echo json_encode(0);
        }
    }else{
        $sql3 = $mysqli->prepare("INSERT INTO `medicine` VALUES (?,NULL,?,?,?, NULL,?,?)");
        $sql3->bind_param("ssssss", $user, $medicine, $manufacturer, $dosage, $purpose, $remark);
        if($sql3->execute()){
            $sql4 = "SELECT MAX(medicineId) AS lastId FROM medicine WHERE user LIKE '$user'";
            $medId = $mysqli->query($sql4)->fetch_assoc()["lastId"];
            $sql5 = $mysqli->prepare("INSERT INTO `pillreminder` VALUES (?,NULL,?,?,?,?,?,?,?,?)");
            $sql5->bind_param("sssssssss", $user, $time, $type, $frequency, $week_bit, $medId, $quantity, $start_date, $end_date);
            if($sql5->execute()){
                $sql_get_pr_id = "SELECT pillreminder_id FROM pillreminder WHERE user LIKE '$user' AND time LIKE '$time' AND medicineId LIKE $medId AND start_date LIKE '$start_date'";
                $id = $mysqli->query($sql_get_pr_id)->fetch_assoc()['pillreminder_id'];
                echo json_encode("1,$medId,$id");
            }else{
                echo json_encode(0);
            }
        }else{
            echo json_encode(0);
        }    
    }
    
    mysqli_close($mysqli);

?>