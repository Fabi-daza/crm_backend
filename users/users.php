<?php
require './usersController.php';
require "../database/conexion.php";
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'),true);

switch($method){
    case 'GET':
        echo "metodo get";
        break;
    case 'POST':
        agregarUsuario($conexion,$data);
        break;
    case 'PUT':
        echo "metodo put";
        break;
    case 'DELETE':
        echo "metodo delete";
}

