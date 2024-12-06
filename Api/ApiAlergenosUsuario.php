<?php
/*
    API para gestionar las relaciones entre alérgenos y usuarios

    Métodos:
        GET: Obtiene una o todas las relaciones entre alérgenos y usuarios.
        POST: Crea una nueva relación entre un alérgeno y un usuario.
        PUT: Actualiza una relación existente entre un alérgeno y un usuario.
        DELETE: Elimina una relación entre un alérgeno y un usuario.

    Detalles:
        * La conexión a la base de datos se realiza utilizando la clase `Database`.
        * La información de las relaciones entre alérgenos y usuarios es gestionada a través de la clase `RepositorioAlergenosUsuario`.
        * La respuesta se envía en formato JSON con el código de estado HTTP correspondiente.

    Manejo de errores:
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * Si se reciben datos malformados en una solicitud `POST` o `PUT`, se puede devolver un error 400 (Bad Request).
        * En cada operación, si los datos requeridos no se proporcionan o son incorrectos, se responde con un error adecuado.

    Funciones de cada método HTTP:
        * GET:
            - Si se proporcionan ambos identificadores (`id_alergenos` y `id_usuarios`), devuelve la relación específica.
            - Si no se proporcionan identificadores, devuelve todas las relaciones entre alérgenos y usuarios.
        * POST:
            - Crea una nueva relación entre un alérgeno y un usuario.
            - Los datos necesarios son `id_alergenos` e `id_usuarios`.
        * PUT:
            - Actualiza una relación existente entre un alérgeno y un usuario.
            - Se debe proporcionar el identificador del alérgeno y el usuario a través de la URL y los nuevos datos en el cuerpo de la solicitud.
        * DELETE:
            - Elimina una relación entre un alérgeno y un usuario.
            - Se debe proporcionar el identificador del alérgeno y el usuario en la URL.

    TODO: Mejorar la validación de los datos de entrada y manejo de errores.
        * Implementar validaciones más detalladas en los métodos `POST`, `PUT` y `DELETE` para asegurar que los datos sean correctos antes de realizar las operaciones en la base de datos.
        * Asegurar la correcta gestión de excepciones y posibles fallos en la base de datos.
*/

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
