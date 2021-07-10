<?php
/**
 * By Pavel Tyulnev
 * 09.03.2021
 *
 * Falls es einer mal liest:
 * dieser Code ist ziemlich chaotisch und wird mit der Zeit verbessert.
 * Verbesserungen sind willkommen
 */
$path = $_GET['path'];
$fileIndex = $_GET['index'];
$path = urldecode($path);

$files = scandir($path);
$foundFile = $files[$fileIndex];

$size = sizeof($files);

$imagePath = $path . '/' . $foundFile;
$timestamp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $foundFile);
$timestamp = $timestamp + 3600;

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
$encodedPath =  urlencode($path);
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