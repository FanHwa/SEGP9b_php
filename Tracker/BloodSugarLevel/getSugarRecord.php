<?php
  include dirname(dirname( dirname(__FILE__)))."/config.php";

  $user = $_POST['user'];

  $sql = "SELECT * FROM sugar_record_table WHERE user LIKE '$user' ORDER BY Date ASC";
  
  // Confirm there are results
  if ($result = mysqli_query($mysqli, $sql))
  {
     // Array to hold the results
     $resultArray = array();
     
     // Array to hold the data
     $tempArray = array();

     // Loop through each result
     while($row = $result->fetch_object())
     {
       // Put datas into tempArray
       $tempArray = $row;
       // Add each result into the resultArray
       array_push($resultArray, $tempArray);
     }

     // Encode the array to JSON and output the results
     echo json_encode($resultArray);
  }

  $mysqli->close();
?>
