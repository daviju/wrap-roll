<?php
class Usuario {

    // Atributos
    public $idUsuario;
    public $nombre;
    public $foto;
    public $contrasena;
    public $monedero;
    public $telefono;
    public $carrito;
    public $rol;
    public $email;

    // Constructor
    public function __construct($idUsuario, $nombre, $foto, $contrasena, $monedero, $email, $carrito, $rol, $telefono) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->contrasena = $contrasena;
        $this->monedero = $monedero;
        $this->setEmail($email);
        $this->setCarrito($carrito);
        $this->rol = $rol;
        $this->telefono = $telefono;
    }
    
    // Método __toString
    public function __toString() {
        return "Usuario [idUsuario = $this->idUsuario, nombre = $this->nombre, foto = $this->foto, contrasena = $this->contrasena, monedero = $this->monedero, telefono = $this->telefono, rol = $this->rol, email = $this->email]";
    }

    // Métodos Getters
    public function getIDUsuario() {
        return $this->idUsuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getcontrasena() {
        return $this->contrasena;
    }

    public function getMonedero() {
        return $this->monedero;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCarrito() {
        return is_string($this->carrito) ? json_decode($this->carrito, true) : $this->carrito;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getEmail() {
        return $this->email;
    }

    // Métodos Setters
    public function setIDUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setcontrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function setMonedero($monedero) {
        $this->monedero = $monedero;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCarrito($carrito) {
        $this->carrito = is_array($carrito) ? json_encode($carrito) : $carrito;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}
?>
