<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/KebabIngredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioKebabIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioKebabIngredientes = new RepositorioKebabIngredientes($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/kebabsingredientes'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Obtener una relación kebabs-ingredientes por IDs de kebab e ingrediente
            $kebabIngrediente = $repositorioKebabIngredientes->findByIds($path[0], $path[1]);
            echo json_encode($kebabIngrediente);
        } else {
            // Obtener todas las relaciones kebabs-ingredientes
            $kebabsIngredientes = $repositorioKebabIngredientes->findAll();
            echo json_encode($kebabsIngredientes);
        }
        break;

    case 'POST':
        // Crear una nueva relación kebabs-ingredientes
        $input = json_decode(file_get_contents('php://input'), true);
        $kebabIngrediente = new KebabIngredientes($input['ID_Kebab'], $input['ID_Ingrediente']);
        $success = $repositorioKebabIngredientes->create($kebabIngrediente);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Actualizar una relación kebabs-ingredientes
            $input = json_decode(file_get_contents('php://input'), true);
            $kebabIngrediente = new KebabIngredientes($path[0], $input['ID_Ingrediente']);
            $success = $repositorioKebabIngredientes->update($kebabIngrediente);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Eliminar una relación kebabs-ingredientes
            $success = $repositorioKebabIngredientes->delete($path[0], $path[1]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
