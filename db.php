<?php
/**
 * Created by Pavel Tyulnev
 *
 */


//$servername = "localhost";
//$dbname = "lime_base_data";
//$username = "root";
//$password = "";

$servername = "10.35.46.194";
$dbname = "k148212_devcon";
$port = "3306";
$username = "k148212_devcon";
$password = "thulu5yQ??";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn){

}
