<?php

class KebabIngredientes {

    // Atributos
    public $ID_Kebab;
    public $ID_Ingrediente;

    
    // Constructor
    public function __construct($ID_Kebab, $ID_Ingrediente) {
        $this->ID_Kebab = $ID_Kebab;
        $this->ID_Ingrediente = $ID_Ingrediente;
    }


    // To String
    public function __toString() {
        return "KebabIngredientes [ID_Kebab = $this->ID_Kebab, ID_Ingrediente = $this->ID_Ingrediente]";
    }


    // Métodos Getters
    public function getIDKebab() {
        return $this->ID_Kebab;
    }

    public function getIDIngrediente() {
        return $this->ID_Ingrediente;
    }


    // Métodos Setters
    public function setIDKebab($ID_Kebab) {
        $this->ID_Kebab = $ID_Kebab;
    }

    public function setIDIngrediente($ID_Ingrediente) {
        $this->ID_Ingrediente = $ID_Ingrediente;
    }
}
?>
