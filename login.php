<?php
include_once("funciones.php");
$datosFinales = [];
$errores = [];
$email = "";
$contrasena ="";
$mensajeEmail = "";
$mensajeContrasena = "";

if(isset($_SESSION["usuario"])){
    header("Location:main.php");
    exit;
}

if($_POST){
foreach ($_POST as $posicion => $dato) {
    $datosFinales[$posicion] = trim($dato);
}
$errores = validarLogin($datosFinales);

if(empty($errores)){
    $errores = compararContraseña($datosFinales);  
    if(empty($errores)){
        $_SESSION["usuario"] = buscarPorEmail($datosFinales["email"])["nombre"];
        header("Location:main.php");
        exit;
    }
}

if(isset($errores["email"])){
    $mensajeEmail = $errores["email"];
}
if(isset($errores["contraseña"])){
    $mensajeContrasena = $errores["contraseña"];
}
}

?>

<!DOCTYPE html>
<html>
<head lang="es">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <!-- <script src="main.js"></script> -->
</head>

<body id="LoginForm">
    <div class="fondo">
    <img src="images/fondo4.jpg" alt="">
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Logueate</h2>
                    <p>Ingresa tu usuario y contraseña</p>
                </div>
                <form id="Login" action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" id="inputEmail" placeholder="email" value=<?=$email?>><span class="error"><?=$mensajeEmail?></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="contraseña" class="form-control" id="inputPassword" placeholder="Contraseña" value=<?=$contrasena?>><span class="error"><?=$mensajeContrasena?></span>
                    </div>
                    <div class="forgot">
                        <a href="registracion.php">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   
</body>
</html>