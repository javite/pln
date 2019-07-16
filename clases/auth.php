<?php
/*AUTENTICACION*/

class Auth {
  public function __construct() {
    session_start();
    if (isset($_COOKIE["usuarioLogueado"]) && isset($_SESSION["usuarioLogueado"]) == false) {
      $_SESSION["usuarioLogueado"] = $_COOKIE["usuarioLogueado"];
    }
  }

  function login($email) {
    $_SESSION["usuarioLogueado"] = $email;
  }
  function logout() {
    session_destroy();
    setcookie("usuarioLogueado", null, -1);
  }

  function isLogged() {
    return isset($_SESSION["usuarioLogueado"]);
  }

  public function userLogged() {
    global $db;
    return $db->searchByEmail($_SESSION["usuarioLogueado"]); //devuelve un User
  }

}

?>
