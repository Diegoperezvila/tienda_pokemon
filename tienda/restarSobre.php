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
$collection = $database->selectCollection('Sobres');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($data['id'])) {
    echo json_encode(["error" => "No hay id"]);
    exit;
}

$id = trim($data['id']);
$objectId = new MongoDB\BSON\ObjectId($id);

try {
    $producto = $collection->findOne(['_id' => $objectId]);

    if ($producto) {
        if ($producto['stock'] > 0) {
            $resultado = $collection->updateOne(
                ['_id' => $objectId],
                ['$inc' => ['stock' => -1]]
            );

            if ($resultado->getModifiedCount() == 1) {
                echo json_encode(["mensaje" => "Stock actualizado con éxito"]);
            } else {
                echo json_encode(["error" => "No se pudo actualizar el stock"]);
            }
        } else {
            echo json_encode(["error" => "No hay stock disponible"]);
        }
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
