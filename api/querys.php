<?php

include_once("../clases/dbmysql.php");
$db = new DBMySQL("../credenciales.json");

header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_GET["x"], false);
$results = $db->generalQuery($obj);
echo $results;
?>
