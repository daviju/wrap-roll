<?php
/*
    API para gestionar kebabs

    Métodos:
        GET: Obtiene uno o todos los kebabs.
        POST: Crea un nuevo kebab con sus ingredientes asociados.
        PUT: Actualiza un kebab existente.
        DELETE: Elimina un kebab.

    Detalles:
        * Este script implementa operaciones CRUD para gestionar kebabs en una base de datos.
        * Utiliza el repositorio `RepositorioKebab` y la clase `Database` para interactuar con la base de datos.
        * Los datos de respuesta son devueltos en formato JSON con los códigos de estado HTTP adecuados.

    Manejo de errores:
        * Si el JSON recibido es inválido en los métodos POST o PUT, se responde con un error 400 (Bad Request).
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * Si faltan datos necesarios en las solicitudes, se responde con un error 400.
        * Para errores internos del servidor, como fallos en la base de datos, se responde con un error 500.
        * Las respuestas exitosas incluyen códigos 200 (OK) o 201 (Created) con detalles del resultado.

    Funciones de cada método HTTP:
        * GET:
            - Si se proporciona un `id_kebab`, devuelve los detalles del kebab correspondiente.
            - Si no se proporciona `id_kebab`, devuelve todos los kebabs registrados.
        * POST:
            - Crea un nuevo kebab a partir de los datos proporcionados (`nombre`, `foto`, `precio`, `selectedIngredientes`).
            - Asocia los ingredientes seleccionados al nuevo kebab.
        * PUT:
            - Actualiza un kebab existente identificándolo mediante `id_kebab` y modificando sus atributos (`nombre`, `foto`, `precio`).
        * DELETE:
            - Elimina un kebab de la base de datos utilizando su `id_kebab`.

    TODO:
        * Implementar validaciones adicionales en los datos de entrada.
        * Manejar mejor los errores derivados de las operaciones con la base de datos.
        * Agregar registros de log para depuración y monitoreo.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Kebab.php';
require_once __DIR__ . '/../Repositorios/RepositorioKebab.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$db = Database::getConection();
$repositorioKebab = new RepositorioKebab($db);

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
        // Obtener el parámetro 'id_kebab' desde la URL
        if (isset($_GET['id_kebab'])) {
            // Obtener un kebab por ID
            $kebab = $repositorioKebab->findById($_GET['id_kebab']);
            if ($kebab) {
                http_response_code(200);
                echo json_encode($kebab);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Kebab no encontrado."]);
            }
        } else {
            // Obtener todos los kebabs
            $kebabs = $repositorioKebab->findAll();
            http_response_code(200);
            echo json_encode($kebabs);
        }
        break;

    case 'POST':
        // Leer los datos JSON del cuerpo de la solicitud
        $input = json_decode(file_get_contents("php://input"), true);
        
        // Crear un nuevo kebab
        if (isset($input['nombre'], $input['foto'], $input['precio'], $input['selectedIngredientes'])) {
            $nombre = $input['nombre'];
            $foto = $input['foto'];
            $precio = $input['precio'];
            $selectedIngredientes = $input['selectedIngredientes'];
            
            $kebab = new Kebab(
                null, // ID será auto-generado
                $nombre, 
                $foto, 
                $precio, 
                $selectedIngredientes);

                $repositorio = new RepositorioKebab(Database::getConection());
                $kebabId = $repositorio->create($kebab);

                if ($kebabId) {
                    // Asociar ingredientes al kebab
                    $kebab->ID_Kebab = $kebabId;
                    $kebab->ingredientes = $selectedIngredientes;

                    $resultadoIngredientes = RepositorioKebab::insertKebabHasIngredientes($kebab);

                    if ($resultadoIngredientes !== null) {
                        http_response_code(200);
                        echo json_encode([
                            "success" => "Kebab creado con éxito y asociado con exito.",
                            "kebabId" => $kebabId
                        ]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Error al asociar ingredientes al kebab."]);
                    }
                } else {
                    http_response_code(505);
                    echo json_encode(["error" => "Error al crear el kebab."]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos para crear el kebab."]);
            }
        break;

    case 'PUT':
        // Actualizar un kebab existente
        if (isset($input['id_kebab'], $input['nombre'], $input['foto'], $input['precio'])) {
            $kebab = new Kebab(
                $input['id_kebab'],
                $input['nombre'],
                $input['foto'],
                $input['precio']
            );

            $result = $repositorioKebab->update($kebab);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "mensaje" => "Kebab actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el kebab."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos insuficientes para actualizar el kebab."]);
        }
        break;

    case 'DELETE':
        // Eliminar un kebab por ID
        if (isset($input['id_kebab']) && !empty($input['id_kebab'])) {
            $id_kebab = $input['id_kebab'];
            $result = $repositorioKebab->delete($id_kebab);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "mensaje" => "Kebab eliminado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar el kebab."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID del kebab no proporcionado."]);
        }
        break;

    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["error" => "Método no soportado."]);
        break;
}
?>
