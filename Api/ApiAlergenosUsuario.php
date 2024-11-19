<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioAlergenosUsuario = new RepositorioAlergenosUsuario($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/alergenosusuario'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Obtener una relación alérgenos-usuario por ID de alérgeno y usuario
            $alergenoUsuario = $repositorioAlergenosUsuario->findById($path[0], $path[1]);
            echo json_encode($alergenoUsuario);
        } else {
            // Obtener todas las relaciones alérgenos-usuario
            $alergenosUsuarios = $repositorioAlergenosUsuario->findAll();
            echo json_encode($alergenosUsuarios);
        }
        break;

    case 'POST':
        // Crear una nueva relación alérgenos-usuario
        $input = json_decode(file_get_contents('php://input'), true);
        $alergenoUsuario = new AlergenosUsuario($input['id_alergenos'], $input['id_usuarios']);
        $success = $repositorioAlergenosUsuario->create($alergenoUsuario);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Actualizar una relación alérgenos-usuario
            $input = json_decode(file_get_contents('php://input'), true);
            $alergenoUsuario = new AlergenosUsuario($path[0], $input['id_usuarios']);
            $success = $repositorioAlergenosUsuario->update($alergenoUsuario);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Eliminar una relación alérgenos-usuario
            $success = $repositorioAlergenosUsuario->delete($path[0], $path[1]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
