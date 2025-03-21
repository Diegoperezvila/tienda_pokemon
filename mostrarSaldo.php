<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

session_start();
$usuario = $_SESSION['usuario'];

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Usuarios');

    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = isset($data['nombre']) ? trim($data['nombre']) : "";

    $filter = ($nombre !== "") ? ['usuario' => $nombre] : ['usuario' => $usuario];

    $options = ['projection' => ['cartera' => 1, '_id' => 0]];

    $result = $collection->findOne($filter, $options);

    if ($result) {
        $cartera = isset($result['cartera']) ? (float) $result['cartera'] : 0.0;//Que cartea sea numerico
        echo json_encode(["status" => "success", "cartera" => $cartera], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
