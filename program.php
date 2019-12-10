<?php

include('head.php')
?>
<link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
<script src="js/test.js"></script>
<body>
<?php include('navbar.php')?>
<div class="container-fluid">
    <div class="bg-light row justify-content-center">
        <div class="col-sm-5">
                <div class="">
                <form action="saveProgram.php" method="POST" >
                    <label class="label" for="out">Salida</label>
                    <select class="mdb-select form-control md-form colorful-select dropdown-primary" name="out">
                        <option value="0">Iluminación 1</option>
                        <option value="1">Iluminación 2</option>
                        <option value="2">Led placa</option>
                        <option value="3">Bomba de agua 2</option>
                        <option value="4">Extractor</option>
                        <option value="5">Ventilador</option>
                        <option value="6">Auxiliar 1</option>
                        <option value="7">Auxiliar 2</option>
                    </select>
                    <label class="label" for="days">Dias</label>
                    <select class="mdb-select form-control md-form colorful-select dropdown-primary" name="days">
                        <option value="7">Todos los días</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="0">Domingo</option>
                    </select>
                    <br>
                    <label class="mdb-main-label " for="hour_on">Hora encendido</label>
                    <input placeholder="Selected time" type="time" class="form-control" name="hour_on">
                    <label class="mdb-main-label" for="hour_off">Hora apagado</label>
                    <input placeholder="Selected time" type="time" class="form-control" name="hour_off">
                    <br>
                    <button type="submit" class="btn btn-primary" value="submit">Submit</button>
                </form>
                </div>
        </div>
    </div>
    <div class="container-fluid height-bar"></div>
</div>

<?php include('footer.php')?>


