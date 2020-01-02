<?php
include_once("clases/dbmysql.php");
$db = new DBMySQL("credenciales.json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = $_POST;
echo $db->saveProgram($data);


?>