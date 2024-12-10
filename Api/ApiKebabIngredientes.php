<?php
/*
    API para gestionar las relaciones entre kebabs e ingredientes

    Métodos:
        GET: Obtiene las relaciones entre kebabs e ingredientes.
        POST: Crea una nueva relación entre un kebab y un ingrediente.
        PUT: Actualiza una relación existente entre un kebab y un ingrediente.
        DELETE: Elimina una relación entre un kebab y un ingrediente.

    Detalles:
        * Esta API permite gestionar las asociaciones entre kebabs e ingredientes en la base de datos.
        * Utiliza los repositorios `RepositorioKebabIngredientes` y `RepositorioIngredientes` para interactuar con los datos.
        * Los datos de respuesta se devuelven en formato JSON con los códigos de estado HTTP correspondientes.

    Manejo de errores:
        * Si el JSON recibido es inválido en métodos POST o PUT, se responde con un error 400 (Bad Request).
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * Si faltan datos requeridos en las solicitudes, se responde con un error 400.
        * Para errores internos, como fallos en la base de datos, se responde con un error 500.
        * En caso de éxito, las respuestas incluyen códigos 200 (OK) o 201 (Created).

    Funciones de cada método HTTP:
        * GET:
            - Si se proporciona un `ID_Kebab`, devuelve los nombres de los ingredientes asociados a ese kebab.
            - Si no se proporciona `ID_Kebab`, devuelve todas las relaciones kebab-ingrediente.
        * POST:
            - Crea una nueva relación entre un kebab y un ingrediente a partir de `ID_Kebab` e `ID_Ingrediente`.
        * PUT:
            - Actualiza una relación existente entre un kebab y un ingrediente.
        * DELETE:
            - Elimina una relación específica entre un kebab y un ingrediente usando `ID_Kebab` e `ID_Ingrediente`.

    TODO:
        * Implementar validaciones adicionales para los datos de entrada.
        * Manejar mejor los casos donde los ingredientes no existen en el repositorio.
        * Mejorar el manejo de excepciones para operaciones críticas en la base de datos.
        * Agregar registros de auditoría para las operaciones realizadas.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/KebabIngredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioKebabIngredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioKebabIngredientes = new RepositorioKebabIngredientes($con);
$repositorioIngrediente = new RepositorioIngredientes($con);

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si el JSON es válido
if ($method != 'GET' && $method != 'DELETE' && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "JSON malformado."]);
    exit;
}

switch ($method) {
    case 'GET':
        if (isset($_GET['ID_Kebab'])) {
            // Obtener las relaciones kebab-ingrediente por ID_Kebab
            $kebabIngrediente = $repositorioKebabIngredientes->findByIdKebab($_GET['ID_Kebab']);
            
            if ($kebabIngrediente) {
                // Crear un array con los nombres de los ingredientes
                $ingredientesConNombres = [];
                foreach ($kebabIngrediente as $relacion) {
                    // Obtener el nombre del ingrediente utilizando el repositorio de ingredientes
                    $ingrediente = $repositorioIngrediente->findById($relacion->getIDIngrediente());
                    if ($ingrediente) {
                        $ingredientesConNombres[] = $ingrediente->getNombre();  // Obtener solo el nombre del ingrediente
                    } else {
                        $ingredientesConNombres[] = "Ingrediente no encontrado";
                    }
                }
                http_response_code(200);
                echo json_encode($ingredientesConNombres);  // Devuelve solo los nombres de los ingredientes
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Relación kebab-ingrediente no encontrada."]);
            }
        } else {
            $kebabsIngredientes = $repositorioKebabIngredientes->findAll();
            http_response_code(200);
            echo json_encode($kebabsIngredientes);
        }
        break;
    

    case 'POST':
        // Crear una nueva relación kebab-ingrediente
        if (isset($input['ID_Kebab'], $input['ID_Ingrediente'])) {
            $kebabIngrediente = new KebabIngredientes($input['ID_Kebab'], $input['ID_Ingrediente']);
            $success = $repositorioKebabIngredientes->create($kebabIngrediente);
            if ($success) {
                http_response_code(201); // Created
                echo json_encode(["message" => "Relación kebab-ingrediente creada correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear la relación kebab-ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear la relación."]);
        }
        break;

    case 'PUT':
        // Actualizar una relación kebab-ingrediente
        if (isset($input['ID_Kebab'], $input['ID_Ingrediente'])) {
            $kebabIngrediente = new KebabIngredientes($input['ID_Kebab'], $input['ID_Ingrediente']);
            $success = $repositorioKebabIngredientes->update($kebabIngrediente);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Relación kebab-ingrediente actualizada correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar la relación kebab-ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para actualizar la relación."]);
        }
        break;

    case 'DELETE':
        // Eliminar una relación kebab-ingrediente por IDs
        if (isset($_GET['ID_Kebab']) && isset($_GET['ID_Ingrediente'])) {
            $success = $repositorioKebabIngredientes->delete($_GET['ID_Kebab'], $_GET['ID_Ingrediente']);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Relación kebab-ingrediente eliminada correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar la relación kebab-ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID de kebab o ingrediente no proporcionados."]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["error" => "Método no soportado."]);
}
?>
