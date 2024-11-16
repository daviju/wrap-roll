<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/IngredientesAlergenos.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientesAlergenos.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioIngredientesAlergenos = new RepositorioIngredientesAlergenos($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/ingredientesalergenos'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Obtener una relación ingredientes-alérgenos por ID de ingredientes y alérgenos
            $ingredienteAlergeno = $repositorioIngredientesAlergenos->findById($path[0], $path[1]);
            echo json_encode($ingredienteAlergeno);
        } else {
            // Obtener todas las relaciones ingredientes-alérgenos
            $ingredientesAlergenos = $repositorioIngredientesAlergenos->findAll();
            echo json_encode($ingredientesAlergenos);
        }
        break;

    case 'POST':
        // Crear una nueva relación ingredientes-alérgenos
        $input = json_decode(file_get_contents('php://input'), true);
        $ingredienteAlergeno = new IngredientesAlergenos($input['ID_Ingredientes'], $input['ID_Alergenos']);
        $success = $repositorioIngredientesAlergenos->create($ingredienteAlergeno);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Actualizar una relación ingredientes-alérgenos
            $input = json_decode(file_get_contents('php://input'), true);
            $ingredienteAlergeno = new IngredientesAlergenos($path[0], $input['ID_Alergenos']);
            $success = $repositorioIngredientesAlergenos->update($ingredienteAlergeno);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Eliminar una relación ingredientes-alérgenos
            $success = $repositorioIngredientesAlergenos->delete($path[0], $path[1]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
