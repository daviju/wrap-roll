<?php
class Kebab {
    
    // Atributos
    public $ID_Kebab;
    public $nombre;
    public $foto;
    public $precio;


    // Constructor
    public function __construct($ID_Kebab, $nombre, $foto, $precio) {
        $this->ID_Kebab = $ID_Kebab;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->precio = $precio;
    }


    // To String
    public function __toString() {
        return "Kebab [ID_Kebab = $this->ID_Kebab, nombre = $this->nombre, foto = $this->foto, precio = $this->precio]";
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
    
}
?>
