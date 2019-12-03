<?php


include_once("../clases/dbmysql.php");
$db = new DBMySQL("../credenciales.json");

if($_POST){
    $data = $_POST;
    $db->saveProgram($data);

}

header("Location:../main.php");exit;

?>