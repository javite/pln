<?php

include_once("../clases/dbmysql.php");
$db = new DBMySQL("../credenciales.json");
ob_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_GET["x"], false);
$results = $db->generalQuery($obj);
echo $results;
ob_end_flush();
?>
