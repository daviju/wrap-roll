<?php
class GBD
{
    private static $conexion;

      
    public static function getConexion()
    {
        return self::conexion;
    }
}
