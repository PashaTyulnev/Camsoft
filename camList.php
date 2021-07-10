<?php
/**
 * By Pavel Tyulnev
 * 09.03.2021
 *
 * Falls es einer mal liest:
 * dieser Code ist ziemlich chaotisch und wird mit der Zeit verbessert.
 * Verbesserungen sind willkommen
 */

setlocale(LC_TIME, "de_DE");

$city = $_GET['city'];
$camID_get = $_GET['camID'];
$cityID = $city;


if ($city == 1) {
    $city = "dresden";
} else if ($city == 2) {
    $city = "muenster";
} else if ($city == 3) {
    $city = "wolfsburg";
}

if (!isset($city)) {
    header("Location: http://foerster.solutions/basedata/");
}

function createCamTabs($city)
{
    global $cityID;
    $counter = 0;
    $total_items = count(glob("images/" . $city . "/*", GLOB_ONLYDIR));

    if ($total_items > 0) {
        $files = glob("images/" . $city . "/*", GLOB_ONLYDIR);
        foreach ($files as $file) {
            $camID = basename($file);

            if ($counter == 0) {
                echo "<li class='nav-item'><a class='nav-link active' onclick='loadImages(1);changeCamID(" . $camID . ")' class='nav-link' aria-current='page' id='cam" . $camID . "' >CAM-" . basename($file) . "</a></li>";
            } else {
                echo "<li class='nav-item'><a onclick='loadImages(1);changeCamID(" . $camID . ")' class='nav-link ' aria-current='page' id='cam" . $camID . "' >CAM-" . basename($file) . "</a></li>";
            }
            $counter++;
        }

    } else {

        echo "Keine Cams initialisiert";
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
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>


    <title>Cam-Übersicht</title>

    <style>
        body {

            margin-top: 100px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        a {
            transition: 0.5s;
        }

        a:hover {
            cursor: pointer;
            color: green;

            transition: 0.5s;
        }

        img, .card {
            max-width: 500px !important;
        }

        .datestatus {
            color: white;
            margin-left: 0px;
            padding-left: 8px;
            margin-top: -24px;
            background: #00000091;

        }

        .backward, .forward {
            text-align: center;

        }

        .fa {
            cursor: pointer;
            font-size:25px;
            padding-bottom:10px;
        }
        table,input{
            width:100%;
        }
        .blink_me {
            animation: blinker 1s linear infinite;
            color: red;
            padding-bottom: 5px;
            position: absolute;
            z-index: 2;
            margin-left: 7px;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .btn-block {
    display: block;
    width: 100%;
}
    </style>
</head>
<body onload='loadImages(1)'>
<h1>Cam-Übersicht</h1>
<a style='float:right;' href='http://foerster.solutions/basedata/'><i class="fa fa-arrow-left"></i> Zurück</a>
<br>

<ul class="nav nav-tabs">
    <?php createCamTabs($city); ?>
</ul>
<br>
<div class="blink_me" id='liveblinker'><i class="fa fa-circle"></i> LIVE</div>

<div class='row'>
    <div class='col-sm-12 col-lg-6'>
        <div id='imgContainer'>

        </div>
    </div>

    <div class='col-sm-12 col-lg-6'>
        <table style='margin-bottom:15px;margin-top:15px;'>
            <tr>
                <td>Eingabe Datum</td>
                <td>Eingabe Uhrzeit</td>
            </tr>
            <tr>
                <td><input type="date" id="date" name="date"></td>
                <td><input type="time" id="time" name="time"></td>
            </tr>
        </table>

        <button type="button" class="btn btn-primary btn-lg btn-block" style='margin-bottom:15px;" onclick=' loadImageByDate()
        ' onmousedown='loadImageByDate()'>Bild suchen</button>
        <p style='font-size:12px;'>Wenn nur das Datum ohne Zeit eingegeben wird, wird das letzte Bild des entsprechenden
            Tages geladen.</p>
        <p style='font-size:12px;'>Bei einer Zeitangabe wird das nächst-passendste Bild geladen.</p>

    </div>
</div>

<script>

    let query = new URLSearchParams(window.location.search);
    let live = query.get('live')

    //zeige das live bild an, wenn der live param 1 ist
    setInterval(function () {
        let q = new URLSearchParams(window.location.search);
        let live = q.get('live')
        if (live == 1) {
            loadImages(1)
        }
    }, 5000);


    function loadImages(live) {

        setTimeout(function () {

            document.getElementById('liveblinker').style.display = 'block';
            // Construct URLSearchParams object instance from current URL querystring.
            var queryParams = new URLSearchParams(window.location.search);
            let camID = queryParams.get('camID')
            let cityID = queryParams.get('city')

            // Set new or modify existing parameter value. 
            queryParams.set("camID", camID);
            history.replaceState(null, null, "?" + queryParams.toString());

            /*
            console.log("CITY" + cityID);

            console.log("CAM" + camID);

            console.log("TIME" + cityID);

            */
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById("imgContainer").innerHTML = this.response;

                    let allNav = document.getElementsByClassName("nav-link");

                    for (var i = 0; i < allNav.length; i++) {

                        allNav[i] = allNav[i].classList.remove("active");
                    }

                    document.getElementById("cam" + camID).classList.add("active");

                }

            };

            xhttp.open("GET", "functions/loadImages.php?camID=" + camID + "&cityID=" + cityID + "&live=" + live, true);
            xhttp.send();

        }, 500);


    }

    function changeCamID(newID) {


        // Construct URLSearchParams object instance from current URL querystring.
        var queryParams = new URLSearchParams(window.location.search);

        // Set new or modify existing parameter value. 
        queryParams.set("camID", newID);
        history.replaceState(null, null, "?" + queryParams.toString());

        location = location
    }


    function loadImageByDate() {


        document.getElementById('liveblinker').style.display = 'none';
        setTimeout(function () {
            let queryParams = new URLSearchParams(window.location.search);
            let camID = queryParams.get('camID')
            let cityID = queryParams.get('city')

            // live auf 0 (ist ja nicht mehr live sondern ein bestimmter Zeitpunkt) 
            queryParams.set("live", '0');
            history.replaceState(null, null, "?" + queryParams.toString());

            //bestimme das gewünschte Datum
            let date = document.getElementById('date').value;
            let time = document.getElementById('time').value;
            let unixTimestamp = new Date(date).getTime() / 1000
            let timeExtension;

            if (time !== '') {
                let timeSplit = time.split(':');
                let hours = parseInt(timeSplit[0]);
                let minutes = parseInt(timeSplit[1]);
                timeExtension = (hours * 60 * 60) + (minutes * 60);
            }


            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById("imgContainer").innerHTML = this.response;

                }

            };

            xhttp.open("GET", "functions/loadImages.php?camID=" + camID + "&cityID=" + cityID + "&live=0&timestamp=" + unixTimestamp + "&timeextension=" + timeExtension, true);
            xhttp.send();

        }, 500);
    }

 
        function loadImageByIndex(path, index) {

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById("imgContainer").innerHTML = this.response;

                    }

                };

                xhttp.open("GET", "functions/loadImageByIndex.php?path=" + path + "&index=" + index, true);
                xhttp.send();
         
        }
    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>


</body>
</html>

