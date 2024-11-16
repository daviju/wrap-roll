<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/LineaPedido.php';
require_once __DIR__ . '/../Repositorios/RepositorioLineaPedido.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioLineaPedido = new RepositorioLineaPedido($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/lineapedido'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener una línea de pedido por ID
            $lineaPedido = $repositorioLineaPedido->findById($path[0]);
            echo json_encode($lineaPedido);
        } else {
            // Obtener todas las líneas de pedido
            $lineasPedido = $repositorioLineaPedido->findAll();
            echo json_encode($lineasPedido);
        }
        break;

    case 'POST':
        // Crear una nueva línea de pedido
        $input = json_decode(file_get_contents('php://input'), true);
        $lineaPedido = new LineaPedido(null, $input['cantidad'], $input['descripcion'], $input['producto'], $input['ID_Pedido']);
        $success = $repositorioLineaPedido->create($lineaPedido);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar una línea de pedido
            $input = json_decode(file_get_contents('php://input'), true);
            $lineaPedido = new LineaPedido($path[0], $input['cantidad'], $input['descripcion'], $input['producto'], $input['ID_Pedido']);
            $success = $repositorioLineaPedido->update($lineaPedido);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar una línea de pedido
            $success = $repositorioLineaPedido->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
