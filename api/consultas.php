<?php
include("pdo.php");

$consulta = $baseDatos->query("select * from devices");
// $consulta->execute();
// $peliculas  = $consulta->fetchAll(PDO::FETCH_ASSOC);
$devices = $consulta->fetchAll(PDO::FETCH_ASSOC);


?>