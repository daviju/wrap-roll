<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Usuario.php';
require_once __DIR__ . '/../Repositorios/RepositorioUsuario.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioUsuario = new RepositorioUsuario($con);

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si el JSON es válido
if ($method != 'GET' && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "JSON malformado."]);
    exit;
}

switch ($method) {
    case 'GET':
        // Obtener un usuario por ID o todos los usuarios
        if (isset($_GET['id_usuario'])) {
            // Obtener un usuario por ID
            $usuario = $repositorioUsuario->findById($_GET['id_usuario']);
            if ($usuario) {
                http_response_code(200);
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado."]);
            }
        } else {
            // Obtener todos los usuarios
            $usuarios = $repositorioUsuario->findAll();
            http_response_code(200);
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        // Crear un nuevo usuario
        if (isset($input['nombre'], $input['foto'], $input['contraseña'], $input['monedero'], $input['telefono'], $input['email'], $input['carrito'], $input['rol'])) {
            $usuario = new Usuario(
                null,  // ID será auto-generado
                $input['nombre'],
                $input['foto'],
                $input['contraseña'],
                $input['monedero'],
                $input['telefono'],
                $input['carrito'],
                $input['rol'],
                $input['email']
            );

            $success = $repositorioUsuario->create($usuario);
            if ($success) {
                http_response_code(201); // Created
                echo json_encode(["success" => true, "message" => "Usuario creado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear el usuario."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear el usuario."]);
        }
        break;

    case 'PUT':
        // Actualizar un usuario existente
        if (isset($input['id_usuario'], $input['nombre'], $input['foto'], $input['contraseña'], $input['monedero'], $·input['telefono'], $input['email'], $input['carrito'], $input['rol'])) {
            $usuario = new Usuario(
                $input['id_usuario'],
                $input['nombre'],
                $input['foto'],
                $input['contraseña'],
                $input['monedero'],
                $input['telefono'],
                $input['email'],
                $input['carrito'],
                $input['rol']
            );

            $success = $repositorioUsuario->update($usuario);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el usuario."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos insuficientes para actualizar el usuario."]);
        }
        break;

    case 'DELETE':
        // Eliminar un usuario por ID
        if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
            $id_usuario = $_GET['id_usuario'];
            $success = $repositorioUsuario->delete($id_usuario);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar el usuario."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID del usuario no proporcionado."]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["error" => "Método no soportado."]);
        break;
}
?>