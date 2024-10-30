<?php

class IngredientesAlergenos {

    // Atributos
    private $ID_Ingredientes;
    private $ID_Alergenos;
    private $tipo_alergenos;
    private $foto_alergenos;


    // Constructor
    public function __construct($ID_Ingredientes, $ID_Alergenos, $tipo_alergenos, $foto_alergenos) {
        $this->ID_Ingredientes = $ID_Ingredientes;
        $this->ID_Alergenos = $ID_Alergenos;
        $this->tipo_alergenos = $tipo_alergenos;
        $this->foto_alergenos = $foto_alergenos;
    }


    // To String
    public function __toString() {
        return "IngredientesAlergenos [ID_Ingredientes = $this->ID_Ingredientes, ID_Alergenos = $this->ID_Alergenos, tipo_alergenos = $this->tipo_alergenos, foto_alergenos = $this->foto_alergenos]";
    }


    // Métodos Getters
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }

    public function getIDAlergenos() {
        return $this->ID_Alergenos;
    }

    public function getTipoAlergenos() {
        return $this->tipo_alergenos;
    }

    public function getFotoAlergenos() {
        return $this->foto_alergenos;
    }

    
    // Métodos Setters
    public function setIDIngredientes($ID_Ingredientes) {
        $this->ID_Ingredientes = $ID_Ingredientes;
    }

    public function setIDAlergenos($ID_Alergenos) {
        $this->ID_Alergenos = $ID_Alergenos;
    }

    public function setTipoAlergenos($tipo_alergenos) {
        $this->tipo_alergenos = $tipo_alergenos;
    }

    public function setFotoAlergenos($foto_alergenos) {
        $this->foto_alergenos = $foto_alergenos;
    }
}
?>
