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
$collection = $database->selectCollection('Aperturas');

// Encontrar las últimas 5 inserciones sin filtrar por usuario
try {
    // Limitar a los últimos 5 documentos insertados y ordenar por _id (que es incremental)
    $resultados = $collection->find(
        [],
        [
            'sort' => ['_id' => -1],  // Ordenamos por _id de forma descendente
            'limit' => 5              // Limitamos a las últimas 5 entradas
        ]
    );

    // Convertimos los resultados a un array
    $resultadosArray = iterator_to_array($resultados);

    // Comprobamos si encontramos resultados
    if (count($resultadosArray) > 0) {
        echo json_encode(["status" => "success", "data" => $resultadosArray]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontraron registros"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
