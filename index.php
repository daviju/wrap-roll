<?php

require 'cargadores/Autocargador.php';
Autocargador::autocargar();

class Principal
{
    public static function main()
    {
        require_once './helper/sesion.php';
        require_once './Vistas/Principal/layout.php';
    }
}

Principal::main();
?>
