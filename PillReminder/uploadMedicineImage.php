<?php
    require_once dirname( dirname(__FILE__) )."/config.php";
    
    // Path of the image in server
    $serverPath = "../medpal-img/";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $ImageData = $_POST['image'];
        $medID = $_POST["medId"];
        $timestamp = time();
        
        // Check whether this medicine has image 
        $sql = "SELECT imagePath FROM medicine WHERE medicineId = $medID";
        $result = $mysqli->query($sql)->fetch_assoc()["imagePath"];
        // If exists, remove it
        if($result!=NULL || strlen($result)>0){
            unlink($serverPath.$result);
        }
        
        $imageName = $medID."_$timestamp.jpg";
        
        $sql = "UPDATE medicine SET imagePath = '$imageName' WHERE medicineId = $medID";
        if($mysqli->query($sql)){
            $serverPath .= $imageName;
            file_put_contents($serverPath,base64_decode($ImageData));
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    } 
    
    mysqli_close($mysqli);
?>