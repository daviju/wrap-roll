<?php
/*
    Autocargador de clases

    Descripción:
        Esta clase maneja la carga automática de clases en el proyecto, eliminando la necesidad de incluir manualmente archivos de clase.
        Utiliza la función `spl_autoload_register` para registrar una función que se activa cada vez que se intenta instanciar una clase que no ha sido cargada previamente.
        La función de autocarga recorre una lista de directorios para encontrar la clase correspondiente y cargarla.

    Métodos soportados:
        * static autocargar():
            - Registra una función anónima que busca y carga automáticamente las clases cuando son necesarias.
            - Recorre una lista de directorios predefinidos donde se esperan encontrar las clases del proyecto.

    Detalles de implementación:
        * El método de autocarga utiliza el directorio raíz del servidor para construir rutas hacia los directorios donde se almacenan las clases.
        * Si la clase no se encuentra en los directorios especificados, se lanza una excepción `UnexpectedValueException` con el nombre de la clase no encontrada.
        * Se utilizan rutas relativas para organizar las clases en diferentes carpetas del proyecto, facilitando su gestión.

    Rutas:
        No aplica, ya que no se expone como una API, pero se asegura que todas las clases sean cargadas automáticamente cuando se necesiten.

    Manejo de errores:
        * Si no se encuentra la clase, se lanza una excepción con un mensaje claro indicando que la clase no pudo ser cargada.
        * Esto permite capturar errores de carga de clases y evitar que el script continúe ejecutándose sin las clases necesarias.

    Ejemplo de uso:
        Al intentar instanciar cualquier clase definida en los directorios configurados, el autocargador la localizará y la incluirá automáticamente sin necesidad de importarla manualmente.
        Ejemplo:
        ```php
        $usuario = new Usuario();
        ```

    TODO:
        * Asegurarse de que todos los directorios relevantes estén correctamente configurados para la carga de clases.
        * Considerar la posibilidad de agregar un sistema de caché para optimizar la carga de clases.
*/

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