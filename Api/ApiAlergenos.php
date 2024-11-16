<?php
header("Content-Type: application/json");

// Incluye las clases desde la ubicación correcta
require_once __DIR__ . '/../Clases/Alergenos.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioAlergenos = new RepositorioIngredientes($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/alergenos'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener un alergeno por ID
            $alergeno = $repositorioAlergenos->findById($path[0]);
            echo json_encode($alergeno);
        } else {
            // Obtener todos los alergenos
            $alergenos = $repositorioAlergenos->findAll();
            echo json_encode($alergenos);
        }
        break;

    case 'POST':
        // Crear un nuevo alergeno
        $input = json_decode(file_get_contents('php://input'), true);
        $alergeno = new Alergenos(null, $input['tipo'], $input['foto']);
        $success = $repositorioAlergenos->create($alergeno);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar un alergeno
            $input = json_decode(file_get_contents('php://input'), true);
            $alergeno = new Alergenos($path[0], $input['tipo'], $input['foto']);
            $success = $repositorioAlergenos->update($alergeno);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar un alergeno
            $success = $repositorioAlergenos->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
