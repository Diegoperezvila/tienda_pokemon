<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

$uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
$apiVersion = new ServerApi(ServerApi::V1);
$client = new Client($uri, [], ['serverApi' => $apiVersion]);

$database = $client->selectDatabase('Tienda');
$collection = $database->selectCollection('Usuarios');

$input = file_get_contents('php://input');
parse_str($input, $data);

if (
    empty($data['nombre']) || empty($data['apellido']) ||
    empty($data['usuario']) || empty($data['correo']) ||
    empty($data['password'])
) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

$nombre = trim($data['nombre']);
$apellido = trim($data['apellido']);
$usuario = trim($data['usuario']);
$correo = filter_var(trim($data['correo']), FILTER_VALIDATE_EMAIL);
$password = trim($data['password']);

if (!$correo) {
    echo json_encode(["error" => "Correo electrónico no válido"]);
    exit;
}

$usuarioExistente = $collection->findOne(['usuario' => $usuario]);

if ($usuarioExistente) {
    echo json_encode(["error" => "El nombre de usuario ya esta en uso"]);
    exit;
}

$correoExistente = $collection->findOne(['correo' => $correo]);

if ($correoExistente) {
    echo json_encode(["error" => "El correo electronico ya esta registrado"]);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

try {
    $resultado = $collection->insertOne([
        'nombre' => $nombre,
        'apellido' => $apellido,
        'usuario' => $usuario,
        'correo' => $correo,
        'rol' => 'usuario',
        'password' => $passwordHash,
        'cartera' => 0
    ]);

    if ($resultado->getInsertedCount() == 1) {
        echo json_encode(["mensaje" => "Registro exitoso", "usuario" => $usuario]);
    } else {
        echo json_encode(["error" => "No se pudo completar el registro"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
