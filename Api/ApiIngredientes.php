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
if ($method != 'GET' && $method != 'DELETE' && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "JSON malformado."]);
    exit;
}


switch ($method) {
    case 'GET':
        // Obtener el parámetro 'ID_Ingredientes' desde la URL
        if (isset($_GET['ID_Ingredientes'])) {
            // Obtener un ingrediente por ID
            $ingrediente = $repositorioIngredientes->findById($_GET['ID_Ingredientes']);
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
        // Leer los datos JSON del cuerpo de la solicitud
        $inputData = json_decode(file_get_contents("php://input"), true);

        if (isset($inputData['nombre'], $inputData['precio'], $inputData['tipo'], $inputData['foto'], $inputData['selectedAlergenos'])) {
            $nombre = $inputData['nombre'];
            $precio = $inputData['precio'];
            $tipo = $inputData['tipo'];
            $fotoNombre = $inputData['foto']; // Recibe solo el nombre del archivo
            $alergenos = $inputData['selectedAlergenos']; // Alérgenos ya están en el JSON

            // Validamos alergenos
            if (!is_array($alergenos)) {
                http_response_code(400);
                echo json_encode(["error" => "Formato inválido en alérgenos."]);
                exit;
            }

            // Crear el objeto Ingredientes
            $ingrediente = new Ingredientes(
                null, // ID será autogenerado
                $nombre,
                $precio,
                $tipo,
                $fotoNombre
            );

            // Guardar en la base de datos el ingrediente
            $ultimoID = $repositorioIngredientes->create($ingrediente);

            if ($ultimoID) { // Si se guardó correctamente
                // Asignar alérgenos al ingrediente creado
                $asignacionAlergenos = $repositorioIngredientes->asignarAlergeno($ultimoID, $alergenos);

                // Responder solo una vez con el mensaje de éxito
                if ($asignacionAlergenos) {
                    http_response_code(201); // Created
                    echo json_encode(["message" => "Ingrediente creado y alérgenos asignados correctamente."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al asignar los alérgenos."]);
                }
            } else { // Si hubo un error
                http_response_code(500);
                echo json_encode(["error" => "Error al crear el ingrediente."]);
            }
        } else { // Si no se proporcionaron los datos necesarios
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Datos incompletos para crear el ingrediente."]);
        }
        break;




    case 'PUT':
        // Verificar si se ha enviado como archivo ($_FILES) o como JSON (input)
        if (!empty($_FILES) && isset($_POST['ID_Ingredientes'], $_POST['nombre'], $_POST['precio'], $_POST['tipo'], $_POST['alergenos'])) {
            // Datos enviados como archivo
            $ID_Ingredientes = $_POST['ID_Ingredientes'];
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
            if (!$repositorioIngredientes->findById($ID_Ingredientes)) {
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
                $ID_Ingredientes,
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
        } elseif (isset($input['ID_Ingredientes'], $input['nombre'], $input['precio'], $input['tipo'], $input['foto'], $input['alergenos'])) {
            // Datos enviados como JSON (foto es el nombre del archivo)
            $ID_Ingredientes = $input['ID_Ingredientes'];

            // Validar existencia del ID
            if (!$repositorioIngredientes->findById($ID_Ingredientes)) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Ingrediente no encontrado."]);
                exit;
            }

            $ingrediente = new Ingredientes(
                $ID_Ingredientes,
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
        if (isset($_GET['ID_Ingredientes']) && !empty($_GET['ID_Ingredientes'])) {
            $id_ingrediente = $_GET['ID_Ingredientes'];

            $result = $repositorioIngredientes->delete($id_ingrediente);

            if ($result) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Ingrediente eliminado correctamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Error al eliminar el ingrediente."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "ID de ingrediente no proporcionado."]);
        }
        break;
    }
?>