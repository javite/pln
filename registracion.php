<?php

require_once("init.php");

$errores = [];
$nombreDefault = "";
$apellidoDefault = "";
$emailDefault = "";
$telefonoDefault = "";
$respuestaSDefault = "";

// Vine por POST?
if ( $_POST ) {
	// VALIDAR
	$errores = $validator->validarRegistracion($_POST);
	$nombreDefault = $_POST["name"];
	$apellidoDefault = $_POST["last_name"];
	$emailDefault = $_POST["email"];
	
	if (empty($errores) ) {
		// REGISTRAR
		$user = new Usuario($_POST);
		$db->crearUsuario($user);

		//GUARDAR LA FOTO

		// $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
		// move_uploaded_file($_FILES["avatar"]["tmp_name"], "img/" . trim($_POST["email"]) . "." . $ext);

		// REDIRIGIRLO
		header("Location:main.php");exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registración</title>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style_login.css">
	<meta charset="utf-8">
</head>
<body>
	<div class="fondo">
		<img src="images/logo_grower-lab.svg" alt="">
		<div class="login-form">
			<div class="main-div">
				<div class="panel">
					<h2>Registrate!</h2>
				</div>
				<form action="registracion.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<?php if ( isset($errores["name"]) ) : ?>
							<input type="text" class="error form-control" placeholder="Nombre *" value="" name="name" />
							<p class="mensaje-error"><?=$errores["name"]?></p>
						<?php else : ?>
							<input type="text" class="form-control" placeholder="Nombre *" value="<?=$nombreDefault?>" name="name" />
						<?php endif; ?>
					</div>
					<div class="form-group">
						<?php if ( isset($errores["last_name"]) ) : ?>
							<input type="text" class="error form-control" placeholder="Apellido *" value="" name="last_name" />
							<p class="mensaje-error"><?=$errores["last_name"]?></p>
						<?php else : ?>
							<input type="text" class="form-control" placeholder="Apellido *" value="<?=$apellidoDefault?>" name="last_name" />
						<?php endif; ?>
					</div>
					<div class="form-group">
						<?php if ( isset($errores["password"]) ) : ?>
							<input type="password" class="error form-control" placeholder="Contraseña *" value="" name="password" />
							<p class="mensaje-error"><?=$errores["password"]?></p>
						<?php else : ?>
							<input type="password" class="form-control" placeholder="Contraseña *" value="" name="password" />
						<?php endif; ?>
					</div>
					<div class="form-group">
						<?php if ( isset($errores["cpassword"]) ) : ?>
							<input type="password" class="error form-control" placeholder="Confirmar Contrasenia *" value="" name="cpassword" />
							<p class="mensaje-error"><?=$errores["cpassword"]?></p>
						<?php else : ?>
							<input type="password" class="form-control" placeholder="Confirmar Contraseña *" value="" name="cpassword" />
						<?php endif; ?>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Tu Email *" value="" name="email" />
					</div>
					<input type="file" class="file_control" placeholder="Tu Avatar *" value="Avatar" name="avatar" />
					<input type="submit" class="btn btn-primary"  value="Registrarse"/>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
