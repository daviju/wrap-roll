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
        // Verificar si es una solicitud de login
        if (isset($_GET['email'], $_GET['password'])) { // Verificar si se envían los parámetros
            $email = $_GET['email']; // Obtener el email
            $password = $_GET['password']; // Obtener la contraseña

            // Lógica para verificar usuario en la base de datos
            $usuario = $repositorioUsuario->verifyUser($email, $password); // Verificar usuario

            if ($usuario) { // Si el usuario existe
                // Usuario encontrado y autenticado
                http_response_code(200); // OK
                echo json_encode([
                    "success" => true,
                    "message" => "Inicio de sesión exitoso.",
                    "user" => $usuario // Opcional: devolver datos del usuario
                ]);
            } else {
                // Credenciales inválidas
                http_response_code(401);
                echo json_encode([
                    "success" => false,
                    "error" => "Correo electrónico o contraseña incorrectos."
                ]);
            }
        } elseif (isset($_GET['idUsuario'])) { // Verificar si es una solicitud de obtener usuario
            // Obtener un usuario por ID
            $usuario = $repositorioUsuario->findById($_GET['idUsuario']); // Obtener usuario por ID
            if ($usuario) {
                http_response_code(200);
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado."]);
            }
        } else { // Solicitud GET sin parámetros
            // Obtener todos los usuarios
            $usuarios = $repositorioUsuario->findAll(); // Obtener todos los usuarios
            http_response_code(200);
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        // Depuración: Ver los datos que llegan a la API
        error_log("Datos recibidos en POST: " . print_r($input, true));  // Imprimir los datos en el log del servidor

        // Crear un nuevo usuario
        if (isset($input['nombre'], $input['foto'], $input['contrasena'], $input['monedero'], $input['email'], $input['carrito'], $input['rol'], $input['telefono'])) {
            $usuario = new Usuario(
                null,  // ID será auto-generado
                $input['nombre'],
                $input['foto'],
                $input['contrasena'],
                $input['monedero'],
                $input['email'],
                $input['carrito'] ?? [], // Carrito por defecto si no se proporciona
                $input['rol'] ?? "Cliente", // Rol por defecto si no se proporciona
                $input['telefono']
            );

            $success = $repositorioUsuario->create($usuario); // Crear usuario en la base de datos
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
        // Depuración: Ver los datos que llegan a la API
        error_log("Datos recibidos en PUT: " . print_r($input, true));  // Imprimir los datos en el log del servidor

        // Verificar que se haya pasado el ID
        if (isset($input['idUsuario'], $input['nombre'], $input['foto'], $input['contrasena'], $input['monedero'], $input['email'], $input['carrito'], $input['rol'], $input['telefono'])) {
            $usuario = new Usuario(
                $input['idUsuario'],  // ID ya proporcionado para actualizar
                $input['nombre'],
                $input['foto'],
                $input['contrasena'],
                $input['monedero'],
                $input['email'],
                $input['carrito'] ?? [], // Carrito por defecto si no se proporciona
                $input['rol'] ?? "Cliente", // Rol por defecto si no se proporciona
                $input['telefono']
            );

            $success = $repositorioUsuario->update($usuario); // Actualizar usuario en la base de datos
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el usuario."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para actualizar el usuario."]);
        }
        break;


    case 'DELETE':
        // Eliminar un usuario por ID
        if (isset($_GET['idUsuario']) && !empty($_GET['idUsuario'])) { // Verificar que se haya pasado el ID

            $idUsuario = $_GET['idUsuario']; // Obtener el ID del usuario a eliminar
            $success = $repositorioUsuario->delete($idUsuario); // Eliminar el usuario de la base de datos

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
