<?php

//hole die Cam id
$camID = $_GET['camID'];

//hole Stadt
$city = $_GET['city'];

//hole das Foto
$received = file_get_contents('php://input');


if($city == 1){
    $city = "dresden";
}
else if($city == 2){
    $city = "muenster";
}
else if($city == 3){
    $city = "wolfsburg";
}

//cam-id Ordner
$camDir = "images/".$city."/" . $camID ;

//definiere Datum Ordner
$dateDir = date('d_m_Y', time());


//wenn cam-id ordner nicht existiert
if (!file_exists($camDir)) {

    //erstelle cam id Ordner
    mkdir( "images/".$city."/" . $camID."/",0777);

    //erstelle Datum Ordner im Cam Ordner
    mkdir( "images/".$city."/" . $camID."/".$dateDir."/",0777);
}

//wenn cam ordner existiert check ob datum ordner existiert
else {
    if (!file_exists($camDir."/".$dateDir)) {
        //erstelle Datum Ordner im Cam Ordner
        mkdir( "images/".$city."/" . $camID."/".$dateDir."/",0777);
    }
}

//Ordner wo es hinkommt
$fileToWrite = "images/".$city."/" . $camID."/".$dateDir."/".time().".jpg";
file_put_contents($fileToWrite, $received);

