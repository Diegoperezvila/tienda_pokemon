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
    $collection = $database->selectCollection('PreciosCartas');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    $id = new ObjectId($input['id']);
    $rareza = $input['rareza'];
    $precio = floatval($input['precio']);

    if (!is_numeric($precio)) {
        echo json_encode(["status" => "error", "message" => "El precio o el stock tienen un valor no válido."]);
        exit;
    }

    $updateResult = $collection->updateOne(
        ['_id' => $id],
        ['$set' => ['Rareza' => $rareza, 'Precio' => $precio]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Precio actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el precio."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
