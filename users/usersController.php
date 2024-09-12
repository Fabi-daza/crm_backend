<?php 
function agregarUsuario($conexion,$data){

    $name = $data['name'];
    $password = $data['password'];
    $email = $data['email'];
    $role_id = $data['role_id'];
    $query = "INSERT INTO users (name, password,email, role_id) VALUES (?,?,?,?)";

        try{
            $stmt = $conexion->prepare($query);
            $password_hash = password_hash($password,PASSWORD_BCRYPT);
            
            $stmt-> bindParam(1, $name);
            $stmt-> bindParam(2, $password_hash);
            $stmt-> bindParam(3, $email);
            $stmt-> bindParam(4, $role_id);

            $stmt->execute();
            echo json_encode(['success' => 'Usuario agregado exitosamente']);

        } catch(Exception $e){
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }
}

function getUserById($conexion,$id){
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
}

function getAllUsers($conexion){
    $query = 'SELECT * FROM users';
    try{
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => 'Consulta exitosa', 'data' => $data]);
    }catch(Exception $e){
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
}