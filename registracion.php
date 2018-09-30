<?php
$nombre = "";
$usuario = "";
$email = "";
$contraseña ="";
$confirmacion ="";
$mensajeNombre = "";
$mensajeUsuario = "";
$mensajeEmail = "";
$mensajecontraseña ="";
$mensajeconfirmacion ="";
require_once("validaciones.php");
if($_POST){
$nombre = $_POST["nombre"];
$usuario = $_POST["username"];
if(!validarNombre()){
    $mensajeNombre = "El nombre esta vacío";
} else {
    $mensajeNombre = "";
}

if(!validarUsername()){
    $mensajeUsuario = "El username tiene que ser mayor a 5";
} else {
    $mensajeUsuario = "";
}

$mensajeEmail = validarEmail();
$email = $_POST["email"];
$mensajecontraseña = validarPass();
$contraseña = $_POST["contraseña"];
$confirmacion = $_POST["confirmacion"];

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <style>
    body{
        font-family: arial;
    }
    input{
        margin: 5px;
    }
    span {
        color: red;
        font-size: 11px;
    }
    </style>
    
</head>
<body>

<form action="index.php" method="post">
<div>
<label for="nombre">Nombre</label>
<input type="text" name="nombre" placeholder="nombre" value=<?=$nombre?>><span><?=$mensajeNombre?></span>
</div>
<div>
<label for="username">Usuario</label>
<input type="text" name="username" placeholder="usuario" value=<?=$usuario?>><span><?=$mensajeUsuario?></span>
</div>
<div>
<label for="email">Email</label>
<input type="text" name="email" placeholder="email" value=<?=$email?>><span><?=$mensajeEmail?></span>
</div>
<div>
<label for="contraseña">Contraseña</label>
<input type="password" name="contraseña" placeholder="contraseña" value=<?=$contraseña?>><span><?=$mensajecontraseña?></span>
</div>
<div>
<label for="confirmacion">Confirmacion</label>
<input type="password" name="confirmacion" placeholder="confirmacion" value=<?=$confirmacion?>>
</div>
<div>
<input type="submit">
</div>    
  
</form>
</body>
</html>