<?php
require_once("init.php");

if(!$authentication->isLogged()){
    header("Location:login.php");exit;
}
$temperature = "";
$humidity = "";
$user = $_SESSION["user_email"]; //TODO guardar en cookies el user _id
$devices = json_decode($db->getDevices($_SESSION["user_ID"])); //devuelve los devices de ese usuario
$device_selected;
if($_GET){
    $device_selected = $_GET["device_id"];
} else {
    $device_selected = $devices[0]->id;
}
setcookie("device_id", $device_selected);
$_SESSION["device_id"] = $device_selected;
$measurement = $db->getLastMeasurement($device_selected);

include("head.php");
?>

<link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
<script src="js/moment.js"></script>
<script src="js/chart.js"></script>
<script src="js/functions.js"></script>
   
</head>
<body onload="loadData()">
    <div class="background-image"></div>
    <?php include('navbar.php')?>
    <div class="container-fluid">
        <div class="card-deck ">
            <div class="card shadow bg-light mb-3 text-center">
                <h5 class="card-header" id="titulo">Historial de Temperatura y Humedad ambiente</h5>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="temp_chart"></canvas>
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

    </div>
    <?php include('footer.php') ?>
</body>
</html>