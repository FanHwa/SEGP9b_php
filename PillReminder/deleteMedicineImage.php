<?php
    require_once dirname( dirname(__FILE__) )."/config.php";
    
    // Path of the image in server
    $serverPath = "../medpal-img/";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $medID = $_POST["medId"];
        
        // Check whether this medicine has image 
        $sql = "SELECT imagePath FROM medicine WHERE medicineId = $medID";
        $result = $mysqli->query($sql)->fetch_assoc()["imagePath"];
        // If exists, remove it
        if($result!=NULL || strlen($result)>0){
            unlink($serverPath.$result);
        }
        
        $sql = "UPDATE medicine SET imagePath = NULL WHERE medicineId = $medID";
        if($mysqli->query($sql)){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    } 
    
    mysqli_close($mysqli);
?>