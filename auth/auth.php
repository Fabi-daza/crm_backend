<?php 
require "../database/conexion.php";
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;


header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents("php://input"),true);
    $email = $data['email'];
    $password = $data['password'];
    $query = "SELECT * FROM users WHERE email = ?";

    $stmt = $conexion->prepare($query);
    $stmt-> bindParam(1, $email); 
    $stmt->execute();               
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if($user && password_verify($password, $user['password'])){
    $secret_key = "ABC";
    $issued_at = time();
    $expiration_time = $issued_at + 3600;
    $payload = [
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "data" => $user];
    $jwt = JWT::encode($payload,$secret_key, 'HS256');

        echo json_encode(['success' => true, 'message' => 'Login exitoso' , 'jwt' => $jwt]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }


}


