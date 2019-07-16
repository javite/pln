<?php

include_once("clases/db.php");
include_once("clases/usuario.php");

class DBMySQL extends DB {
  protected $dbUsuarios;

  public function __construct() {
    $credenciales = file_get_contents("credenciales.json");
    $credenciales = json_decode($credenciales, true);
    $dsn = 'mysql:dbname=grower-lab;host=localhost;port=3306';
    $usuario = $credenciales["usuario"];
    $pass = $credenciales["password"];

    try {
      $this->dbUsuarios = new PDO($dsn, $usuario, $pass);
      $this->dbUsuarios->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e) {
      echo "Error in database connection.";exit;
    }
  }

  function crearUsuario(Usuario $user) {
    $consult = $this->dbUsuarios->prepare("INSERT into users values (default, :name, :last_name, :user, :password,  :email, :token, :created_at, :modified_at)");
    $now = date("Y-m-d h:i:s");
    $consult->bindValue(":name", $user->getName());
    $consult->bindValue(":last_name", $user->getLast_name());
    $consult->bindValue(":user", $user->getUser());
    $consult->bindValue(":password", $user->getPassword());
    $consult->bindValue(":email", $user->getEmail());
    $consult->bindValue(":token", $user->getToken());
    $consult->bindValue(":created_at", $now);
    $consult->bindValue(":modified_at", $now);
    
    $consult->execute();
  }

  function traerUsuarios() {
    $consulta = $this->dbUsuarios->prepare("SELECT * FROM usuarios");
    $consulta->execute();
    $usuariosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $usuarios = [];
    foreach ($usuariosArray as $usuarioArray) {
      $usuarios[] = new Usuario($usuarioArray);
    }
    return $usuarios;
  }

  function buscarPorEmail($email) {
    $consulta = $this->dbUsuarios->prepare("SELECT * FROM users where email = :email");
    $consulta->bindValue(":email", $email);
    $consulta->execute();
    $usuarioArray = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($usuarioArray == null) {
      return null;
    }
    return new Usuario($usuarioArray);
  }

  function buscarPorID($id) {
    $consulta = $this->dbUsuarios->prepare("SELECT * FROM usuarios where id = :id");
    $consulta->bindValue(":id", $id);
    $consulta->execute();
    $usuarioArray = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($usuarioArray == NULL) {
      return NULL;
    }
    return new Usuario($usuarioArray);
  }
}

?>
