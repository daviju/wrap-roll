<?php
/*
    API para gestionar direcciones de usuarios

    Métodos:
        GET: Obtiene una dirección específica o todas las direcciones de un usuario.
        POST: Crea una nueva dirección para un usuario.
        PUT: Actualiza una dirección existente.
        DELETE: Elimina una dirección.

    Detalles:
        * La conexión a la base de datos se realiza utilizando la clase `Database`.
        * La información de las direcciones es gestionada a través de la clase `RepositorioDireccion`.
        * La respuesta se envía en formato JSON con el código de estado HTTP correspondiente.

    Manejo de errores:
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * Si se reciben datos malformados en una solicitud `POST` o `PUT`, se puede devolver un error 400 (Bad Request).
        * En cada operación, si los datos requeridos no se proporcionan o son incorrectos, se responde con un error adecuado.

    Funciones de cada método HTTP:
        * GET:
            - Si se proporciona un `idDireccion` en la ruta, devuelve la dirección específica correspondiente.
            - Si se proporciona un `idUsuario` en los parámetros de la URL, devuelve todas las direcciones asociadas a ese usuario.
            - Si no se proporcionan parámetros válidos, responde con un error 400.
        * POST:
            - Crea una nueva dirección para el usuario.
            - Los datos necesarios son `nombrevia`, `numero`, `tipovia`, `puerta`, `escalera`, `planta`, `localidad`, y `ID_Usuario`.
        * PUT:
            - Actualiza una dirección existente utilizando su `idDireccion` en la URL.
            - Los datos necesarios son los detalles de la dirección a actualizar.
        * DELETE:
            - Elimina una dirección utilizando su `idDireccion` en la URL.

    TODO: Mejorar la validación de los datos de entrada y manejo de errores.
        * Implementar validaciones más detalladas en los métodos `POST`, `PUT` y `DELETE` para asegurar que los datos sean correctos antes de realizar las operaciones en la base de datos.
        * Asegurar la correcta gestión de excepciones y posibles fallos en la base de datos.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/RepositorioDireccion.php';

Autocargador::autocargar();


// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioDireccion = new RepositorioDireccion($con);

// Obtener método y ruta
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

switch ($method) {
    case 'GET':
        // Verificar si se pasa un ID de dirección en la ruta (e.g., /7)
        if (isset($path[2]) && is_numeric($path[2])) {
            $idDireccion = (int)$path[2]; // Capturar el ID de la dirección
            $direccion = $repositorioDireccion->findById($idDireccion);
    
            if ($direccion) {
                echo json_encode($direccion);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Dirección no encontrada"]);
            }
        } elseif (isset($_GET['idUsuario']) && is_numeric($_GET['idUsuario'])) {
            // Obtener todas las direcciones de un usuario
            $idUsuario = (int)$_GET['idUsuario'];
            $direcciones = $repositorioDireccion->findAll($idUsuario);
    
            if ($direcciones) {
                echo json_encode($direcciones);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "No se encontraron direcciones para este usuario"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Se requiere el ID del usuario o una dirección válida"]);
        }
        break;
    

    case 'POST':
        // Crear una nueva dirección
        $input = json_decode(file_get_contents('php://input'), true);
        $direccion = new Direccion(null, $input['nombrevia'], $input['numero'], $input['tipovia'], $input['puerta'], $input['escalera'], $input['planta'], $input['localidad'], $input['ID_Usuario']);
        $success = $repositorioDireccion->create($direccion);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar una dirección
            $input = json_decode(file_get_contents('php://input'), true);
            $direccion = new Direccion($path[0], $input['nombrevia'], $input['numero'], $input['tipovia'], $input['puerta'], $input['escalera'], $input['planta'], $input['localidad'], $input['ID_Usuario']);
            $success = $repositorioDireccion->update($direccion);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar una dirección
            $success = $repositorioDireccion->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
