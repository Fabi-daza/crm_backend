<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;


function login($conexion){
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

function getCredentials($conexion,$decoded){
    $id = $decoded->data->id;
    $query = 'SELECT * FROM users WHERE id = :id';
    try{
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC); 
        echo json_encode(['success' => 'Consulta exitosa', 'data' => $data]);

    }catch(Exception $e){
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
};