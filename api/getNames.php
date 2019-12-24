<?php
include_once("../clases/dbmysql.php");
$db = new DBMySQL("../credenciales.json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$results = $db->getNames();
echo $results;
http_response_code(200);


?>
