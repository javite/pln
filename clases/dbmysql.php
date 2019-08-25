<?php

include_once("db.php");
include_once("usuario.php");

class DBMySQL extends DB {
  protected $dataBase;

  public function __construct($cred) {

    $credenciales = file_get_contents($cred); //en $cred se pasa el nombre del archivo de credenciales.json
    $credenciales = json_decode($credenciales, true);
    $dsn = 'mysql:dbname=grower-lab;host=localhost;port=3306';
    $usuario = $credenciales["usuario"];
    $pass = $credenciales["password"];

    try {
      $this->dataBase = new PDO($dsn, $usuario, $pass);
      $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e) {
      echo "Error in database connection.";exit;
    }
  }

  function crearUsuario(Usuario $user) {
    $query = $this->dataBase->prepare("INSERT into users values (default, :name, :last_name, :user, :password,  :email, :token, :created_at, :modified_at)");
    $now = date("Y-m-d h:i:s");
    $query->bindValue(":name", $user->getName());
    $query->bindValue(":last_name", $user->getLast_name());
    $query->bindValue(":user", $user->getUser());
    $query->bindValue(":password", $user->getPassword());
    $query->bindValue(":email", $user->getEmail());
    $query->bindValue(":token", $user->getToken());
    $query->bindValue(":created_at", $now);
    $query->bindValue(":modified_at", $now);
    $query->execute();
  }

  function getUsers() {
    $query = $this->dataBase->prepare("SELECT * FROM users");
    $query->execute();
    $usersArray = $query->fetchAll(PDO::FETCH_ASSOC);
    $users = [];
    foreach ($usersArray as $userArray) {
      $users[] = new Usuario($userArray);
    }
    return $users;
  }

  function buscarPorEmail($email) {
    $query = $this->dataBase->prepare("SELECT * FROM users where email = :email");
    $query->bindValue(":email", $email);
    $query->execute();
    $userArray = $query->fetch(PDO::FETCH_ASSOC);
    if ($userArray == null) {
      return null;
    }
    return new Usuario($userArray);
  }

  function buscarPorID($id) {
    $consulta = $this->dataBase->prepare("SELECT * FROM users where id = :id");
    $consulta->bindValue(":id", $id);
    $consulta->execute();
    $usuarioArray = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($usuarioArray == NULL) {
      return NULL;
    }
    return new Usuario($usuarioArray);
  }

  function getLastMeasurement($device_id) {
    $consulta = $this->dataBase->prepare("SELECT * FROM measurements where device_id = :device_id ORDER BY ID DESC LIMIT 1 ");
    $consulta->bindValue(":device_id", $device_id);
    $consulta->execute();
    $measurement = $consulta->fetch(PDO::FETCH_ASSOC);
    return $measurement;
  }

  public function generalQuery(Object $obj) {
    $date_selected = strtotime($obj->date);
    $date_plus_1 = strtotime("+1 day", $date_selected);
    $today = date('Y-m-d H:i:s',$date_selected);
    $tomorrow = date('Y-m-d H:i:s',$date_plus_1);
    $query = $this->dataBase->prepare("SELECT * FROM $obj->table where device_id=$obj->device_id AND created_at BETWEEN '$today' AND '$tomorrow' ORDER BY ID DESC ");//LIMIT $obj->limit
    // var_dump($query);
    // $query->bindValue(":table", $obj->table);
    // $query->bindValue(":limit", $obj->limit);
    $query->execute();
    $outp = $query->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($outp);
  }

  public function saveMeasurement($data){
      $idDevice = $data->idDevice;
      $temperature = $data->temperature;
      $humidity = $data->humidity;
      $soil_humidity_1 = $data->soil_humidity_1;

      $consulta = $this->dataBase->prepare("insert into measurements values (null, :id_device, :temperature, :humidity, :soil_humidity_1, default)");
      $consulta->bindValue(':id_device',$idDevice,PDO::PARAM_INT);
      $consulta->bindValue(':temperature',$temperature ,PDO::PARAM_INT);
      $consulta->bindValue(':humidity',$humidity ,PDO::PARAM_INT);
      $consulta->bindValue(':soil_humidity_1',$soil_humidity_1 ,PDO::PARAM_INT);
      $consulta->execute();

  }
}

?>
