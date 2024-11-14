<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/Kebab.php';
require_once __DIR__ . '/../Repositorios/RepositorioKebab.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';  // Incluir la clase Database

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioKebab = new RepositorioKebab($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/kebabs'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener un kebab por ID
            $kebab = $repositorioKebab->findById($path[0]);
            echo json_encode($kebab);
        } else {
            // Obtener todos los kebabs
            $kebabs = $repositorioKebab->findAll();
            echo json_encode($kebabs);
        }
        break;
    case 'POST':
        // Crear un nuevo kebab
        $input = json_decode(file_get_contents('php://input'), true);
        $kebab = new Kebab(null, $input['nombre'], $input['foto'], $input['precio']);
        $success = $repositorioKebab->create($kebab);
        echo json_encode(['success' => $success]);
        break;
    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar un kebab
            $input = json_decode(file_get_contents('php://input'), true);
            $kebab = new Kebab($path[0], $input['nombre'], $input['foto'], $input['precio']);
            $success = $repositorioKebab->update($kebab);
            echo json_encode(['success' => $success]);
        }
        break;
    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar un kebab
            $success = $repositorioKebab->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;
    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
