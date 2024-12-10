<?php
/*
    API para la gestión de líneas de pedido

    Descripción:
        Este script maneja operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre las líneas de pedido en la base de datos. 
        Utiliza un repositorio (`RepositorioLineaPedido`) para interactuar con las líneas de pedido, ofreciendo una interfaz clara para su gestión.

    Métodos soportados:
        * GET:
            - Si se proporciona un ID en la URL, devuelve una línea de pedido específica.
            - Si no se proporciona ID, devuelve todas las líneas de pedido.
        * POST:
            - Crea una nueva línea de pedido con los datos proporcionados en el cuerpo de la solicitud (JSON).
        * PUT:
            - Actualiza una línea de pedido específica usando el ID en la URL y datos en el cuerpo de la solicitud.
        * DELETE:
            - Elimina una línea de pedido específica según el ID proporcionado en la URL.

    Detalles de implementación:
        * El ID de la línea de pedido se extrae de la URL, ajustándose al formato de rutas específicas para `lineapedido`.
        * Los datos del cuerpo de la solicitud (para POST y PUT) se esperan en formato JSON, incluyendo:
            - `linea_pedidos` (detalle de los productos o servicios en la línea).
            - `ID_Pedido` (asociación al pedido principal).
        * La respuesta de cada operación se devuelve en formato JSON con una clave `success` indicando el resultado de la operación.

    Manejo de errores:
        * Si el método HTTP no es soportado, se devuelve un error genérico en formato JSON.
        * Asegúrate de manejar excepciones a nivel del repositorio para evitar que errores en la base de datos se propaguen a la respuesta de la API.

    Rutas:
        * GET /api/lineapedido/ (devuelve todas las líneas de pedido).
        * GET /api/lineapedido/{id} (devuelve una línea de pedido específica).
        * POST /api/lineapedido/ (crea una nueva línea de pedido con los datos proporcionados).
        * PUT /api/lineapedido/{id} (actualiza una línea de pedido existente).
        * DELETE /api/lineapedido/{id} (elimina una línea de pedido existente).

    TODO:
        * Implementar validación de los datos de entrada en todos los métodos.
        * Mejorar el manejo de excepciones y devolver códigos de estado HTTP adecuados.
        * Agregar autenticación para proteger el acceso a la API.
*/

header("Content-Type: application/json");

require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioLineaPedido = new RepositorioLineaPedido($con);

$method = $_SERVER['REQUEST_METHOD'];

// Ajustar el manejo de la ruta
$path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$path = array_slice($path, 3); // Ajustar según el número de segmentos en la URL antes de 'api/lineapedido'

switch ($method) {
    case 'GET':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Obtener una línea de pedido por ID
            $lineaPedido = $repositorioLineaPedido->findById($path[0]);
            echo json_encode($lineaPedido);
        } else {
            // Obtener todas las líneas de pedido
            $lineasPedido = $repositorioLineaPedido->findAll();
            echo json_encode($lineasPedido);
        }
        break;

    case 'POST':
        // Crear una nueva línea de pedido
        $input = json_decode(file_get_contents('php://input'), true);
        // Aquí solo necesitamos ID_LineaPedido, linea_pedidos (como JSON) e ID_Pedido
        $lineaPedido = new LineaPedido(null, $input['linea_pedidos'], $input['ID_Pedido']);
        $success = $repositorioLineaPedido->create($lineaPedido);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Actualizar una línea de pedido
            $input = json_decode(file_get_contents('php://input'), true);
            // Aquí solo necesitamos ID_LineaPedido, linea_pedidos (como JSON) e ID_Pedido
            $lineaPedido = new LineaPedido($path[0], $input['linea_pedidos'], $input['ID_Pedido']);
            $success = $repositorioLineaPedido->update($lineaPedido);
            echo json_encode(['success' => $success]);
        }
        break;

    case 'DELETE':
        if (isset($path[0]) && is_numeric($path[0])) {
            // Eliminar una línea de pedido
            $success = $repositorioLineaPedido->delete($path[0]);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no soportado']);
}
?>
