<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$headers = apache_request_headers();

$jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '',$headers['Authorization']) : null;

if($jwt){
    try{
        $secret_key = "ABC";
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
    }catch(Exception $e){
        http_response_code(401);
        echo json_encode(array("message" => "Acceso denegado: Token inválido o expirado. " . $e->getMessage()));
        exit();
    };

}else{
    http_response_code(400);
    echo json_encode(array("message" => "Token no proporcionado."));
    exit();
}