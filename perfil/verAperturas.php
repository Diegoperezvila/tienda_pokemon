<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

session_start();

header("Content-Type: application/json");

$uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
$apiVersion = new ServerApi(ServerApi::V1);
$client = new Client($uri, [], ['serverApi' => $apiVersion]);

$database = $client->selectDatabase('Tienda');
$collection = $database->selectCollection('Aperturas');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit();
}

$usuario = $_SESSION['usuario'];

try {
    $resultados = $collection->find(
        ['usuario' => $usuario],
        [
            'sort' => ['_id' => -1] //Filtramos por recientes
        ]
    );

    $resultadosArray = iterator_to_array($resultados);

    if (count($resultadosArray) > 0) {
        echo json_encode(["status" => "success", "data" => $resultadosArray]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontraron registros para este usuario"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
