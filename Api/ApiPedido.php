<?php
/*
    API para gestionar pedidos

    Métodos:
        GET: Obtiene uno o todos los pedidos.
        POST: Crea un nuevo pedido.
        PUT: Actualiza un pedido existente.
        DELETE: Elimina un pedido.

    Detalles:
        * El script maneja las operaciones CRUD para los pedidos utilizando el repositorio `RepositorioPedido`.
        * La conexión a la base de datos se establece mediante la clase `Database`.
        * La respuesta se envía en formato JSON con el código de estado HTTP correspondiente.
        
    Manejo de errores:
        * Si el JSON recibido en las solicitudes POST o PUT es malformado, se responde con un error 400 (Bad Request).
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * En cada operación, si los datos requeridos no se proporcionan o son incorrectos, se responde con un error 400.
        * En los casos de éxito, se responde con el código de estado correspondiente (200, 201) y un mensaje de éxito en formato JSON.

    Funciones de cada método HTTP:
        * GET: 
            - Si se proporciona un `idPedido`, devuelve el pedido correspondiente.
            - Si no se proporciona `idPedido`, devuelve todos los pedidos.
        * POST:
            - Recibe los datos necesarios (`estado`, `preciototal`, `fecha_hora` y `ID_Usuario`) para crear un nuevo pedido y lo almacena en la base de datos.
        * PUT:
            - Recibe un `idPedido`, `estado`, `preciototal`, `fecha_hora` y `ID_Usuario` para actualizar un pedido existente.
        * DELETE:
            - Recibe un `idPedido` para eliminar el pedido correspondiente.

    TODO: Implementar validaciones adicionales y manejo de excepciones más robusto.
        * Mejorar el manejo de errores para situaciones como problemas de conexión a la base de datos.
        * Asegurar que los datos recibidos en las solicitudes sean correctos antes de realizar las operaciones.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Pedidos.php';
require_once __DIR__ . '/../Repositorios/RepositorioPedido.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioPedido = new RepositorioPedido($con);

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
        if (isset($_GET['idPedido'])) {
            // Obtener un pedido por ID
            $pedido = $repositorioPedido->findById($_GET['idPedido']);
            if ($pedido) {
                http_response_code(200); // OK
                echo json_encode($pedido);
            } else {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Pedido no encontrado."]);
            }
        } else {
            // Obtener todos los pedidos
            $pedidos = $repositorioPedido->findAll();
            http_response_code(200); // OK
            echo json_encode($pedidos);
        }
        break;

    case 'POST':
        // Crear un nuevo pedido
        if (isset($input['estado'], $input['preciototal'], $input['fecha_hora'], $input['ID_Usuario'])) {
            $pedido = new Pedido(
                null, // El ID será generado automáticamente por la base de datos
                $input['estado'],
                $input['preciototal'],
                $input['fecha_hora'],
                $input['ID_Usuario']
            );

            $success = $repositorioPedido->create($pedido);
            if ($success) {
                http_response_code(201); // Created
                echo json_encode(["success" => true, "message" => "Pedido creado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear el pedido."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear el pedido."]);
        }
        break;

    case 'PUT':
        // Actualizar un pedido
        if (isset($input['idPedido'], $input['estado'], $input['preciototal'], $input['fecha_hora'], $input['ID_Usuario'])) {
            $pedido = new Pedido(
                $input['idPedido'],
                $input['estado'],
                $input['preciototal'],
                $input['fecha_hora'],
                $input['ID_Usuario']
            );

            $success = $repositorioPedido->update($pedido);
            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Pedido actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el pedido."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para actualizar el pedido."]);
        }
        break;

    case 'DELETE':
        // Eliminar un pedido por ID
        if (isset($_GET['idPedido']) && !empty($_GET['idPedido'])) {
            $idPedido = $_GET['idPedido'];
            $success = $repositorioPedido->delete($idPedido);

            if ($success) {
                http_response_code(200); // OK
                echo json_encode(["success" => true, "message" => "Pedido eliminado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar el pedido."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID del pedido no proporcionado."]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["error" => "Método no soportado."]);
        break;
}
