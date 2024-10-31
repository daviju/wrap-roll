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
            __DIR__ . '/../Repositorios/'
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
