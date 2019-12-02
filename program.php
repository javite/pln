<?php
include('head.php')
?>
<link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
<script src="./js/time.js"></script>
<body>
<?php include('navbar.php')?>
<div class="card-deck">
    <div class="card bg-light mb-0 text-center">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label class="mdb-main-label">Dias</label>
                    <select class="mdb-select md-form colorful-select dropdown-primary">
                        <option value="7">Todos los días</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="0">Domingo</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <label class="mdb-main-label" for="input_starttime">Hora encendido</label>
                        <input placeholder="Selected time" type="time" class="form-control">
                        <label class="mdb-main-label" for="input_starttime">Hora apagado</label>
                        <input placeholder="Selected time" type="time" class="form-control">
                    <!-- <img src="images/thermometer.svg" id="img-temp"alt=""> -->
                </div>
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted text-left">Actualizado: </small>
        </div>
    </div>
</div>
<?php include('footer.php')?>


