<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Ingredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/conexion.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$database = new Database();
$db = $database->getConnection();
$repositorioIngredientes = new RepositorioIngredientes($db);

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
        // Obtener el parámetro 'id_ingrediente' desde la URL
        if (isset($_GET['id_ingrediente'])) {
            // Obtener un ingrediente por ID
            $ingrediente = $repositorioIngredientes->findById($_GET['id_ingrediente']);
            if ($ingrediente) {
                http_response_code(200);
                echo json_encode($ingrediente);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Ingrediente no encontrado."]);
            }
        } else {
            // Obtener todos los ingredientes
            $ingredientes = $repositorioIngredientes->findAll();
            http_response_code(200);
            echo json_encode($ingredientes);
        }
        break;

    case 'POST':
        // Crear un nuevo ingrediente
        if (isset($input['nombre'], $input['precio'], $input['tipo'], $input['foto'])) {
            $ingrediente = new Ingredientes(
                null,  // ID será auto-generado
                $input['nombre'],
                $input['precio'],
                $input['tipo'],
                $input['foto']
            );

            $result = $repositorioIngredientes->create($ingrediente);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(["message" => "Ingrediente creado exitosamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear el ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear el ingrediente."]);
        }
        break;

    case 'PUT':
        // Actualizar un ingrediente existente
        if (isset($input['id_ingrediente'], $input['nombre'], $input['precio'], $input['tipo'], $input['foto'])) {
            $ingrediente = new Ingredientes(
                $input['id_ingrediente'],
                $input['nombre'],
                $input['precio'],
                $input['tipo'],
                $input['foto']
            );

            $result = $repositorioIngredientes->update($ingrediente);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "mensaje" => "Ingrediente actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos insuficientes para actualizar el ingrediente."]);
        }
        break;

    case 'DELETE':
        // Eliminar un ingrediente por ID
        if (isset($input['id_ingrediente']) && !empty($input['id_ingrediente'])) {
            $id_ingrediente = $input['id_ingrediente'];
            $result = $repositorioIngredientes->delete($id_ingrediente);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "mensaje" => "Ingrediente eliminado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar el ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID del ingrediente no proporcionado."]);
        }
        break;

    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["error" => "Método no soportado."]);
        break;
}
?>
