<?php
/*AUTENTICACION*/

class Auth {
  public function __construct() {
    session_start();
    if (isset($_COOKIE["user_email"]) && isset($_SESSION["user_email"]) == false) {
      $_SESSION["user_email"] = $_COOKIE["user_email"];
    }
  }

  public function login($email) {
    global $db;
    $user = $db->searchByEmail($email);
    $_SESSION["user_ID"] = $user->getId();
    $_SESSION["user_name"] = $user->getName();
    $_SESSION["user_email"] = $email;
  }

  public function logout() {
    session_destroy();
    setcookie("user_email", null, -1);
  }

  public function isLogged() {
    return isset($_SESSION["user_email"]);
  }

  public function userLogged() {
    global $db;
    return $db->searchByEmail($_SESSION["user_email"]); //devuelve un User
  }

}

?>
