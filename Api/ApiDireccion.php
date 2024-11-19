<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioDireccion = new RepositorioDireccion($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/direccion'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener una dirección por ID
            $direccion = $repositorioDireccion->findById($path[0]);
            echo json_encode($direccion);
        } else {
            // Obtener todas las direcciones
            $direcciones = $repositorioDireccion->findAll();
            echo json_encode($direcciones);
        }
        break;

    case 'POST':
        // Crear una nueva dirección
        $input = json_decode(file_get_contents('php://input'), true);
        $direccion = new Direccion(null, $input['nombrevia'], $input['numero'], $input['tipovia'], $input['puerta'], $input['escalera'], $input['planta'], $input['localidad'], $input['ID_Usuario']);
        $success = $repositorioDireccion->create($direccion);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar una dirección
            $input = json_decode(file_get_contents('php://input'), true);
            $direccion = new Direccion($path[0], $input['nombrevia'], $input['numero'], $input['tipovia'], $input['puerta'], $input['escalera'], $input['planta'], $input['localidad'], $input['ID_Usuario']);
            $success = $repositorioDireccion->update($direccion);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar una dirección
            $success = $repositorioDireccion->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
