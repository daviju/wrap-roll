<?php
session_start();
require_once __DIR__ . '/../Repositorios/conexion.php';
require_once __DIR__ . '/../Repositorios/RepositorioUsuario.php';
require_once __DIR__ . '/../Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que los campos no están vacíos
    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Crear conexión utilizando tu clase Database
    $database = new Database();
    $db = $database->getConection();
    $repositorioUsuario = new RepositorioUsuario($db);

    // Verificar usuario
    $user = $repositorioUsuario->verifyUser($username, $password);

    // Si el usuario es válido, guardar información en sesión
    if ($user) {
        $_SESSION['user_id'] = $user->getIdUsuario();
        $_SESSION['user_email'] = $user->getEmail();
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Correo electrónico o contraseña incorrectos"]);
    }
}
?>
