<?php
require '../../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Sobres');

    $result = $collection->find()->toArray();

    $sobres = [];
    foreach ($result as $document) {
        $sobres[] = [
            "id" => (string) $document["_id"],
            "nombre" => $document["nombre"],
            "api" => $document["api"],
            "img" => "../img/" . $document["img"],
            "precio" => $document["precio"],
            "stock" => $document["stock"]
        ];
    }

    echo json_encode(["status" => "success", "data" => $sobres], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
