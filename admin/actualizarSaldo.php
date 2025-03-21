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

    $data = json_decode(file_get_contents("php://input"), true);
    $usuario = isset($data['usuario']) ? trim($data['usuario']) : "";
    $totalDevolver = isset($data['totalDevolver']) ? trim($data['totalDevolver']) : "";

    if (empty($usuario) || empty($totalDevolver)) {
        echo json_encode(["status" => "error", "message" => "Faltan parámetros para actualizar el saldo"]);
        exit();
    }
    $totalDevolver = floatval($totalDevolver);

    $updateResult = $collection->updateOne(
        ['usuario' => $usuario],
        ['$inc' => ['cartera' => $totalDevolver]]//Incrementamos el campo cartera con el total a devolver, no sobreescribimos
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
