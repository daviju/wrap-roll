<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/RepositorioDireccion.php';

Autocargador::autocargar();


// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioDireccion = new RepositorioDireccion($con);

// Obtener método y ruta
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

switch ($method) {
    case 'GET':
        // Verificar si se pasa un ID de dirección en la ruta (e.g., /7)
        if (isset($path[2]) && is_numeric($path[2])) {
            $idDireccion = (int)$path[2]; // Capturar el ID de la dirección
            $direccion = $repositorioDireccion->findById($idDireccion);
    
            if ($direccion) {
                echo json_encode($direccion);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Dirección no encontrada"]);
            }
        } elseif (isset($_GET['idUsuario']) && is_numeric($_GET['idUsuario'])) {
            // Obtener todas las direcciones de un usuario
            $idUsuario = (int)$_GET['idUsuario'];
            $direcciones = $repositorioDireccion->findAll($idUsuario);
    
            if ($direcciones) {
                echo json_encode($direcciones);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "No se encontraron direcciones para este usuario"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Se requiere el ID del usuario o una dirección válida"]);
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
