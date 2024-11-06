<?php
class Usuario {

    // Atributos
    private $ID_Usuario;
    private $nombre;
    private $foto;
    private $contraseña;
    private $monedero;
    private $email;
    private $carrito;
    private $rol;


    // Constructor
    public function __construct($ID_Usuario, $nombre, $foto, $contraseña, $monedero, $email, $carrito, $rol) {
        $this->ID_Usuario = $ID_Usuario;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->contraseña = $contraseña;
        $this->monedero = $monedero;
        $this->email = $email;
        $this->carrito = $carrito;
        $this->rol = $rol;
    }

    // Falta meter el carrito, como es json ni idea
    // To String
    public function __toString() {
        return "Usuario [ID_Usuario = $this->ID_Usuario, nombre = $this->nombre, foto = $this->foto, monedero = $this->monedero, email = $this->email, rol = $this->rol]";
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

    public function getEmail() {
        return $this->email;
    }

    public function getCarrtio(){
        return $this->carrito;
    }

    public function getRol(){
        return $this->rol;
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

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCarrito($carrito){
        $this->carrito = $carrito;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }
}
?>
