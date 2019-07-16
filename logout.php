<?php

require_once("init.php");

$authentication->logout();
header("Location:index.php");exit;


?>
