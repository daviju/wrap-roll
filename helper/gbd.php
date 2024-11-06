<?php

class GBD
{
    private static $conexion;

    public static function getConexion()
    {
        if (self::$conexion == null) {
            $db = new Database();
            self::$conexion = $db->getConnection();
        }
        return self::$conexion;
    }
}
