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
    $collection = $database->selectCollection('Usuarios');

    // Obtener el cuerpo de la petición
    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = isset($data['nombre']) ? trim($data['nombre']) : "";

    // Si se proporciona un nombre, filtrar por usuario, si no, obtener todos
    $filter = ($nombre !== "") ? ['usuario' => $nombre] : [];
    
    $result = $collection->find($filter)->toArray();

    $usuarios = [];
    foreach ($result as $document) {
        $usuarios[] = [
            "id" => (string) $document["_id"],
            "usuario" => $document["usuario"],
            "rol" => $document["rol"],
            "cartera" => $document["cartera"]
        ];
    }

    // Enviar respuesta JSON
    echo json_encode(["status" => "success", "data" => $usuarios], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
