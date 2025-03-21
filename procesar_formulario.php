<?php
require './vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nombre']) && isset($data['email']) && isset($data['mensaje'])) {
    $nombre = $data['nombre'];
    $email = $data['email'];
    $mensaje = $data['mensaje'];

    try {
        $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
        $apiVersion = new ServerApi(ServerApi::V1);
        $client = new Client($uri, [], ['serverApi' => $apiVersion]);

        $database = $client->selectDatabase('Tienda');
        $collection = $database->selectCollection('Tickets');

        $insertResult = $collection->insertOne([
            'nombre' => $nombre,
            'email' => $email,
            'mensaje' => $mensaje,
            'fecha' => new MongoDB\BSON\UTCDateTime(),//Guardar fecha UTC
        ]);

        if ($insertResult->getInsertedCount() === 1) {
            echo json_encode(["status" => "success", "message" => "Formulario enviado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo enviar el formulario"]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Faltan datos en el formulario"]);
}
?>
