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

  function searchByEmail($email) {
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

      $consulta = $this->dataBase->prepare("INSERT into measurements values (null, :id_device, :temperature, :humidity, :soil_humidity_1, default)");
      $consulta->bindValue(':id_device',$idDevice,PDO::PARAM_INT);
      $consulta->bindValue(':temperature',$temperature ,PDO::PARAM_INT);
      $consulta->bindValue(':humidity',$humidity ,PDO::PARAM_INT);
      $consulta->bindValue(':soil_humidity_1',$soil_humidity_1 ,PDO::PARAM_INT);
      $consulta->execute();

  }

  public function getPrograms($data){
    $device_id = $data["device_id"];
    $query = $this->dataBase->prepare("SELECT * FROM programs where device_id = :device_id");
    $query->bindValue(':device_id',$device_id,PDO::PARAM_INT);
    $query->execute();
    $programs = $query->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($programs);
  }

  public function getOutputs($data){
    $device_id = $data["device_id"];
    $query = $this->dataBase->prepare("SELECT * FROM outputs where device_id = :device_id");
    $query->bindValue(':device_id',$device_id,PDO::PARAM_INT);
    $query->execute();
    $outputs = $query->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($outputs as $index => $output) {
      $on = $output['hour_on']; //saca array de string
      $on = substr($on, 1, strlen($on)-2); //saca primer corchete y ultimo
      $array = explode(",", $on); //separa valores por coma y transforma en array
    foreach ($array as $key => $value) { 
        $array[$key] = $value; //tranforma en array
    }
    $output['hour_on'] = $array; //guarda array de strings

    $on = $output['hour_off'];
    $on = substr($on, 1, strlen($on)-2);
    $array = explode(",", $on);
    foreach ($array as $key => $value) {
        $array[$key] = $value;
    }
    $output['hour_off'] = $array;

    $on = $output['days'];
    $on = substr($on, 1, strlen($on)-2);
    $array = explode(",", $on);
    foreach ($array as $key => $value) {
        $array[$key] = $value;
    }
    $output['days'] = $array;
    $outputs[$index] = $output;
    }

    $json = json_encode($outputs);
    return $json;

  }
  public function getOut($data){
    $program_id = $data["program_id"];
    if(isset($data["out_num"])){
      $out = $data["out_num"];
      $string = "SELECT * FROM outputs where `program_id`= :program_id and `out` = :out";
    } else {
      $string = "SELECT * FROM outputs where `program_id` = :program_id";
    }
    
    $query = $this->dataBase->prepare($string);
    $query->bindValue(':program_id',$program_id,PDO::PARAM_INT);
    if(isset($data["out_num"])){
      $query->bindValue(':out',$out,PDO::PARAM_INT);
    }
    $query->execute();
    $output = $query->fetch(PDO::FETCH_ASSOC);

    if($output){
      $on = $output['hour_on']; //saca array de string
      $on = substr($on, 1, strlen($on)-2); //saca primer corchete y ultimo
      $array = explode(",", $on); //separa valores por coma y transforma en array
      foreach ($array as $key => $value) { 
          $array[$key] = $value; //tranforma en array
      }
      $output['hour_on'] = $array; //guarda array de strings
  
      $on = $output['hour_off'];
      $on = substr($on, 1, strlen($on)-2);
      $array = explode(",", $on);
      foreach ($array as $key => $value) {
          $array[$key] = $value;
      }
      $output['hour_off'] = $array;
  
      $on = $output['days'];
      $on = substr($on, 1, strlen($on)-2);
      $array = explode(",", $on);
      foreach ($array as $key => $value) {
          $array[$key] = $value;
      }
      $output['days'] = $array;
      
    } else {
      $output = "";
    }
    $json = json_encode($output);
    return $json;
  }

  public function updateOutput($data){
    $output_id = 0; 
    $out = 0;
    $days = "";
    $hour_on = "";
    $hour_off = "";
    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "output_id") !== false) {
        $output_id = $data[$i]->value;
      break;
      }
    }
    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "out") !== false) {
        $out = $data[$i]->value;
      }
    }

    for ($i=0; $i < sizeOf($data); $i++) { 
        if (strpos($data[$i]->name, "hour_on") !== false) {
          $hour_on = $hour_on.",".$data[$i]->value;
        }
    }
    $hour_on = substr($hour_on,1);
    $hour_on = '['.$hour_on.']';

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "hour_off") !== false) {
        $hour_off = $hour_off.",".$data[$i]->value;
      }
    }
    $hour_off = substr($hour_off,1);
    $hour_off = '['.$hour_off.']';

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "day") !== false) {
        $days = $days.",".$data[$i]->value;
      }
    }
    $days = substr($days,1);
    $days = '['.$days.']';
    
    if ($days == '[7]') {
      $timerMode = 1; //PER_DAY = 0, DAILY = 1, PERIOD_DAILY = 2
    } else {
      $timerMode = 0;
    }

    $query = $this->dataBase->prepare("UPDATE outputs SET hour_on = '$hour_on', hour_off = '$hour_off', days = '$days', timerMode = '$timerMode' where id = '$output_id'");
    $response = $query->execute();
    return $response;

  }

  public function newOutput($data){
    $program_id = 0;
    $out = 0;
    $days = "";
    $hour_on = "";
    $hour_off = "";
    $now = date("Y-m-d h:i:s");
    $sensor_id = 0; //TODO
    $max_sensor = 0; //TODO
    $min_sensor = 0; //TODO
    $period = 0; //TODO
    $duration = 0; //TODO

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "program") !== false) {
        $program_id = $data[$i]->value;
      }
    }

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "out") !== false) {
        $out = $data[$i]->value;
      }
    }

    for ($i=0; $i < sizeOf($data); $i++) { 
        if (strpos($data[$i]->name, "hour_on") !== false) {
          $hour_on = $hour_on.",".$data[$i]->value;
        }
    }
    $hour_on = substr($hour_on,1);
    $hour_on = '['.$hour_on.']';

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "hour_off") !== false) {
        $hour_off = $hour_off.",".$data[$i]->value;
      }
    }
    $hour_off = substr($hour_off,1);
    $hour_off = '['.$hour_off.']';

    for ($i=0; $i < sizeOf($data); $i++) { 
      if (strpos($data[$i]->name, "day") !== false) {
        $days = $days.",".$data[$i]->value;
      }
    }
    $days = substr($days,1);
    $days = '['.$days.']';
    
    if ($days == '[7]') {
      $timerMode = 1; //PER_DAY = 0, DAILY = 1, PERIOD_DAILY = 2
    } else {
      $timerMode = 0;
    }

    $query = $this->dataBase->prepare("INSERT INTO outputs VALUES (default, :program_id, :out, :hour_on , :hour_off, :days, :timerMode, :created_at, :modified_at, :sensor_id, :max_sensor, :min_sensor, :period, :duration)");
    $query->bindValue(':program_id',$program_id,PDO::PARAM_INT);
    $query->bindValue(':out',$out,PDO::PARAM_INT);
    $query->bindValue(':hour_on',$hour_on,PDO::PARAM_STR);
    $query->bindValue(':hour_off',$hour_off,PDO::PARAM_STR);
    $query->bindValue(':days',$days,PDO::PARAM_STR);
    $query->bindValue(':timerMode',$timerMode,PDO::PARAM_INT);
    $query->bindValue(':created_at',$now,PDO::PARAM_STR);
    $query->bindValue(':modified_at',$now,PDO::PARAM_STR);
    $query->bindValue(':sensor_id',$sensor_id,PDO::PARAM_INT);
    $query->bindValue(':max_sensor',$max_sensor,PDO::PARAM_INT);
    $query->bindValue(':min_sensor',$min_sensor,PDO::PARAM_INT);
    $query->bindValue(':period',$period,PDO::PARAM_INT);
    $query->bindValue(':duration',$duration,PDO::PARAM_INT); 
    $response = $query->execute();
    return $response;

  }

  public function getDevices($userID){
    $query = $this->dataBase->prepare("SELECT * FROM devices where user_id = :user_id");
    $query->bindValue(':user_id',$userID,PDO::PARAM_INT);
    $query->execute();
    $response = $query->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($response);
  }

  function getNames() {
    $query = $this->dataBase->prepare("SELECT * FROM days_names ORDER BY ID" );
    $query->execute();
    $days_names = $query->fetchAll(PDO::FETCH_COLUMN, 1);
    
    $query = $this->dataBase->prepare("SELECT * FROM outputs_names ORDER BY ID");
    $query->execute();
    $outputs_names = $query->fetchAll(PDO::FETCH_COLUMN, 1);

    $result[0] = $days_names;
    $result[1]= $outputs_names;
  
    return json_encode($result);
  }

}
?>
