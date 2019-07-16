<?php

class Validator {
  function validarRegistracion($data_post) {
    global $db;

    $datosFinales = [];
    $errores = [];

    foreach ($data_post as $posicion => $dato) {
      $datosFinales[$posicion] = trim($dato);
    }

    // if ($_FILES["avatar"]["error"] != 0) {
    //   $errores["avatar"] = "Hubo un error en la carga";
    //   echo $errores["avatar"];
    // } else{
    //   $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    //   if ($ext != "jpg" && $ext != "png") {
    //     $errores["avatar"] = "Solo podes subir fotos jpg o png";
    //     echo $errores["avatar"];
    //   }
    // }

    if ($datosFinales["name"] == "") {
      $errores["name"] = "Hubo error en el nombre porque esta vacio";
    } else if (ctype_alpha($datosFinales["name"]) == false) {
      $errores["name"] = "Hubo error en el nombre porque tiene caracteres que no son alfabeticos";
    }

    if ($datosFinales["last_name"] == "") {
      $errores["last_name"] = "Hubo error en el apellido porque esta vacio";
    } else if (ctype_alpha($datosFinales["last_name"]) == false) {
      $errores["last_name"] = "Hubo error en el apellido porque tiene caracteres que no son alfabeticos";
    }

    if ($datosFinales["password"] == "") {
      $errores["password"] = "Hubo error en la contraseña porque esta vacia";
    }
    else if (strlen($datosFinales["password"]) < 8) {
        $errores["password"] = "La contraseña debe tener al menos 8 caracteres";
    }
    else if (!preg_match("#[0-9]+#", $datosFinales["password"])) {
        $errores["password"] = "La contraseña debe tener al menos un numero!";
    }
    else if (!preg_match("#[A-Z]+#", $datosFinales["password"])) {
        $errores["password"] = "La contraseña debe tener al menos una mayuscula!";
    }
    else if (!preg_match("#[a-z]+#", $datosFinales["password"])) {
        $errores["password"] = "La contraseña debe tener al menos una minuscula!";
    }

    if ($datosFinales["cpassword"] == "") {
      $errores["cpassword"] = "Hubo error en la confirmacion de contraseña porque esta vacia";
    }
    else if ( $datosFinales["cpassword"] != $datosFinales["password"] ) {
      $errores["cpassword"] = "La contraseña no verifica";
    }

    if ($datosFinales["email"] == "") {
      $errores["email"] = "Hubo error en el email porque esta vacio";
    }
    else if ( filter_var($datosFinales["email"], FILTER_VALIDATE_EMAIL) == false) {
      $errores["email"] = "El email no es un email";
    } else if ($db->buscarPorEmail($datosFinales["email"]) != NULL ) {
      $errores["email"] = "El email ya esta en uso";
    }
    return $errores;
  }

  function validarLogin($data_post) {
    global $db;

    $errores = [];
    $usuario = null;

    if ($data_post["email"] == "") {
      $errores["email"] = "Dejaste el email vacio";
    }
    else if ( filter_var($data_post["email"], FILTER_VALIDATE_EMAIL) == false) {
      $errores["email"] = "El email no es un email";
    } else {
      $usuario = $db->buscarPorEmail($data_post["email"]);

      if ($usuario == NULL) {
        $errores["email"] = "No existe usuario con ese email";
      }
    }

    if ($data_post["password"] == "") {
      $errores["password"] = "Dejaste la contraseña vacia";
    }

    if ($usuario != null && $data_post["password"] != "") {
      // VALIDAR QUE LA contraseña ESTE BIEN
      if (password_verify($data_post["password"], $usuario->getPassword()) == false) {
        $errores["password"] = "La contraseña no verifica";
      }

    }

    return $errores;
  }
}

?>
