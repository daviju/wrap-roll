<?php
/*
    API para gestionar alergenos

    Métodos:
        GET: Obtiene uno o todos los alergenos.
        POST: Crea un nuevo alergeno.
        PUT: Actualiza un alergeno existente.
        DELETE: Elimina un alergeno.

    Detalles:
        * El script maneja las operaciones CRUD para alergenos en una base de datos utilizando el repositorio `RepositorioAlergenos`.
        * La conexión a la base de datos se establece mediante la clase `Database`.
        * La respuesta se envía en formato JSON con el código de estado HTTP correspondiente.
        
    Manejo de errores:
        * Si el JSON recibido en las solicitudes POST, PUT o DELETE es malformado, se responde con un error 400 (Bad Request).
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * En cada operación, si los datos requeridos no se proporcionan o son incorrectos, se responde con un error 400.
        * En los casos de éxito, se responde con el código de estado correspondiente (200, 201) y un mensaje de éxito en formato JSON.

    Funciones de cada método HTTP:
        * GET: 
            - Si se proporciona un `id_alergeno`, devuelve el alergeno correspondiente.
            - Si no se proporciona `id_alergeno`, devuelve todos los alergenos.
        * POST:
            - Recibe los datos necesarios (`tipo` y `foto`) para crear un nuevo alergeno y lo almacena en la base de datos.
        * PUT:
            - Recibe un `id_alergeno`, `tipo` y `foto` para actualizar un alergeno existente.
        * DELETE:
            - Recibe un `id_alergeno` para eliminar el alergeno correspondiente.

    TODO: Implementar la validación de los datos de entrada y mejorar el manejo de excepciones.
        * Mejorar el manejo de errores para situaciones como problemas con la base de datos o validación de los datos.
        * Asegurar que los datos recibidos en las solicitudes sean correctos antes de realizar las operaciones en la base de datos.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Alergenos.php';
require_once __DIR__ . '/../Repositorios/RepositorioAlergenos.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioAlergenos = new RepositorioIngredientes($con);

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true); // Para POST, PUT y DELETE

// Verificar si el JSON recibido es válido
if ($method != 'GET' && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "JSON malformado."]);
    exit;
}

switch ($method) {
    case 'GET':
        // Obtener un alergeno por ID
        if (isset($_GET['id_alergeno'])) {
            $alergeno = $repositorioAlergenos->findById($_GET['id_alergeno']);
            if ($alergeno) {
                http_response_code(200);
                echo json_encode($alergeno);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Alergeno no encontrado."]);
            }
        } else {
            // Obtener todos los alergenos
            $alergenos = $repositorioAlergenos->findAll();
            http_response_code(200);
            echo json_encode($alergenos);
        }
        break;

    case 'POST':
        // Crear un nuevo alergeno
        if (isset($input['tipo'], $input['foto'])) {
            $alergeno = new Alergenos(null, $input['tipo'], $input['foto']);
            $success = $repositorioAlergenos->create($alergeno);
            if ($success) {
                http_response_code(201); // Created
                echo json_encode(["success" => true, "message" => "Alergeno creado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear el alergeno."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear el alergeno."]);
        }
        break;

    case 'PUT':
        // Asegúrate de usar `id_alergeno` aquí
        if (isset($input['id_alergeno'], $input['tipo'], $input['foto'])) {
            $alergeno = new Alergenos($input['id_alergeno'], $input['tipo'], $input['foto']);
            $success = $repositorioAlergenos->update($alergeno);

            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "mensaje" => "Alergeno actualizado correctamente."]);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Error al actualizar el alergeno. Puede que no exista o los datos sean iguales a los actuales."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos insuficientes para actualizar el alergeno."]);
        }
        break;

    case 'DELETE':
        // Eliminar un alergeno
        if (isset($input['id_alergeno'])) {
            // Agregar log para depuración
            error_log("Cuerpo recibido en DELETE: " . print_r($input, true));
            
            $success = $repositorioAlergenos->delete($input['id_alergeno']);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Alergeno eliminado correctamente."]);
            } else {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Error al eliminar el alergeno. Puede que no exista."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID del alergeno no proporcionado."]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["error" => "Método no soportado."]);
        break;
}
