<?php
// print date('H:i');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$hora = date('H:i');
$date = date('d/m/o');

switch (date('N')) {
        case '1':
        $dia = "lunes";
        break;
        case '2':
        $dia = "martes";
        break;
        case '3':
        $dia = "miércoles";
        break;
        case '4':
        $dia = "jueves";
        break;
        case '5':
        $dia = "viernes";
        break;
        case '6':
        $dia = "sábado";
        break;
        case '7':
        $dia = "domingo";
        break;   
    default:
        $dia = ":-)";
        break;
}
$date = $dia.", ".$date; 

session_start();
if(isset($_SESSION["usuario"])){
    $nombreUsuario = $_SESSION["usuario"];
} else {
    $nombreUsuario = "Ingresar";
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="30">
    <title>GROWER-LAB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400" rel="stylesheet">
</head>
<body>
    <div class="fondo">
            <img src="images/fondo4.jpg" alt="">
            <div class="contenedor-usuario">
                <i class="material-icons">account_circle</i>
                <a class="usuario" href="login.php"><?=$nombreUsuario?></a>
            </div>
            <div class= "contenedor-fecha">
                <p class="hora"><?=$hora?></p>
                <p class="fecha"><?=$date?></p>
            </div>
          
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>