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
    $collection = $database->selectCollection('Sobres');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    $id = new ObjectId($input['id']);
    $nombre = $input['nombre'];
    $precio = floatval($input['precio']);
    $stock = intval($input['stock']);
    $api = $input['api'];

    if (!is_numeric($precio) || !is_numeric($stock)) {
        echo json_encode(["status" => "error", "message" => "El precio o el stock tienen un valor no válido."]);
        exit;
    }

    $updateResult = $collection->updateOne(
        ['_id' => $id],
        ['$set' => ['nombre' => $nombre, 'precio' => $precio, 'stock' => $stock, 'api' => $api]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Sobre actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el sobre. El ID proporcionado no fue encontrado o no se realizaron cambios."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
