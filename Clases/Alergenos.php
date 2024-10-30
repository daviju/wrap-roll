<?php
class Alergenos {

    // Atributos
    private $ID_Alergenos;
    private $tipo;
    private $foto;


    // Constructor
    public function __construct($ID_Alergenos, $tipo, $foto) {
        $this->ID_Alergenos = $ID_Alergenos;
        $this->tipo = $tipo;
        $this->foto = $foto;
    }


    // To String
    public function __toString() {
        return "Alergeno [ID_Alergenos = $this->ID_Alergenos, tipo = $this->tipo, foto = $this->foto]";
    }


    // Métodos Getters
    public function getIDAlergenos() {
        return $this->ID_Alergenos;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFoto() {
        return $this->foto;
    }

    
    // Métodos Setters
    public function setIDAlergenos($ID_Alergenos) {
        $this->ID_Alergenos = $ID_Alergenos;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
}
?>
