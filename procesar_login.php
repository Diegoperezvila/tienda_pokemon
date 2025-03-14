<?php
require './vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

$uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
$apiVersion = new ServerApi(ServerApi::V1);
$client = new Client($uri, [], ['serverApi' => $apiVersion]);

$database = $client->selectDatabase('Tienda');
$collection = $database->selectCollection('Usuarios');

$input = json_decode(file_get_contents('php://input'), true);
$usuario = trim($input['usuario'] ?? '');
$password = trim($input['password'] ?? '');

if (empty($usuario) || empty($password)) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

$usuarioExistente = $collection->findOne(['usuario' => $usuario]);

if (!$usuarioExistente) {
    echo json_encode(["error" => "El usuario no existe"]);
    exit;
}

if (!password_verify($password, $usuarioExistente['password'])) {
    echo json_encode(["error" => "Contraseña incorrecta"]);
    exit;
}

session_start();
$_SESSION['usuario'] = $usuario;
$_SESSION['rol'] = $usuarioExistente['rol'];

if ($usuarioExistente['rol'] === 'admin') {
    echo json_encode(["mensaje" => "Inicio de sesión exitoso", "redirect" => "./admin"]);
} else {
    echo json_encode(["mensaje" => "Inicio de sesión exitoso", "redirect" => "./"]);
}
?>
