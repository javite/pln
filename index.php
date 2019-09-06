<?php

require_once("init.php");
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

if($authentication->isLogged()){
    $nombreUsuario = $_SESSION["usuarioLogueado"];
} else {
    $nombreUsuario = "Ingresar";
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta http-equiv="refresh" content="30"> -->
    <title>GROWER-LAB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400" rel="stylesheet">

</head>
<body>
    <!-- <img class="imagen-fondo" src="images/fondo4.jpg" alt=""> -->
    <div class="fondo vw-100">
        <div class="width">
            <div class="cont-date">
                <div class= "contenedor-fecha">
                    <p class="hora"><?=$hora?></p>
                    <p class="fecha"><?=$date?></p>
                </div>
            </div>
            <div class="contenedor-logo">
                <img class="logo" src="images/logo_grower-lab_white.svg" alt="">
            </div>
            <div class="cont-user">
                <div class="contenedor-usuario">
                    <i class="material-icons">account_circle</i>
                    <a class="usuario" href="login.php"><?=$nombreUsuario?></a>
                </div>
            </div>
         </div>  
    </div>

<script src="./js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>