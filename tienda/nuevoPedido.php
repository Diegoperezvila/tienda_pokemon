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
    $collection = $database->selectCollection('Pedidos');

    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
        exit;
    }

    $usuario = $_SESSION['usuario'];
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['numeroCarta']) || !isset($input['nombreCarta']) || !isset($input['precioCarta']) || !isset($input['empresaEnvio']) || !isset($input['tipoEnvio']) || !isset($input['precioEnvio'])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos en la solicitud"]);
        exit;
    }

    $numeroCarta = $input['numeroCarta'];
    $nombreCarta = $input['nombreCarta'];
    $precioCarta = floatval($input['precioCarta']);
    $empresaEnvio = $input['empresaEnvio'];
    $tipoEnvio = $input['tipoEnvio'];
    $precioEnvio = floatval($input['precioEnvio']);
    $imagen = $input['imagen'];

    $pedido = [
        'usuario' => $usuario,
        'numeroCarta' => $numeroCarta,
        'nombreCarta' => $nombreCarta,
        'precioCarta' => $precioCarta,
        'empresaEnvio' => $empresaEnvio,
        'tipoEnvio' => $tipoEnvio,
        'precioEnvio' => $precioEnvio,
        'fecha' => new \MongoDB\BSON\UTCDateTime(),
        'imagen' => $imagen,
        'estado' => 'pedido'
    ];

    // Insertar el nuevo pedido en la colección
    $insertResult = $collection->insertOne($pedido);

    if ($insertResult->getInsertedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Pedido registrado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo registrar el pedido."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
