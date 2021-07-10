<?php
/**
 * By Pavel Tyulnev
 * 09.03.2021
 *
 * Falls es einer mal liest:
 * dieser Code ist ziemlich chaotisch und wird mit der Zeit verbessert.
 * Das ist gerade eher ein funktionaler Speedrun
 */

$camID = $_GET['camID'];
$city = $_GET['cityID'];
$live = $_GET['live'];

if ($city == 1) {
    $city = "dresden";
} else if ($city == 2) {
    $city = "muenster";
} else if ($city == 3) {
    $city = "wolfsburg";
}

//wenn es ein live event ist oder nur ein datum angegeben ist, dann hol nur das letzte Bild raus
if ($live == 1) {

    //definiere Datum heutigen Ordner 
    $date = time();
    //weil deutschland + 1h
    $timestamp = $date + 3600;
    $date = date('d_m_Y', $date);
    $date = strval($date);

    $path = '../images/' . $city . '/' . $camID . '/' . $date;
    $files = scandir($path, SCANDIR_SORT_DESCENDING);
    $actualImage = $files[0];
    $imagePath = $path . '/' . $actualImage;
    $timestamp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $actualImage);
    $timestamp += 3600;
    if ($actualImage) {
        echo "<div class='col-12'>
    <div class='card' >
    
        <img class='card-img-top' src='basedata/" . $imagePath . "' alt='Card image cap'>
         <p class='datestatus'>" . date('d. M. Y H:i:s', $timestamp) . "</p>
    </div>
    </div>";

    } else {

        echo "Keine Bilder vorhanden";
    }

} //wenn es ein get by date/time ist 
else {
    //hole das datum timestamp  (um zu wissen in welchen ordner man rein muss)
    $get_timestamp = $_GET['timestamp'];

    //wenn eine zeit angegeben wurde definiere die zeit in sekunden
    if ($_GET['timeextension'] >= 0) {
        $timeExtension = $_GET['timeextension'];
        $get_timestamp += $timeExtension;
        $get_timestamp -= 3600;

        //datum - ordner
        $date = date('d_m_Y', $get_timestamp);
        $date = strval($date);

        $path = '../images/' . $city . '/' . $camID . '/' . $date;
        $pattern = "/" . substr($get_timestamp, 0, -1) . "/i";

        //echo "PATTERN : " .$pattern;
        $scan = scandir($path);
        $size = sizeof($scan);

        $index = 0;
        foreach ($scan as $file) {
            if (!is_dir($path . "/" . $file)) {

                $timestampFile = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);

                if (preg_match($pattern, $timestampFile)) {
                    $foundFile = $file;

                    $fileIndex = $index;

                }
            }
            $index++;
        }

        //wenn nix gefunden wurde
        $searchdex = 0;
        $minusChar = -2;

        while (!isset($foundFile) && $searchdex < 8) {

            $pattern = "/" . substr($get_timestamp, 0, $minusChar) . "/i";
            $index = 0;
            $scan = scandir($path);
            foreach ($scan as $file) {
                if (!is_dir($path . "/" . $file)) {

                    $timestampFile = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);

                    if (preg_match($pattern, $timestampFile)) {
                        $foundFile = $file;

                        $fileIndex = array_search($file, $scan);
  
                    }
                }
                $index++;
            }
            $searchdex++;
            $minusChar--;
        }

        if($fileIndex == $size){
            $nextImg = $fileIndex;
        }
        if($fileIndex == 2){
            $preImg = $fileIndex;
        }
        else{
            $nextImg = $fileIndex + 1;
            $preImg = $fileIndex - 1;
        }


        $imagePath = $path . '/' . $foundFile;
        $timestamp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $foundFile);
        $timestamp = $timestamp + 3600;
        $encodedPath =  urlencode($path);
        if (isset($foundFile)) {
            echo "<div class='col-12'>
            <div class='card' >
            
                <img class='card-img-top' src='basedata/" . $imagePath . "' alt='Card image cap'>
                 <p class='datestatus'>" . date('d. M. Y H:i:s', $timestamp) . "</p>            
                 <div class='row'>
                 <div class='col-6 backward'><i onmousedown='loadImageByIndex(\"".$encodedPath."\",".$preImg.");' class='fa fa-backward'></i></div>
                 <div class='col-6 forward'><i onmousedown='loadImageByIndex(\"".$encodedPath."\",".$nextImg.");' class='fa fa-forward'></i></div>
                 </div>
              
            </div>
            </div>";
        } else {
            echo "Es konnte nichts passendes gefunden werden";
        }


    } //wenn nur das datum angegeben wurde
    else {

        $date = date('d_m_Y', $get_timestamp);
        $date = strval($date);

        $path = '../images/' . $city . '/' . $camID . '/' . $date;
        $files = scandir($path, SCANDIR_SORT_DESCENDING);
        $size = sizeof($files);
        $fileIndex = array_search($file, $files);

        
       

        $actualImage = $files[0];
        $imagePath = $path . '/' . $actualImage;
        $timestamp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $actualImage);
        $timestamp += 3600;

        if($fileIndex == $size){
            $nextImg = $fileIndex;
        }
        if($fileIndex == 2){
            $preImg = $fileIndex;
        }
        else{
            $nextImg = $fileIndex + 1;
            $preImg = $fileIndex - 1;
        }

        $encodedPath = urlencode($path);
        if ($actualImage) {
            echo "<div class='col-12'>
        <div class='card' >
        
            <img class='card-img-top' src='basedata/" . $imagePath . "' alt='Card image cap'>
            <p class='datestatus'>" . date('d. M. Y H:i:s', $timestamp) . "</p>
            <div class='row'>
            <div class='col-6 backward'><i onmousedown='loadImageByIndex(\"".$encodedPath."\",".$preImg.");' class='fa fa-backward'></i></div>
            <div class='col-6 forward'><i onmousedown='loadImageByIndex(\"".$encodedPath."\",".$nextImg.");' class='fa fa-forward'></i></div>
            </div>
        </div>
        </div>";

        } else {

            echo "Keine Bilder vorhanden";
        }
    }

}