<?php
class Ingredientes {
    
    // Atributos
    public $ID_Ingredientes;

    public $nombre;
    public $precio;
    public $tipo;
    public $foto;

    public $alergenos = [];


    // Constructor
    public function __construct($ID_Ingredientes, $nombre, $precio, $tipo, $foto, $alergenos = []) {
        $this->ID_Ingredientes = $ID_Ingredientes;
        
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->foto = $foto;
        $this->alergenos = $alergenos;
    }


    // To String
    public function __toString() {
        return "Ingrediente [ID_Ingredientes = $this->ID_Ingredientes, nombre = $this->nombre, precio = $this->precio, tipo = $this->tipo, foto = $this->foto, alergenos = [" . implode(", ", $this->alergenos) . "]";
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

    public function getAlergenos() {
        return $this->alergenos;
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

    public function setAlergenos($alergenos) {
        $this->alergenos = $alergenos;
    }
}
?>
