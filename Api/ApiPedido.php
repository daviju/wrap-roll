<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioPedido = new RepositorioPedido($con);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/pedido'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener un pedido por ID
            $pedido = $repositorioPedido->findById($path[0]);
            echo json_encode($pedido);
        } else {
            // Obtener todos los pedidos
            $pedidos = $repositorioPedido->findAll();
            echo json_encode($pedidos);
        }
        break;

    case 'POST':
        // Crear un nuevo pedido
        $input = json_decode(file_get_contents('php://input'), true);
        $pedido = new Pedido(null, $input['estado'], $input['direccion'], $input['preciototal'], $input['fechaHora'], $input['ID_Usuario']);
        $success = $repositorioPedido->create($pedido);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar un pedido
            $input = json_decode(file_get_contents('php://input'), true);
            $pedido = new Pedido($path[0], $input['estado'], $input['direccion'], $input['preciototal'], $input['fechaHora'], $input['ID_Usuario']);
            $success = $repositorioPedido->update($pedido);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar un pedido
            $success = $repositorioPedido->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
