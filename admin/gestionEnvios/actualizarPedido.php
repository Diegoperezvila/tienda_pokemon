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

    // Validaciones
    if (!isset($input['id']) || !isset($input['estado'])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        exit;
    }

    $id = new ObjectId($input['id']);  // ID del pedido
    $estado = $input['estado'];        // Nuevo estado

    // Construcción del array de actualización
    $updateData = ['estado' => $estado]; // Se actualiza el estado del pedido

    // Actualizar el pedido con el nuevo estado
    $updateResult = $collection->updateOne(
        ['_id' => $id],                // Buscar el pedido por su ID
        ['$set' => $updateData]         // Establecer el nuevo estado
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Estado actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el estado. El ID proporcionado no fue encontrado o no se realizaron cambios."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
