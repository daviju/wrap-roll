<?php

class IngredientesAlergenos {

    // Atributos
    public $ID_Ingredientes;
    public $ID_Alergenos;


    // Constructor
    public function __construct($ID_Ingredientes, $ID_Alergenos){
        $this->ID_Ingredientes = $ID_Ingredientes;
        $this->ID_Alergenos = $ID_Alergenos;
    }


    // To String
    public function __toString() {
        return "IngredientesAlergenos [ID_Ingredientes = $this->ID_Ingredientes, ID_Alergenos = $this->ID_Alergenos]";
    }


    // Métodos Getters
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }

    public function getIDAlergenos() {
        return $this->ID_Alergenos;
    }
    
    
    // Métodos Setters
    public function setIDIngredientes($ID_Ingredientes) {
        $this->ID_Ingredientes = $ID_Ingredientes;
    }

    public function setIDAlergenos($ID_Alergenos) {
        $this->ID_Alergenos = $ID_Alergenos;
    }
}
?>
