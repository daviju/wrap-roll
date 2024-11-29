<?php
class Autocargador
{
    public static function autocargar()
    {
        spl_autoload_register(function ($clase) {
            // Directorio raíz del proyecto
            $rootDir = $_SERVER['DOCUMENT_ROOT'];

            // Rutas de las carpetas donde están las clases
            $directories = [
                '/Api/',
                '/cargadores/',
                '/Clases/',
                '/css/',
                '/helper/',
                '/images/',
                '/js/',
                '/js/clasesjs/',
                '/Metodos/',
                '/Repositorios/',
                '/Vistas/',
                '/Vistas/Admin/',
                '/Vistas/Cuenta/',
                '/Vistas/Login/',
                '/Vistas/Mantenimiento/',
                '/Vistas/Principal/',
                '/Vistas/Register/',
            ];

            // Recorremos los directorios para buscar la clase
            foreach ($directories as $directory) {
                $fichero = $rootDir . $directory . $clase . '.php';

                // Si el archivo existe, lo incluimos
                if (file_exists($fichero)) {
                    require_once $fichero;
                    return;
                }
            }

            // Si no se encuentra el archivo, se lanza una excepción
            throw new UnexpectedValueException("No se pudo cargar la clase: $clase");
        });
    }
}

Autocargador::autocargar();