<?php
session_start();
require_once __DIR__ . '/../Repositorios/Database.php';
require_once __DIR__ . '/../Repositorios/RepositorioUsuario.php';
require_once __DIR__ . '/../Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = RepositorioUsuario::findAll();
    foreach ($users as $user) {
        if ($user->email === $username && $user->contrasena === $password) {
            $_SESSION['user'] = $user;
            echo '<script>window.location.href="../../?menu=inicio"</script>';
        }
    }
}
