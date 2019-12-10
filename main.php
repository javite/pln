<?php
require_once("init.php");
$temperature = "";
$humidity = "";
$measurement = $db->getLastMeasurement(1);

include("head.php");
?>

<link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
<script src="js/moment.js"></script>
<script src="js/chart.js"></script>
<script src="js/test.js"></script>
   
</head>
<body onload="loadData()">
    <div class="background-image"></div>
    <?php include('navbar.php')?>
        <div class="container-fluid">
            <div class="card-deck">
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-left">Temperatura</h4>
                                <h5 class="text-left">ambiente</h5>
                            </div>
                            <div class="card-value col">
                                <h3 class="card-text"><?=$measurement["temperature"]?>ºC</h3>
                                <img src="images/thermometer.svg" id="img-temp"alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted text-left">Actualizado: <?=$measurement["created_at"]?></small>
                    </div>
                </div>
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-left">Humedad</h4>
                                <h5 class="text-left">ambiente</h5>
                            </div>
                            <div class="card-value col">
                                <h3 class="card-text"><?=$measurement["humidity"]?>%</h3>
                                <img src="images/drop.svg" id="img-hum"alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted text-left">Actualizado: <?=$measurement["created_at"]?></small>
                    </div>
                </div>
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-left">Humedad</h4>
                                <h5 class="text-left">de tierra</h5>
                            </div>
                            <div class="card-value col">
                                <h3 class="card-text"><?=$measurement["soil_humidity_1"]?>%</h3>
                                <img src="images/soil_hum.svg" id="img-soil"alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted text-left">Actualizado: <?=$measurement["created_at"]?></small>
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
                        <div class="container-fluid">
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
                        <img class="lamp" src="images/lamp.png" alt="Card image cap">
                        <h4 class="card-text text-success mb-3">Encendida</h4>
                        <a href="#" class="btn btn-secondary mb-2">Apagar</a>
                    </div>
                </div>

                <div class="card  text-success bg-dark mb-3 text-center">
                    <h5 class="card-header">Riego</h5>
                    <div class="card-body">
                        <img class="lamp" src="images/riego.png" alt="Card image cap">
                        <h4 class="card-text text-success mb-3">Apagado</h4>
                        <a href="#" class="btn btn-secondary mb-2">Encender</a>
                    </div>
                </div>

                <div class="card text-success bg-dark mb-3 text-center">
                    <h5 class="card-header">Ventilador</h5>
                    <div class="card-body">
                        <img class="lamp" src="images/ventilador.png" alt="Card image cap">
                        <h4 class="card-text text-success mb-3">Encendido</h4>
                        <a href="#" class="btn btn-secondary mb-2">Apagar</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid height-bar"></div>
        </div>
<?php include('footer.php') ?>