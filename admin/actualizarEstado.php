<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;
use MongoDB\BSON\UTCDateTime;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Pedidos');

    $data = json_decode(file_get_contents("php://input"), true);
    $id = isset($data['id']) ? trim($data['id']) : "";
    $nuevoEstado = isset($data['estado']) ? trim($data['estado']) : "";

    if (empty($id) || empty($nuevoEstado)) {
        echo json_encode(["status" => "error", "message" => "Faltan parámetros para actualizar el estado"]);
        exit();
    }

    $objectId = new \MongoDB\BSON\ObjectId($id);

    $updateResult = $collection->updateOne(
        ['_id' => $objectId],
        ['$set' => ['estado' => $nuevoEstado]]
    );

    // Comprobar si la actualización fue exitosa
    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Estado actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró el pedido o el estado ya está actualizado"]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
