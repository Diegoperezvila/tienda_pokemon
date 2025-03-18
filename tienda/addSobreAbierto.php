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
$collection = $database->selectCollection('Aperturas');

$input = file_get_contents('php://input');
parse_str($input, $data);

if (
    empty($data['nombreSobre']) || empty($data['nombreCarta']) ||
    empty($data['numero'])|| empty($data['img'])
) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

$nombreSobre = trim($data['nombreSobre']);
$nombreCarta = trim($data['nombreCarta']);
$numero = trim($data['numero']);
$img = trim($data['img']);

session_start();
    if (!isset($_SESSION['usuario'])) {
        echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
        exit;
    }

$usuario = $_SESSION['usuario'];

$usuarioExistente = $collection->findOne(['usuario' => $usuario]);

try {
    $resultado = $collection->insertOne([
        'usuario' => $usuario,
        'nombreSobre' => $nombreSobre,
        'nombreCarta' => $nombreCarta,
        'numero' => $numero,
        'img' => $img
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
