<?php
include "db.php";
global $conn;


$sql = "DELETE FROM sensor_data";

$result =  mysqli_query($conn, $sql);

