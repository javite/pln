<?php
$errores = [];
session_start();
function validarRegistracion($datosFinales) {
GLOBAL $errores;
validarAvatar();
validarNombre($datosFinales);
validarContraseña($datosFinales);
validarConfirmacion($datosFinales);
validarEmail($datosFinales);
return $errores;
}

function validarLogin($datosFinales){
GLOBAL $errores;
validarEmailExiste($datosFinales);
validarContraseña($datosFinales);
return $errores;
}


/* VALIDACION FOTO DE USUARIO */
function validarAvatar(){
    GLOBAL $errores;
    if(isset($_FILES["avatar"]["error"])){
  if ($_FILES["avatar"]["error"] != 0) {
    $errores["avatar"] = "Hubo un error en la carga";
    } else{
    $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    if ($ext != "jpg" && $ext != "png" && $ext != "jpeg") {
      $errores["avatar"] = "Solo podes subir fotos jpg, png o jpeg";
    }
  }
 } return $errores;
}

/* VALIDACION DE NOMBRE Y APELLIDO USUARIO */
function validarNombre ($datosFinales){
    GLOBAL $errores;
  if ($datosFinales["nombre"] == "") {
    $errores["nombre"] = "El nombre no puede estar vacio";
  } else if (ctype_alpha($datosFinales["nombre"]) == false) {
    $errores["nombre"] = "El nombre tiene caracteres que no son alfabeticos";
  }

  if ($datosFinales["apellido"] == "") {
    $errores["apellido"] = "El apellido no puede estar vacio";
  } else if (ctype_alpha($datosFinales["apellido"]) == false) {
    $errores["apellido"] = "El apellido tiene caracteres que no son alfabeticos";
  }
  return $errores;
}

/* VALIDACION DE CONTRASEÑA */
function validarContraseña($datosFinales){
    GLOBAL $errores;
  if ($datosFinales["contraseña"] == "") {
    $errores["contraseña"] = "La contraseña esta vacía";
  }
  else if (strlen($datosFinales["contraseña"]) < 8) {
      $errores["contraseña"] = "La contrasenia debe tener al menos 8 caracteres";
  }
  else if (!preg_match("#[0-9]+#", $datosFinales["contraseña"])) {
      $errores["contraseña"] = "La contrasenia debe tener al menos un numero!";
  }
  else if (!preg_match("#[A-Z]+#", $datosFinales["contraseña"])) {
      $errores["contraseña"] = "La contrasenia debe tener al menos una mayuscula!";
  }
  else if (!preg_match("#[a-z]+#", $datosFinales["contraseña"])) {
      $errores["contraseña"] = "La contrasenia debe tener al menos una minuscula!";
  }
  return $errores;
}

/* VALIDACION DE CONFIRMACION DE CONTRASEÑA */
function validarConfirmacion($datosFinales){
    GLOBAL $errores;
  if ($datosFinales["confirmacion"] == "") {
    $errores["confirmacion"] = "La confirmación de la contraseña esta vacía";
  }
  else if ( $datosFinales["confirmacion"] != $datosFinales["contraseña"] ) {
    $errores["confirmacion"] = "La contraseña y la confirmación no coinciden";
  }
  return $errores;
}

/* VALIDACION DE EMAIL*/
function validarEmail($datosFinales){
    GLOBAL $errores;
if ($datosFinales["email"] == "") {
    $errores["email"] = "El email no puede estar vacio";
  }
  else if ( filter_var($datosFinales["email"], FILTER_VALIDATE_EMAIL) == false) {
    $errores["email"] = "El email no es un email válido";
  } else if ( buscarPorEmail($datosFinales["email"]) != NULL ) {
    $errores["email"] = "El email ya esta en uso";
  }
return $errores;
}

function validarEmailExiste($datos){
    GLOBAL $errores;
    $usuario = buscarPorEmail($datos["email"]);
    if($usuario["email"] == NULL){
        $errores["email"] = "El email no existe";
    }
}

/* COMPARA CONTRASEÑA INGRESADA CON GUARDADA*/
function compararContraseña($datos){
    GLOBAL $errores;
    $usuario = buscarPorEmail($datos["email"]);
    if(!password_verify($datos["contraseña"],$usuario["contraseña"])){
        $errores = "Las contraseña no es valida";
    };
} return $errores;

function proximoId() {
  $json = file_get_contents("usuarios.json");
  if ($json == "") {
    return 1;
  }
  $usuarios = json_decode($json, true);
  $ultimo = array_pop($usuarios);
  return $ultimo["id"] + 1;
}

function armarUsuario($datos) {
  return [
    "id" => proximoId(),
    "nombre" => trim($datos["nombre"]),
    "apellido" => trim($datos["apellido"]),
    "contraseña" => password_hash($datos["password"], PASSWORD_DEFAULT),
    "email" => trim($datos["email"])
  ];
}

function crearUsuario($usuario) {
  $usuarios = file_get_contents("usuarios.json");
  $usuarios = json_decode($usuarios, true);
  if ($usuarios === NULL) {
    $usuarios = [];
  }
  $usuarios[] = $usuario;
  $usuarios = json_encode($usuarios);
  file_put_contents("usuarios.json", $usuarios);
}

function traerUsuarios() {
  $usuarios = file_get_contents("usuarios.json");
  $usuarios = json_decode($usuarios, true);
  return $usuarios;
}

function buscarPorEmail($email) {
 $usuarios= file_get_contents("usuarios.json");
 if ($usuarios == "") {
   return null;
 }
 $usuariosArray= json_decode($usuarios, true);
 foreach ($usuariosArray as $usuario){
   if($email==$usuario["email"]){
     return $usuario;
    }
  }
  return null;
}

function existeElUsuario($email) {
  if (buscarPorEmail($email) == null) {
    return false;
  }
  else {
    return true;
  }
}

function buscarPorId($id) {
 $usuarios= file_get_contents("usuarios.json");
 if ($usuarios == "") {
   return null;
 }
 $usuariosArray= json_decode($usuarios, true);
 foreach ($usuariosArray as $usuario){
   if($id==$usuario["id"]){
     return $usuario;
    }
  }
  return null;
}

//   if ( !isset($_POST["genero"]) ) {
//     $errores["genero"] = "No elegiste ningun genero";
//   }
//   $datosFinales["telefono"] = str_replace("-", "", $datosFinales["telefono"]);
//   if ($datosFinales["telefono"] == "") {
//     $errores["telefono"] = "Hubo error en el telefono porque esta vacio";
//   }
//   else if (is_numeric($datosFinales["telefono"]) == false) {
//     $errores["telefono"] = "El telefono debe ser un numero";
//   }
//   if ( !isset($_POST["pregunta-seguridad"]) ) {
//     $errores["pregunta-seguridad"] = "No elegiste ninguna pregunta de seguridad";
//   }

//   if ($datosFinales["respuesta-seguridad"] == "") {
//     $errores["respuesta-seguridad"] = "Hubo error en la respuesta de seguridad porque esta vacia";
//   }

//   if ($datosFinales["nacimiento"] == "") {
//     $errores["nacimiento"] = "La fecha de nacimiento esta vacia";
//   } else {
//     $age = date_diff(date_create($datosFinales["nacimiento"]), date_create('now'))->y;
//     if ($age < 18) {
//       $errores["nacimeinto"] = "Debe ser mayor de edad";
//     }
//   }
?>