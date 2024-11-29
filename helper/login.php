<?php
class Login
{



    public static function login($user)
    {
        $_SESSION['user'] = $user;
    }

    public static function Identifica(string $usuario, string $contrasena, bool $recuerdame) {}

    private static function ExisteUsuario(string $usuario, string $contrasena = null) {}

    public static function UsuarioEstaLogueado()
    {
        return isset($_SESSION['user']);
    }
}
