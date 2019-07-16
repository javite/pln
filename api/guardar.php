<?php
include("../pdo.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
$idDevice = $data->idDevice;
$temperature = $data->temperature;
$humidity = $data->humidity;
$soil_humidity_1 = $data->soil_humidity_1;

$consulta = $baseDatos->prepare("insert into temperature values (null, :id_device, :temperature, :humidity, :soil_humidity_1)");
$consulta->bindValue(':id_device',$idDevice,PDO::PARAM_INT);
$consulta->bindValue(':temperature',$temperature ,PDO::PARAM_INT);
$consulta->bindValue(':humidity',$humidity ,PDO::PARAM_INT);
$consulta->bindValue(':soil_humidity_1',$soil_humidity_1 ,PDO::PARAM_INT);
$consulta->execute();
echo ($data->temperature);
echo ($data->idDevice);
http_response_code(200); 

?>
