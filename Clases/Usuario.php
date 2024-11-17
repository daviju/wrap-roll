<?php
class Usuario {

    // Atributos
    public $ID_Usuario;
    public $nombre;
    public $foto;
    public $contraseña;
    public $monedero;
    public $carrito;
    public $rol;
    public $direccion;  // Nuevo atributo para la dirección


    // Constructor
    public function __construct($ID_Usuario, $nombre, $foto, $contraseña, $monedero, $carrito, $rol, $direccion = null) {
        $this->ID_Usuario = $ID_Usuario;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->contraseña = $contraseña;
        $this->monedero = $monedero;
        $this->carrito = $carrito;
        $this->rol = $rol;
        $this->direccion = $direccion;  // Asignar la dirección, si existe
    }

    // To String
    public function __toString() {
        return "Usuario [ID_Usuario = $this->ID_Usuario, nombre = $this->nombre, foto = $this->foto, monedero = $this->monedero, rol = $this->rol, direccion = " . json_encode($this->direccion) . "]";
    }

    // Métodos Getters
    public function getIDUsuario() {
        return $this->ID_Usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getContraseña() {
        return $this->contraseña;
    }

    public function getMonedero() {
        return $this->monedero;
    }

    public function getCarrito(){
        return $this->carrito;
    }

    public function getRol(){
        return $this->rol;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    // Métodos Setters
    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function setMonedero($monedero) {
        $this->monedero = $monedero;
    }

    public function setCarrito($carrito){
        $this->carrito = $carrito;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
}
?>
