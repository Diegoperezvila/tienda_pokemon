<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Usuarios');

    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
        exit;
    }

    $usuario = $_SESSION['usuario'];
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['cartera']) || !is_numeric($input['cartera'])) {
        echo json_encode(["status" => "error", "message" => "Valor de cartera inválido"]);
        exit;
    }

    $cartera = floatval($input['cartera']);

    // Actualizar directamente por usuario
    $updateResult = $collection->updateOne(
        ['usuario' => $usuario],
        ['$set' => ['cartera' => $cartera]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se realizaron cambios en la cartera."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
