<?php
/*
    Clase Usuario

    Descripción:
        La clase `Usuario` representa a un usuario dentro de un sistema. Esta clase almacena información personal del usuario, como su identificador único, nombre, foto, contraseña, saldo en el monedero, teléfono, carrito de compras, rol en el sistema y correo electrónico. Es útil para gestionar los datos del usuario en aplicaciones de compras en línea o sistemas donde los usuarios tienen diferentes roles y privilegios.

    Atributos:
        - `idUsuario`: Identificador único del usuario.
        - `nombre`: Nombre del usuario.
        - `foto`: Foto de perfil del usuario (URL o nombre del archivo).
        - `contrasena`: Contraseña del usuario (debería ser almacenada de forma segura, por ejemplo, usando hash).
        - `monedero`: Saldo o monto disponible en el monedero del usuario.
        - `telefono`: Número de teléfono del usuario.
        - `carrito`: El carrito de compras del usuario, representado como un JSON (o array).
        - `rol`: El rol del usuario en el sistema (por ejemplo, "admin", "cliente").
        - `email`: Correo electrónico del usuario.

    Métodos:
        - `__construct($idUsuario, $nombre, $foto, $contrasena, $monedero, $email, $carrito, $rol, $telefono)`: Constructor que inicializa los atributos de la clase con los valores proporcionados.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia del usuario, mostrando todos sus atributos relevantes.
        - `getIDUsuario()`: Retorna el `idUsuario`, el identificador único del usuario.
        - `getNombre()`: Retorna el nombre del usuario.
        - `getFoto()`: Retorna la foto del usuario.
        - `getContrasena()`: Retorna la contraseña del usuario.
        - `getMonedero()`: Retorna el saldo disponible en el monedero del usuario.
        - `getTelefono()`: Retorna el número de teléfono del usuario.
        - `getCarrito()`: Retorna el carrito de compras del usuario, decodificado de JSON a array.
        - `getRol()`: Retorna el rol del usuario en el sistema.
        - `getEmail()`: Retorna el correo electrónico del usuario.
        - `setIDUsuario($idUsuario)`: Establece el valor de `idUsuario`.
        - `setNombre($nombre)`: Establece el valor de `nombre`.
        - `setFoto($foto)`: Establece el valor de `foto`.
        - `setContrasena($contrasena)`: Establece el valor de `contrasena`.
        - `setMonedero($monedero)`: Establece el valor de `monedero`.
        - `setTelefono($telefono)`: Establece el valor de `telefono`.
        - `setCarrito($carrito)`: Establece el valor de `carrito`, codificando el array a JSON si es necesario.
        - `setRol($rol)`: Establece el valor de `rol`.
        - `setEmail($email)`: Establece el valor de `email`.

    Propósito:
        La clase `Usuario` es fundamental para gestionar la información relacionada con los usuarios de una aplicación o sistema. Específicamente, en sistemas de comercio electrónico o aplicaciones de pedidos en línea, puede utilizarse para realizar seguimientos de los pedidos, gestionar el saldo en el monedero, y asignar roles (como administrador o cliente). Además, permite gestionar el carrito de compras y las preferencias personales del usuario.

    Ejemplo de uso:
        Crear un objeto de tipo `Usuario` y acceder a sus métodos:
        ```php
        $usuario = new Usuario(1, "Juan Pérez", "foto.jpg", "contrasena123", 50.00, "juan@correo.com", [], "cliente", "555-1234");
        echo $usuario->getNombre();  // Muestra "Juan Pérez"
        echo $usuario->getEmail();  // Muestra "juan@correo.com"
        echo $usuario->getMonedero();  // Muestra 50.00
        ```

    TODO:
        * Asegurar que las contraseñas sean gestionadas de manera segura (por ejemplo, usando hashing con `password_hash()`).
        * Mejorar la validación y formato de los datos de entrada, especialmente para el correo electrónico, teléfono y monedero.
        * Implementar métodos adicionales si se requiere más funcionalidad, como agregar productos al carrito o realizar un pago con el monedero.
*/

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
