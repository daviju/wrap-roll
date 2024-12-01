<?php
session_start();
require_once __DIR__ . '/../Repositorios/Database.php';
require_once __DIR__ . '/../Repositorios/RepositorioUsuario.php';
require_once __DIR__ . '/../Clases/Usuario.php';

// Variable para el mensaje de error
$loginError = '';

// Comprobar si se está haciendo una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = RepositorioUsuario::findAll();
    $userFound = false;

    // Verificar las credenciales
    foreach ($users as $user) {
        if ($user->email === $username && $user->contrasena === $password) {
            $_SESSION['user'] = $user; // Iniciar sesión
            header("Location: ../../?menu=inicio"); // Redirigir a la página principal
            exit;
        }
    }

    // Si no se encontró el usuario, asignar el mensaje de error
    if (!$userFound) {
        $loginError = 'Usuario o contraseña incorrectos.';
    }
}
?>
