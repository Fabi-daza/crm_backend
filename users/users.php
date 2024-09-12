<?php
require './usersController.php';
require "../database/conexion.php";
require '../middleware/validateToken.php';
 
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents('php://input'),true);
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = isset($request_uri[3]) ? $request_uri[3] : null;
$rol = $decoded->data->role_id;

switch($method){
    case 'GET':
        if($id && $rol === 2){
            getUserById($conexion,$id);
        }elseif($rol=== 1){
            getAllUsers($conexion);
        }else{
            echo json_encode(['error' => 'Error: No tienes los permisos correspondientes']);
        }
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

