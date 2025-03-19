<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('PreciosCartas');

    // Verificar si se recibió el parámetro "type"
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['type']) || empty(trim($_POST['type']))) {
            echo json_encode(["status" => "error", "message" => "El tipo de rareza es obligatorio."]);
            exit;
        }

        $rareza = trim($_POST['type']); // Obtener y limpiar la rareza recibida

        // Buscar en MongoDB los documentos con la rareza especificada
        $result = $collection->findOne(["Rareza" => $rareza]);

        if ($result) {
            // Enviar el precio correspondiente
            echo json_encode([
                "status" => "success",
                "precio" => $result["Precio"]
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontró un precio para esa rareza."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
