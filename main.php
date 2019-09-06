<?php
require_once("init.php");
$temperature = "";
$humidity = "";
$measurement = $db->getLastMeasurement(1);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <title>GROWER-LAB</title>

    <!-- <meta name="theme-color" content="#F0DB4F"> -->
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">

  <!-- PWA config -->
  <link rel="manifest" href="manifest.json">
    <!-- iconos  -->
    <link rel="apple-touch-icon" href="images/icon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/icon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/grower-lab_180x180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="images/grower-lab_167x167.png">
	<!-- titulo icono -->
    <meta name="apple-mobile-web-app-title" content="Grower-lab">
    <!-- standalone -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- bar color  -->
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- splash  -->
    <link href="images/splashscreens/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="images/splashscreens/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

    <script src="js/moment.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/test.js"></script>
   
</head>
<body onload="loadData()">
    <div class="background-image">
    </div>

  
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
            <!-- <a class="navbar-brand" href="#">
                <img src="images/isologo_grower-lab.svg" class="logo-svg d-inline-block align-center"  alt="" >
            </a> -->
            <div class="w-5"></div>
            <span class="name-grower">grower-lab</span>
            <div class="contenedor-usuario">
                <a class="usuario" href="logout.php">
                    <i class="material-icons user-icon">account_circle</i>
                </a>
            </div>
            </div>
        </nav>
        <div class="container">
        <div class="card-deck">
                <div class="card bg-light mb-3 text-center">
                    <!-- <h5 class="card-header">Temp. Interna</h5> -->
                    <div class="card-body">
                        <div class="cont-text">
                            <h5 class="">Temperatura</h5>
                            <p class="">Interna</p>
                        </div>
                        <h1 class="card-text"><?=$measurement["temperature"]?>º</h1>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Actualizado: <?=$measurement["created_at"]?></small>
                    </div>
                </div>

                <div class="card bg-light mb-3 text-center">
                    <h5 class="card-header">Humedad Interna</h5>
                    <div class="card-body">
                        <!-- <h5 class="card-title">Humedad interna</h5> -->
                        <h1 class="card-text"><?=$measurement["humidity"]?>%</h1>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Actualizado: <?=$measurement["created_at"]?></small>
                    </div>
                </div>

                <div class="card bg-light mb-3 text-center">
                    <h5 class="card-header">Humedad de tierra</h5>
                    <div class="card-body">
                        <!-- <h5 class="card-title">Humedad interna</h5> -->
                        <h1 class="card-text"><?=$measurement["soil_humidity_1"]?>%</h1>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Actualizado: <?=$measurement["created_at"]?></small>
                    </div>
                </div>
        </div>
        <div class="card-deck ">
            <div class="card bg-light mb-3 text-center">
                <h5 class="card-header" id="titulo">Historial de Temperatura y Humedad ambiente</h5>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="myLineChart"></canvas>
                        <script src="js/line.js"></script>
                    </div>
                    <div class="container">
                        <div class="row justify-content-md-center">
                            <div class="input-group col-md-6">
                                <!-- <label for="date_chart1" class="text">Fecha</label> -->
                                <input type="date" class="form-control" id="date_chart_temp_hum" >
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="loadData()">Actualizar</button>
                                </div>
                                <div class="alert alert-warning" id="alerta" role="alert">
                                    <strong>UPS! </strong> No hay datos el dia seleccionado.
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Actualizado: <?=$measurement["created_at"]?></small>
                </div>
            </div>
        </div>
        <div class="card-deck">
            <div class="card  text-success bg-dark mb-3 text-center">
                <h5 class="card-header">Iluminación</h5>
                <div class="card-body">
                    <!-- <p class="card-title">Estado</p> -->
                    <img class="lamp" src="images/lamp.png" alt="Card image cap">
                    <h3 class="card-text text-success">Encendida</h3>
                    <a href="#" class="btn btn-secondary">Apagar</a>
                </div>
                <!-- <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div> -->
            </div>

            <div class="card  text-success bg-dark mb-3 text-center">
                <h5 class="card-header">Riego</h5>
                <div class="card-body">
                    <!-- <h5 class="card-title">Humedad interna</h5> -->
                    <img class="lamp" src="images/riego.png" alt="Card image cap">
                    <h3 class="card-text">Apagado</h3>
                    <a href="#" class="btn btn-secondary">Encender</a>
                </div>
                <!-- <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div> -->
            </div>

            <div class="card text-success bg-dark mb-3 text-center">
                <h5 class="card-header">Ventilador</h5>
                <div class="card-body">
                    <!-- <h5 class="card-title">Humedad interna</h5> -->
                    <img class="lamp" src="images/ventilador.png" alt="Card image cap">
                    <h3 class="card-text">Encendido</h3>
                    <a href="#" class="btn btn-secondary">Apagar</a>
                </div>
                <!-- <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div> -->
            </div>
        </div>
    </div>
    <footer class="footer container-fluid">
        <div class="container  d-flex justify-content-around">
            <a class="ref_menu" href="#">
                <img src="images/isologo_grower-lab.svg" class="icon_menu"alt="">
            </a>
            <a class="ref_menu" href="#">
                <img src="images/calendar.svg" class="icon_menu"alt="">
            </a>
            <a class="ref_menu" href="#">
                <img src="images/settings.svg" class="icon_menu"alt="">
            </a>
        </div>
    </footer>
    
    

<script src="/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>