<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../Clases/Ingredientes.php';
require_once __DIR__ . '/../Repositorios/RepositorioIngredientes.php';
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

Autocargador::autocargar();

// Crear conexión utilizando tu clase Database
$con = Database::getConection();
$repositorioIngredientes = new RepositorioIngredientes($con);

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
        // Verificar si se ha enviado como archivo ($_FILES) o como JSON (input)
        if (!empty($_FILES) && isset($_POST['nombre'], $_POST['precio'], $_POST['tipo'], $_POST['alergenos'])) {
            // Datos enviados como archivo
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $tipo = $_POST['tipo'];
            $foto = $_FILES['foto'] ?? null; // Archivo de imagen
            $alergenos = $_POST['alergenos'];

            // Validar formato de alérgenos
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($alergenos)) {
                http_response_code(400);
                echo json_encode(["error" => "Formato inválido en alérgenos."]);
                exit;
            }

            if (!$foto) {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Archivo de imagen no proporcionado."]);
                exit;
            }

            // Procesar la imagen y moverla a la carpeta `images`
            $uploadDir = __DIR__ . '/../images/';
            $fileName = basename($foto['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Validar tipo de archivo
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                http_response_code(400);
                echo json_encode(["error" => "Formato de imagen no permitido."]);
                exit;
            }

            // Mover el archivo a la carpeta `images`
            if (!move_uploaded_file($foto['tmp_name'], $targetFilePath)) {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al guardar la imagen."]);
                exit;
            }

            // Guardar solo el nombre del archivo
            $fotoNombre = $fileName;

            // Crear el objeto Ingredientes
            $ingrediente = new Ingredientes(
                null, // ID autogenerado
                $nombre,
                $precio,
                $tipo,
                $fotoNombre,
                $alergenos
            );

            // Guardar en la base de datos
            $result = $repositorioIngredientes->create($ingrediente);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(["message" => "Ingrediente creado exitosamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al crear el ingrediente."]);
            }
        } elseif (isset($input['nombre'], $input['precio'], $input['tipo'], $input['foto'], $input['alergenos'])) {
            // Datos enviados como JSON (foto es el nombre del archivo)
            $ingrediente = new Ingredientes(
                null, // ID será autogenerado
                $input['nombre'],
                $input['precio'],
                $input['tipo'],
                $input['foto'],
                $input['alergenos']
            );

            // Guardar en la base de datos
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
        // Verificar si se ha enviado como archivo ($_FILES) o como JSON (input)
        if (!empty($_FILES) && isset($_POST['id_ingrediente'], $_POST['nombre'], $_POST['precio'], $_POST['tipo'], $_POST['alergenos'])) {
            // Datos enviados como archivo
            $id_ingrediente = $_POST['id_ingrediente'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $tipo = $_POST['tipo'];
            $foto = $_FILES['foto'] ?? null; // Archivo de imagen
            $alergenos = $_POST['alergenos'];

            // Validar formato de alérgenos
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($alergenos)) {
                http_response_code(400);
                echo json_encode(["error" => "Formato inválido en alérgenos."]);
                exit;
            }

            // Validar existencia del ID
            if (!$repositorioIngredientes->findById($id_ingrediente)) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Ingrediente no encontrado."]);
                exit;
            }

            if (!$foto) {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Archivo de imagen no proporcionado."]);
                exit;
            }

            // Procesar la imagen y moverla a la carpeta `images`
            $uploadDir = __DIR__ . '/../images/';
            $fileName = basename($foto['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Validar tipo de archivo
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                http_response_code(400);
                echo json_encode(["error" => "Formato de imagen no permitido."]);
                exit;
            }

            // Mover el archivo a la carpeta `images`
            if (!move_uploaded_file($foto['tmp_name'], $targetFilePath)) {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al guardar la imagen."]);
                exit;
            }

            // Guardar solo el nombre del archivo
            $fotoNombre = $fileName;

            // Crear el objeto Ingredientes
            $ingrediente = new Ingredientes(
                $id_ingrediente,
                $nombre,
                $precio,
                $tipo,
                $fotoNombre,
                $alergenos
            );

            // Actualizar en la base de datos
            $result = $repositorioIngredientes->update($ingrediente);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Ingrediente actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el ingrediente."]);
            }
        } elseif (isset($input['id_ingrediente'], $input['nombre'], $input['precio'], $input['tipo'], $input['foto'], $input['alergenos'])) {
            // Datos enviados como JSON (foto es el nombre del archivo)
            $id_ingrediente = $input['id_ingrediente'];

            // Validar existencia del ID
            if (!$repositorioIngredientes->findById($id_ingrediente)) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Ingrediente no encontrado."]);
                exit;
            }

            $ingrediente = new Ingredientes(
                $id_ingrediente,
                $input['nombre'],
                $input['precio'],
                $input['tipo'],
                $input['foto'],
                $input['alergenos']
            );

            // Actualizar en la base de datos
            $result = $repositorioIngredientes->update($ingrediente);
            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Ingrediente actualizado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al actualizar el ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para actualizar el ingrediente."]);
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
