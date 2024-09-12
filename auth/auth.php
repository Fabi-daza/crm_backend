<?php 
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require "../database/conexion.php";
require '../vendor/autoload.php';
require './authController.php';


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        require '../middleware/validateToken.php';
        getCredentials($conexion,$decoded);
        break;
    case 'POST':
        login($conexion);
        break;
    case 'PUT':
        echo "metodo put";
        break;
    case 'DELETE':
        echo "metodo delete";
}





