<?php
/*
    Controlador de vistas y administración

    Descripción:
        Este archivo gestiona la inclusión dinámica de vistas en función de los parámetros de la URL. Dependiendo de los valores de los parámetros `menu` y `admin`, se incluyen las vistas correspondientes para la parte pública o administrativa de la aplicación.

    Funcionalidad:
        - Si se pasa el parámetro `menu` en la URL, se carga una vista pública correspondiente, como la página de inicio, el menú de kebabs, información sobre la empresa, contacto, etc.
        - Si se pasa el parámetro `admin`, se cargan vistas relacionadas con la administración de la tienda, como la gestión de ingredientes, kebabs, alérgenos y la creación de nuevos elementos.

    Parámetros:
        * `menu`: Determina qué vista pública mostrar en la aplicación. Algunos ejemplos incluyen:
            - `inicio`: Muestra la página principal.
            - `kebabCasa`: Muestra la vista para kebabs de la casa.
            - `kebabGusto`: Muestra la vista para kebabs a gusto.
            - `nosotros`: Muestra la página "Sobre Nosotros".
            - `contacto`: Muestra la página de contacto.
            - `carrito`: Muestra la vista del carrito de compras.
            - `cuenta`: Muestra la vista de la cuenta de usuario.
            - `login`: Muestra la página de inicio de sesión.
            - `register`: Muestra la página de registro de usuario.
            - `logout`: Ejecuta el proceso de cierre de sesión.
        * `admin`: Determina qué vista administrativa cargar, como la gestión de ingredientes, kebabs, o alérgenos. Los valores válidos son:
            - `ingredientes`: Muestra la vista para la gestión de ingredientes.
            - `crearIngredientes`: Muestra la vista para crear ingredientes.
            - `kebab`: Muestra la vista para la gestión de kebabs.
            - `alergenos`: Muestra la vista para la gestión de alérgenos.
            - `crearAlergenos`: Muestra la vista para crear alérgenos.

    Detalles de implementación:
        * El archivo evalúa los valores de los parámetros `menu` y `admin` mediante `$_GET` y carga las vistas correspondientes con la función `require_once`.
        * El parámetro `menu` controla el flujo de la vista pública, mientras que el parámetro `admin` controla el flujo de la vista administrativa.
        * Si no se proporciona un valor válido para `menu` o `admin`, se carga por defecto la página de inicio (`inicio`).

    Manejo de errores:
        * No se incluye un manejo explícito de errores si se pasa un valor no válido en los parámetros `menu` o `admin`, pero se carga la vista por defecto de la página de inicio (`inicio`).

    Ejemplo de uso:
        * Si se desea mostrar la página de inicio, la URL debe ser algo como:
            ```
            /index.php?menu=inicio
            ```
        * Si se desea acceder al panel de administración de ingredientes, la URL debe ser algo como:
            ```
            /index.php?admin=ingredientes
            ```

    TODO:
        * Mejorar la validación de los parámetros de entrada para evitar cargar vistas erróneas.
        * Considerar la posibilidad de incluir un sistema de redirección si los parámetros no coinciden con una vista existente.
*/

if (isset($_GET['menu'])) {

    // Vistas
    if ($_GET['menu'] == "inicio") {
        require_once './Vistas/Main/inisio.php';
    }
    if ($_GET['menu'] == "kebabCasa") {
        $dr = $_SERVER['DOCUMENT_ROOT'];
        require_once $dr . '/Vistas/Main/kebdecasa.php';
    }
    if ($_GET['menu'] == "kebabGusto") {
        require_once './Vistas/Main/kebalgusto.php';
    }
    if ($_GET['menu'] == "nosotros") {
        require_once './Vistas/Main/sobrenosotros.php';
    }
    if ($_GET['menu'] == "contacto") {
        require_once './Vistas/Main/contacto.php';
    }
    if ($_GET['menu'] == "carrito") {
        require_once './Vistas/Main/cart.php';
    }
    if ($_GET['menu'] == "cuenta") {
        require_once './Vistas/Cuenta/indexCuenta.php';
    }
    if ($_GET['menu'] == "login") {
        require_once './Vistas/Login/indexLogin.php';
    }
    if ($_GET['menu'] == "register") {
        require_once './Vistas/Register/indexRegister.php';
    }
    if ($_GET['menu'] == "logout") {
        require_once './Metodos/cerrarsesion.php';
    }

}

if (isset($_GET['admin'])) {
    switch ($_GET['admin']) {
        case "ingredientes":
            require_once './Vistas/Admin/modIngredientes.php';
            break;
        case "crearIngredientes":
            require_once './Vistas/Admin/crearIngredientes.php';
            break;

        case "kebab":
            require_once './Vistas/Admin/modKebab.php';
            break;

        case "alergenos":
            require_once './Vistas/Admin/modAlergenos.php';
            break;

        case "crearAlergenos":
            require_once './Vistas/Admin/crearAlergenos.php';
            break;
        
        case "kebabs":
            require_once './Vistas/Admin/crearKebabs.php';
            break;
            
        default:
            require_once './Vistas/Main/inisio.php';
            break;
    }
}
