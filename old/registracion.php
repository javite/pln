<?php
$nombre = "";
$apellido= "";
$email = "";
$contraseña ="";
$confirmacion ="";
$mensajeNombre = "";
$mensajeApellido = "";
$mensajeEmail = "";
$mensajecontraseña ="";
$mensajeconfirmacion ="";
require_once("funciones.php");

if($_POST){
    $datosFinales = [];
    $errores = [];
    foreach ($_POST as $posicion => $dato) {
      $datosFinales[$posicion] = trim($dato);
    }

    $errores = validarRegistracion($datosFinales);

    $nombre = $datosFinales["nombre"];
    if(isset($errores["nombre"])){
    $mensajeNombre = $errores["nombre"];
    }
    $apellido = $datosFinales["apellido"];
    if(isset($errores["apellido"])){
    $mensajeApellido = $errores["apellido"];
    }
    $email = $datosFinales["email"];
    if(isset($errores["email"])){
    $mensajeEmail = $errores["email"];
    }
    $contraseña = $datosFinales["contraseña"];
    if(isset($errores["contraseña"])){
    $mensajecontraseña = $errores["contraseña"];
    }
    $confirmacion = $datosFinales["confirmacion"];
    if(isset($errores["confirmacion"])){
    $mensajeconfirmacion =$errores["confirmacion"];
    }

    if(empty($errores)){
     //Registrar usuarios
        $registroUsuario = armarUsuario($datosFinales);
        crearUsuario($registroUsuario);
        session_start();
        $_SESSION["usuario"] = $datosFinales["nombre"];
        header("Location:index.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registracion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    
</head>
<body>

<form action="registracion.php" method="post">
<div>
<label for="nombre">Nombre</label>
<input type="text" name="nombre" placeholder="nombre" value=<?=$nombre?>><span class="error"><?=$mensajeNombre?></span>
</div>
<div>
<label for="apellido">Apellido</label>
<input type="text" name="apellido" placeholder="apellido" value=<?=$apellido?>><span class="error"><?=$mensajeApellido?></span>
</div>
<div>
<label for="email">Email</label>
<input type="text" name="email" placeholder="email" value=<?=$email?>><span class="error"><?=$mensajeEmail?></span>
</div>
<div>
<label for="contraseña">Contraseña</label>
<input type="password" name="contraseña" placeholder="contraseña" value=<?=$contraseña?>><span class="error"><?=$mensajecontraseña?></span>
</div>
<div>
<label for="confirmacion">Confirmacion</label>
<input type="password" name="confirmacion" placeholder="confirmacion" value=<?=$confirmacion?>><span class="error"><?=$mensajeconfirmacion?></span>
</div>
<div>
<input type="submit">
</div>    
  
</form>
</body>
</html>