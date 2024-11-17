<?php
header("Content-Type: application/json");

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioUsuario = new RepositorioUsuario($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/user'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener un usuario por ID
            $usuario = $repositorioUsuario->findById($path[0]);
            echo json_encode($usuario);
        } else {
            // Obtener todos los usuarios
            $usuarios = $repositorioUsuario->findAll();
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        // Crear un nuevo usuario
        $input = json_decode(file_get_contents('php://input'), true);
        $usuario = new Usuario(null, $input['nombre'], $input['foto'], $input['contraseña'], $input['monedero'], $input['email'], $input['carrito'], $input['rol']);
        $success = $repositorioUsuario->create($usuario);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar un usuario
            $input = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuario($path[0], $input['nombre'], $input['foto'], $input['contraseña'], $input['monedero'], $input['email'], $input['carrito'], $input['rol']);
            $success = $repositorioUsuario->update($usuario);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar un usuario
            $success = $repositorioUsuario->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
