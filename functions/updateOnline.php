<?php
include "../db.php";
global $conn;


$sensorID = $_GET['sensorID'];
$cityID = $_GET['cityID'];

$searchQuery = "SELECT COUNT(*) FROM  sensor_status WHERE sensorID = $sensorID AND cityID=$cityID";
$result = mysqli_query($conn, $searchQuery);
$size = mysqli_fetch_array($result)[0];

if($size == 0){

    $sql = "INSERT INTO sensor_status (sensorID,lastOnline,cityID) VALUES ($sensorID, UNIX_TIMESTAMP(), $cityID)";
    $result =  mysqli_query($conn, $sql);

}
else{
    $sql = "UPDATE sensor_status SET lastOnline = UNIX_TIMESTAMP() WHERE sensorID = $sensorID AND cityID=$cityID";

$result =  mysqli_query($conn, $sql);
}
