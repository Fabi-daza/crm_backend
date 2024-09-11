<?php
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$host = $_ENV["DB_HOST"];
$database = $_ENV["DB_NAME"];
$username = $_ENV["DB_USER"];
$password = $_ENV["DB_PASS"];
$dsn = "mysql:host=".$host.";dbname=".$database;

try{
    $conexion = new PDO($dsn,$username,$password);
} catch(PDOException $e){
    echo $e->getMessage();
}
