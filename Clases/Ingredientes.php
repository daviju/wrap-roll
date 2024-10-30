<?php
class Ingredientes {
    
    // Atributos
    private $ID_Ingredientes;
    private $nombre;
    private $alergenos;


    // Constructor
    public function __construct($ID_Ingredientes, $nombre, array $alergenos) {
        $this->ID_Ingredientes = $ID_Ingredientes;
        $this->nombre = $nombre;
        $this->alergenos = $alergenos;
    }


    // To String
    public function __toString() {
        $alergenosStr = implode(", ", $this->alergenos);
        return "Ingrediente [ID_Ingredientes = $this->ID_Ingredientes, nombre = $this->nombre, alérgenos = $alergenosStr]";
    }


    // Métodos para obtener los valores de los atributos
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }

    public function getNombre() {
        return $this->nombre;
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

    public function setAlergenos(array $alergenos) {
        $this->alergenos = $alergenos;
    }
}
?>
