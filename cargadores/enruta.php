<?php

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

        default:
            require_once './Vistas/Main/inisio.php';
            break;
    }
}
