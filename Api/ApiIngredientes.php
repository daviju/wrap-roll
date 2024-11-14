<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/Ingredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioIngredientes = new RepositorioIngredientes($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/ingredientes'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener un ingrediente por ID
            $ingrediente = $repositorioIngredientes->findById($path[0]);
            echo json_encode($ingrediente);
        } else {
            // Obtener todos los ingredientes
            $ingredientes = $repositorioIngredientes->findAll();
            echo json_encode($ingredientes);
        }
        break;

    case 'POST':
        // Crear un nuevo ingrediente
        $input = json_decode(file_get_contents('php://input'), true);
        $ingrediente = new Ingredientes(null, $input['nombre'], $input['precio'], $input['tipo'], $input['foto']);
        $success = $repositorioIngredientes->create($ingrediente);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar un ingrediente
            $input = json_decode(file_get_contents('php://input'), true);
            $ingrediente = new Ingredientes($path[0], $input['nombre'], $input['precio'], $input['tipo'], $input['foto']);
            $success = $repositorioIngredientes->update($ingrediente);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar un ingrediente
            $success = $repositorioIngredientes->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;
        
    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
