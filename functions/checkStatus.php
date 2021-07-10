<?php
include "../db.php";
global $conn;

$sensorID = $_GET['sensorID'];
$cityID = $_GET['cityID'];

    $sql = "SELECT lastOnline FROM sensor_status WHERE sensorID = $sensorID AND cityID= $cityID";
    $result = mysqli_query($conn, $sql);

   $row = mysqli_fetch_array($result);
   
   $lastOnline = $row[0];
   
   echo $lastOnline;