<?php

include_once("clases/model.php");

class Usuario extends Model {
  protected $table = "users";
  protected $id;
  protected $name;
  protected $last_name;
  protected $user;
  protected $password;
  protected $email;
  protected $token;

  public function __construct(Array $data) {
    if (isset($data["id"])) {
        $this->id = $data["id"];
        $this->password = $data["password"];
    } else {
        $this->password = password_hash($data["password"], PASSWORD_DEFAULT);
        $this->id = NULL;
    }
    $this->name = $data["name"];
    $this->last_name = $data["last_name"];
    $this->user = $data["email"];
    $this->email = $data["email"];
    $this->token = bin2hex(openssl_random_pseudo_bytes(64)); //para php 7 y superior bin2hex(random_bytes(64))
  }

  public static function create(Array $data) {
    global $db;
    $_user = new Usuario($data);
    $db->crearUsuario($_user);
    return $_user;
  }

  public function setId($id) {
      $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function setName($name) {
      $this->name = $name;
  }

  public function getName() {
    return $this->name;
  }

  public function setLast_name($last_name) {
      $this->last_name = $last_name;
  }

  public function getLast_name() {
    return $this->last_name;
  }

  public function setEmail($email) {
      $this->email = $email;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setUser($user) {
      $this->user = $user;
  }

  public function getUser() {
    return $this->user;
  }

  public function setToken($token) {
      $this->token = $token;
  }

  public function getToken() {
    return $this->token;
  }

  public function setPassword($password) {
      $this->password = $password;
  }

  public function getPassword() {
    return $this->password;
  }

  function getFoto() {
    $foto = glob("img/" . $this->getEmail() . "*")[0];
    return $foto;
  }
}

?>
