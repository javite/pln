<?php
include_once("../clases/dbmysql.php");
$db = new DBMySQL("../credenciales.json");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
$db->saveMeasurement($data);
echo ($data->temperature);
echo ($data->idDevice);
http_response_code(200); 

?>
