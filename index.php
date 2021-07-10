

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


    <title>Stadtauswahl</title>
    <style>
        body {

            margin-top: 100px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
		.card{
			text-align:center;
			margin-bottom:20px;
			border:black 1px solid;
		}
		.btn-primary{
			
			color: #000;
background-color: white;
border-color: #000;
text-align: center;
		}
		h1{
			
		text-align:center;}
    </style>
</head>
<body>
<h1>Stadtauswahl</h1>
<br>
<br>
<br>
<div class='row'>
<div class='col-sm-12 col-md-6 col-lg-4'>
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Dresden</h5>
  </div>
   <ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="camList.php?city=1&camID=1&live=1" class="btn btn-primary">Cam-Übersicht</a></li>
    <li class="list-group-item"> <a href="tempList.php?city=1" class="btn btn-primary">Temperatur</a></li>
  </ul>
</div>
</div>
<div class='col-sm-12 col-md-6 col-lg-4'>
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Münster</h5>
  </div>
   <ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="camList.php?city=2&camID=1&live=1" class="btn btn-primary">Cam-Übersicht</a></li>
    <li class="list-group-item"> <a href="tempList.php?city=2" class="btn btn-primary">Temperatur</a></li>

  </ul>
</div>
</div>
<div class='col-sm-12 col-md-6 col-lg-4'>
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Wolfsburg</h5>
  </div>
   <ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="camList.php?city=3&camID=1&live=1" class="btn btn-primary">Cam-Übersicht</a></li>
    <li class="list-group-item"> <a href="tempList.php?city=3" class="btn btn-primary">Temperatur</a></li>

  </ul>
</div>
</div>
</div>



</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>


</body>
</html>
