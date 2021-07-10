<?php
/**
 * By Pavel Tyulnev
 * 09.03.2021
 *
 * Falls es einer mal liest:
 * dieser Code ist ziemlich chaotisch und wird mit der Zeit verbessert.
 * Verbesserungen sind willkommen
 */
include "db.php";

$cityID = $_GET['city'];

if ($cityID == 1) {
    $city = "Dresden";
} else if ($cityID == 2) {
    $city = "Münster";
} else if ($cityID == 3) {
    $city = "Wolfsburg";
}

if (!isset($city)) {
    header("Location: http://foerster.solutions/basedata/");
}

function showData($cityID)
{

    global $conn;
    $sql = "SELECT * FROM sensor_data WHERE cityID =".$cityID;
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
        echo '<tr>
           <td>'.$row['sensorID'].'</td>
           <td>'.$row['temperature'].' °C</td>
           <td>'.$row['humidity'].' %</td>
           <td>'.$row['timestamp'].'</td>
         
      
         </tr>';
    }
}

?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>


    <title>Temperatur-Übersicht <?=$city?></title>
    <style>
        body {
            width: 1400px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 100px;
        }
		.online{
			color:green;
			display:none;
		}
		.offline{
			color:red;
			display:none;
		}
	#sensorState{
		display:none;
	
	}
	
	#stateTable{
			margin-top:70px;
		margin-left:20px;
	}
    </style>
</head>


<body onload="checkStatus();">
<h1>Temperatur-Übersicht <?=$city?></h1>

<div class='row'>
<div class='col-10'>
<table class="table" id="table_id">
    <thead>
    <tr>
        <th scope="col">SensorID</th>
        <th scope="col">Temperatur</th>
        <th scope="col">Feuchtigkeit</th>
        <th scope="col">Zeitpunkt</th>

    </tr>
    </thead>
    <tbody>
    <?php showData($cityID); ?>
    </tbody>
</table>
</div>

<div class='col-2' id='sensorState'>

<table id='stateTable'>
<tr>
	<td><p style='display:inline;'>Sensor 1: </p></td>
	<td><p style='display:inline;' class='online' id='online1'><i class="fa fa-circle" aria-hidden="true"></i> Online</p><p style='display:inline;' class='offline' id='offline1'><i class="fa fa-circle" aria-hidden="true"></i> Offline</p></td>
</tr>
<tr>
	<td><p style='display:inline;'>Sensor 2: </p></td>
	<td><p style='display:inline;' class='online' id='online2'><i class="fa fa-circle" aria-hidden="true"></i> Online</p><p style='display:inline;' class='offline' id='offline2'><i class="fa fa-circle" aria-hidden="true"></i> Offline</p</td>
</tr>
<tr>
	<td><p style='display:inline;'>Sensor 3: </p></td>
	<td><p style='display:inline;' class='online' id='online3'><i class="fa fa-circle" aria-hidden="true"></i> Online</p><p style='display:inline;' class='offline' id='offline3'><i class="fa fa-circle" aria-hidden="true"></i> Offline</p></td>
</tr>
<tr>
	<td><p style='display:inline;'>Sensor 4: </p></td>
	<td><p style='display:inline;' class='online' id='online4'><i class="fa fa-circle" aria-hidden="true"></i> Online</p><p style='display:inline;' class='offline' id='offline4'><i class="fa fa-circle" aria-hidden="true"></i> Offline</p></td>
</tr>
</table>
</div>
</div>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable({
			"order": [[ 2, "desc" ]]
		});
    } );
</script>

<script>

setInterval(function(){ 

checkStatus();

}, 2000);

function checkStatus() {
	
    let queryParams = new URLSearchParams(window.location.search);
    let city = queryParams.get('city');

    //anzahl sensoren
	for(let i = 0; i < 4; i++){
		let id = i+1;
		
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		let currentTime =  Math.round((new Date()).getTime() / 1000);
		let lastOnline = this.responseText;
		
		let diff = currentTime-lastOnline;
		
		if(diff > 5){
			 document.getElementById("online"+id).style.display = 'none';
			 document.getElementById("offline"+id).style.display = 'contents';
		}
		else{
			 document.getElementById("online"+id).style.display = 'contents';
			 document.getElementById("offline"+id).style.display = 'none';
		}
		
		if(id == 4){
			document.getElementById("sensorState").style.display = 'contents';
		}
     
     
    }
  };
  xhttp.open("GET", "functions/checkStatus.php?sensorID="+id+"&cityID="+city, true);
  xhttp.send();
		
	}
  
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>


</body>
</html>

