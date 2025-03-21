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
    $collection = $database->selectCollection('Usuarios');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['id']) || !isset($input['cartera'])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos requeridos"]);
        exit;
    }

    $id = new ObjectId($input['id']);
    $cartera = (float) $input['cartera'];
    $rol = $input['rol'] ?? null;

    $updateData = ['cartera' => $cartera];
    if ($rol !== null) {
        $updateData['rol'] = $rol;
    }

    $updateResult = $collection->updateOne(
        ['_id' => $id],
        ['$set' => $updateData]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el usuario. El ID proporcionado no fue encontrado o no se realizaron cambios."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
