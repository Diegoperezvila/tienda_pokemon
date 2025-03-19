<?php
require '../../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;

header("Content-Type: application/json");

$uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
$apiVersion = new ServerApi(ServerApi::V1);
$client = new Client($uri, [], ['serverApi' => $apiVersion]);

$database = $client->selectDatabase('Tienda');
$collection = $database->selectCollection('TiposEnvio');

$input = file_get_contents('php://input');
parse_str($input, $data);

if (empty($data['empresa']) || empty($data['tipo']) || empty($data['precio'])) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

$empresa = trim($data['empresa']);
$tipo = trim($data['tipo']);
$precio = floatval($data['precio']);

try {
    $resultado = $collection->insertOne([
        'Empresa' => $empresa,
        'Tipo' => $tipo,
        'Precio' => $precio,
    ]);

    if ($resultado->getInsertedCount() == 1) {
        echo json_encode(["mensaje" => "Registro exitoso"]);
    } else {
        echo json_encode(["error" => "No se pudo completar el registro"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
