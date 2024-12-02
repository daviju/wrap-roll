<?php
class Kebab {
    
    // Atributos
    public $ID_Kebab;
    public $nombre;
    public $foto;
    public $precio;

    public $ingredientes = [];

    // Constructor
    public function __construct($ID_Kebab, $nombre, $foto, $precio, $ingredientes = []) {
        $this->ID_Kebab = $ID_Kebab;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->precio = $precio;
        $this->ingredientes = $ingredientes;
    }


    // To String
    public function __toString() {
        return "Kebab [ID_Kebab = $this->ID_Kebab, nombre = $this->nombre, foto = $this->foto, precio = $this->precio, ingredientes = " . implode(", ", $this->ingredientes) . "]";
    }


    // Métodos Getters
    public function getIDKebab() {
        return $this->ID_Kebab;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getIngredientes() {
        return $this->ingredientes;
    }


    // Métodos Setters
    public function setIDKebab($ID_Kebab) {
        $this->ID_Kebab = $ID_Kebab;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function setIngredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }
    
}
?>
