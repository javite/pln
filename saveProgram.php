<?php


include_once("clases/dbmysql.php");
$db = new DBMySQL("credenciales.json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
echo $db->saveProgram($data);
// header("Location:main.php");exit;
// header("Location:program.php");exit;


?>