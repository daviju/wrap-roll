<?php
/*
    API para gestionar la relación entre ingredientes y alérgenos

    Métodos:
        GET: Obtiene una relación específica de ingredientes y alérgenos o todas las relaciones.
        POST: Crea una nueva relación entre un ingrediente y un alérgeno.
        PUT: Actualiza una relación existente entre un ingrediente y un alérgeno.
        DELETE: Elimina una relación entre un ingrediente y un alérgeno.

    Detalles:
        * La conexión a la base de datos se realiza utilizando la clase `Database`.
        * La información sobre la relación entre ingredientes y alérgenos se gestiona a través de la clase `RepositorioIngredientesAlergenos`.
        * La respuesta se envía en formato JSON con el código de estado HTTP correspondiente.

    Manejo de errores:
        * Si el método HTTP no es soportado, se responde con un error 405 (Method Not Allowed).
        * Si se reciben datos malformados en una solicitud `POST` o `PUT`, se puede devolver un error 400 (Bad Request).
        * En cada operación, si los datos requeridos no se proporcionan o son incorrectos, se responde con un error adecuado.

    Funciones de cada método HTTP:
        * GET:
            - Si se proporcionan ambos parámetros `ID_Ingredientes` y `ID_Alergenos` en la ruta, devuelve la relación específica entre ingrediente y alérgeno.
            - Si no se proporcionan esos parámetros, devuelve todas las relaciones de ingredientes y alérgenos.
            - Si no se proporcionan parámetros válidos, responde con un error 400.
        * POST:
            - Crea una nueva relación entre un ingrediente y un alérgeno, utilizando los parámetros `ID_Ingredientes` y `ID_Alergenos`.
        * PUT:
            - Actualiza una relación existente utilizando los parámetros `ID_Ingredientes` y `ID_Alergenos` en la URL.
            - Los datos necesarios son los detalles de la relación a actualizar.
        * DELETE:
            - Elimina una relación entre un ingrediente y un alérgeno utilizando los parámetros `ID_Ingredientes` y `ID_Alergenos` en la URL.

    TODO: Mejorar la validación de los datos de entrada y manejo de errores.
        * Implementar validaciones más detalladas en los métodos `POST`, `PUT` y `DELETE` para asegurar que los datos sean correctos antes de realizar las operaciones en la base de datos.
        * Asegurar la correcta gestión de excepciones y posibles fallos en la base de datos.
*/
header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientesAlergenos.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioIngredientesAlergenos = new RepositorioIngredientesAlergenos($db);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/ingredientesalergenos'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Obtener una relación ingredientes-alérgenos por ID de ingredientes y alérgenos
            $ingredienteAlergeno = $repositorioIngredientesAlergenos->findById($path[0], $path[1]);
            echo json_encode($ingredienteAlergeno);
        } else {
            // Obtener todas las relaciones ingredientes-alérgenos
            $ingredientesAlergenos = $repositorioIngredientesAlergenos->findAll();
            echo json_encode($ingredientesAlergenos);
        }
        break;

    case 'POST':
        // Crear una nueva relación ingredientes-alérgenos
        $input = json_decode(file_get_contents('php://input'), true);
        $ingredienteAlergeno = new IngredientesAlergenos($input['ID_Ingredientes'], $input['ID_Alergenos']);
        $success = $repositorioIngredientesAlergenos->create($ingredienteAlergeno);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Actualizar una relación ingredientes-alérgenos
            $input = json_decode(file_get_contents('php://input'), true);
            $ingredienteAlergeno = new IngredientesAlergenos($path[0], $input['ID_Alergenos']);
            $success = $repositorioIngredientesAlergenos->update($ingredienteAlergeno);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && isset($path[1]) && is_numeric($path[0]) && is_numeric($path[1])) {
            // Eliminar una relación ingredientes-alérgenos
            $success = $repositorioIngredientesAlergenos->delete($path[0], $path[1]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
