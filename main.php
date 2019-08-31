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

    <meta name="theme-color" content="#F0DB4F">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">

    <link rel="manifest" href="manifest.json">
    <link rel="apple-touch-icon" href="images/logo_grower-lab.svg">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar" content="#2B2B2B">
    <!-- <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> -->
    <link rel="shortcut icon" type="image/png" href="images/logo_grower-lab.svg">
    <link rel="apple-touch-startup-image" href="images/logo_grower-lab.svg">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

    <script src="js/moment.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/test.js"></script>
   
</head>
<body onload="loadData()">
    <div class="background-image">
    </div>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <img src="images/isologo_grower-lab.svg" class="logo-svg d-inline-block align-center"  alt="" ><span class="navbar-brand name-grower">  GROWER-LAB</span>
            </a>
            <div class="contenedor-usuario">
                <i class="material-icons">account_circle</i>
                <a class="usuario" href="logout.php">logout</a>
            </div>
        </nav>

        <div class="card-deck">
                <div class="card bg-light mb-3 text-center">
                    <h5 class="card-header">Temp. Interna</h5>
                    <div class="card-body">
                        <!-- <p class="card-title">Interna</p> -->
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
    <footer class="footer mt-auto py-3 sticky">
        <div class="container">
            <span class="text-muted">
              <div class=""></div>
            </span>
        </div>
    </footer>
    
<script src="/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>