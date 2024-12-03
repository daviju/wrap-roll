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

    /*
    if ($_GET['menu'] == "sessionr") {
        require_once './App/helpers/session.php';
    }
    if ($_GET['menu'] == "register") {
        require_once './views/mantenimiento/register.php';
    }
    if ($_GET['menu'] == "register-name") {
        require_once './views/mantenimiento/register-name.php';
    }
    if ($_GET['menu'] == "mantenimiento-kebab") {
        require_once './views/mantenimiento/mantenimiento-kebab.php';
    }
    if ($_GET['menu'] == "producto") {
        require_once './views/mantenimiento/producto.php';
    }
    if ($_GET['menu'] == "cierrarsession") {
        require_once './App/helpers/cierrarsession.php';
    }
    if ($_GET['menu'] == "carrito") {
        require_once './views/mantenimiento/carrito.php';
    }
    if ($_GET['menu'] == "perfil") {
        require_once './views/mantenimiento/perfil.php';
    }
    if ($_GET['menu'] == "compra") {
        require_once './views/mantenimiento/compra.php';
    }
    if ($_GET['menu'] == "registerr") {
        require_once './App/helpers/createRegister.php';
    }
    if ($_GET['menu'] == "pedido") {
        require_once './App/helpers/pedido.php';
    }
    if ($_GET['menu'] == "mispedidos") {
        require_once './views/mantenimiento/mispedidos.php';
    }
    */
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

            /*
            case "usuarios":
            require_once './Vistas/Admin/usuarios.php';
            break;
        case "alergenos":
            require_once './Vistas/Admin/alergenos.php';
            break;
        case "pedidos":
            require_once './Vistas/Admin/pedidos.php';
            break;
          */
        default:
            require_once './Vistas/Main/inisio.php';
            break;
    }
}
