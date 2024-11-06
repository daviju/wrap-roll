<?php
class Ingredientes {
    
    // Atributos
    private $ID_Ingredientes;
    private $nombre;
    private $precio;
    private $tipo;
    private $foto;


    // Constructor
    public function __construct($ID_Ingredientes, $nombre, $precio, $tipo, $foto) {
        $this->ID_Ingredientes = $ID_Ingredientes;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->foto = $foto;
    }


    // To String
    public function __toString() {
        return "Ingrediente [ID_Ingredientes = $this->ID_Ingredientes, nombre = $this->nombre, precio = $this->precio, tipo = $this->tipo, foto = $this->foto]";
    }


    // Métodos para obtener los valores de los atributos
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFoto() {
        return $this->foto;
    }
    

    // Métodos para establecer los valores de los atributos
    public function setIDIngredientes($ID_Ingredientes) {
        $this->ID_Ingredientes = $ID_Ingredientes;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
}
?>
