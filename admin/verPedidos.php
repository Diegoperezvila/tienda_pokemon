<?php
require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\ServerApi;
use MongoDB\BSON\UTCDateTime;

header("Content-Type: application/json");

try {
    $uri = 'mongodb+srv://celtadiego:CeltaVigo9@clase.dznbv.mongodb.net/?retryWrites=true&w=majority&appName=Clase';
    $apiVersion = new ServerApi(ServerApi::V1);
    $client = new Client($uri, [], ['serverApi' => $apiVersion]);

    $database = $client->selectDatabase('Tienda');
    $collection = $database->selectCollection('Pedidos');

    // Obtener el cuerpo de la petición
    $data = json_decode(file_get_contents("php://input"), true);
    $usuario = isset($data['usuario']) ? trim($data['usuario']) : "";
    $estado = isset($data['estado']) ? trim($data['estado']) : "";

    // Construir el filtro dinámicamente
    $filter = [];
    if (!empty($usuario)) {
        $filter['usuario'] = $usuario;
    }
    if (!empty($estado)) {
        $filter['estado'] = $estado;
    }

    // Ejecutar la consulta con el filtro
    $result = $collection->find($filter)->toArray();

    // Formatear la respuesta
    $pedidos = [];
    foreach ($result as $document) {
        $fecha = isset($document["fecha"]) && $document["fecha"] instanceof UTCDateTime
            ? $document["fecha"]->toDateTime()->format('d-m-Y H:i:s')
            : null; // Si no hay fecha, se devuelve null

        $pedidos[] = [
            "id" => (string) $document["_id"],
            "usuario" => $document["usuario"],
            "numeroCarta" => $document["numeroCarta"],
            "nombreCarta" => $document["nombreCarta"],
            "precioCarta" => $document["precioCarta"],
            "empresaEnvio" => $document["empresaEnvio"],
            "tipoEnvio" => $document["tipoEnvio"],
            "precioEnvio" => $document["precioEnvio"],
            "fecha" => $fecha,
            "imagen" => $document["imagen"],
            "estado" => $document["estado"]
        ];
    }

    // Enviar respuesta JSON
    echo json_encode(["status" => "success", "data" => $pedidos], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
