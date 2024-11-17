<?php
class Autocargador
{
    public static function autocargar()
    {
        spl_autoload_register('self::autocarga');
    }

    private static function autocarga($name)
    {
        // Lista de directorios donde buscar las clases
        $directories = [
            __DIR__ . '/../Api/',
            __DIR__ . '/../cargadores/',
            __DIR__ . '/../Clases/',
            __DIR__ . '/../css/',
            __DIR__ . '/../helper/',
            __DIR__ . '/../images/',
            __DIR__ . '/../js/',
            __DIR__ . '/../Metodos/',
            __DIR__ . '/../Repositorios/',
            __DIR__ . '/../Vistas/'
        ];

        // Recorre cada directorio para ver si existe el archivo de la clase
        foreach ($directories as $directory) {
            $file = $directory . $name . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
}
?>
