<?php
include "db.php";
global $conn;

if ($_GET['temperature'] != '' and $_GET['humidity'] != '') {
    $humidity = $_GET['humidity'];
    $temperature = $_GET['temperature'];
    $sensorID = $_GET['sensorID'];
    $cityID = $_GET['cityID'];
	
}


$sql = "insert into sensor_data set humidity='" . $humidity . "', temperature='" . $temperature . "',sensorID='". $sensorID. "',cityID='". $cityID. "',timestamp = NOW()";


$result =  mysqli_query($conn, $sql);

