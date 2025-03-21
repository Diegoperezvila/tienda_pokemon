<?php
require '../../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;
use MongoDB\BSON\ObjectId;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Pedidos');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['id']) || !isset($input['estado'])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        exit;
    }

    $id = new ObjectId($input['id']);
    $estado = $input['estado']; 

    $updateData = ['estado' => $estado];

    $updateResult = $collection->updateOne(
        ['_id' => $id],
        ['$set' => $updateData]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Estado actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el estado."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
