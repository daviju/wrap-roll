<?php
/*
    Clase Login

    Descripción:
        La clase `Login` proporciona métodos estáticos para gestionar el inicio de sesión de un usuario en el sistema. Esta clase maneja la sesión del usuario y la autenticación, permitiendo verificar si un usuario está logueado, realizar el inicio de sesión y gestionar la autenticación de usuario.

    Atributos:
        No se definen atributos directamente en esta clase, ya que todos los métodos son estáticos y la información relacionada con el usuario (como el estado de la sesión) se almacena en `$_SESSION`.

    Métodos:
        - `login($user)`: Método estático que inicia la sesión de un usuario. Al invocar este método, se almacena el objeto o la información del usuario en la variable `$_SESSION['user']`, lo que indica que el usuario ha iniciado sesión.
        - `Identifica($usuario, $contrasena, $recuerdame)`: Método estático que se encargará de identificar al usuario proporcionado mediante su nombre de usuario y contraseña. El parámetro `$recuerdame` puede indicar si se debe mantener la sesión activa más allá del tiempo predeterminado. Este método aún no está implementado.
        - `ExisteUsuario($usuario, $contrasena)`: Método privado que comprobará si existe un usuario con el nombre de usuario y la contraseña proporcionados. Este método aún no está implementado.
        - `UsuarioEstaLogueado()`: Método estático que verifica si un usuario está logueado en la sesión. Retorna `true` si existe `$_SESSION['user']` y `false` si no. Este método es útil para comprobar si se debe permitir el acceso a ciertas páginas o recursos solo a usuarios autenticados.

    Propósito:
        La clase `Login` es útil para gestionar el inicio de sesión de usuarios en aplicaciones web. Permite verificar si un usuario ha iniciado sesión, almacenar la información del usuario en la sesión, y realizar comprobaciones de autenticación y autorización. 

    Ejemplo de uso:
        Para iniciar sesión:
        ```php
        Login::login($usuario);  // Inicia sesión y guarda los datos del usuario en la sesión
        ```

        Para verificar si el usuario está logueado:
        ```php
        if (Login::UsuarioEstaLogueado()) {
            echo "El usuario está logueado.";
        } else {
            echo "El usuario no está logueado.";
        }
        ```

    TODO:
        - Implementar el método `Identifica` para autenticar a un usuario basándose en su nombre de usuario y contraseña.
        - Implementar el método `ExisteUsuario` para verificar si el usuario y la contraseña coinciden con la base de datos.
        - Agregar medidas de seguridad como hashing de contraseñas y protección contra ataques de inyección SQL.
*/

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
