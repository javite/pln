<?PHP
$dsn = "mysql:dbname=groweb_db;host=127.0.0.1;port=3306";
$usuario = "root";
$pass = "";
try {
    $baseDatos = new PDO($dsn, $usuario, $pass);
    $baseDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e){
    var_dump($e->getMessage());exit;
}

?>