<?php

Class Direccion {

    // Atributos
    private $ID_Direccion;
    private $nombrevia;
    private $numero;
    private $tipovia;
    private $puerta;
    private $escalera;
    private $planta;
    private $localidad;

    private $ID_Usuario;


    // Constructor
    public function __construct($ID_Direccion, $nombrevia, $numero, $tipovia, $puerta, $escalera, $planta, $localidad, $ID_Usuario) {
        $this->ID_Direccion = $ID_Direccion;
        $this->nombrevia = $nombrevia;
        $this->numero = $numero;
        $this->tipovia = $tipovia;
        $this->puerta = $puerta;
        $this->escalera = $escalera;
        $this->planta = $planta;
        $this->localidad = $localidad;
        $this->ID_Usuario = $ID_Usuario;
    }


    // To String
    public function __toString() {
        return $this->ID_Direccion . " " . $this->nombrevia . " " . $this->numero . " " . $this->tipovia . " " . $this->puerta . " " . $this->escalera . " " . $this->planta . " " . $this->localidad . " " . $this->ID_Usuario;
    }


    // Métodos Getters
    public function getIDDireccion() {
        return $this->ID_Direccion;
    }
    
    public function getNombrevia() {
        return $this->nombrevia;
    }
    
    public function getNumero() {
        return $this->numero;
    }
    
    public function getTipovia() {
        return $this->tipovia;
    }
    
    public function getPuerta() {
        return $this->puerta;
    }
    
    public function getEscalera() {
        return $this->escalera;
    }
    
    public function getPlanta() {
        return $this->planta;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function getID_Usuario() {
        return $this->ID_Usuario;
    }


    // Métodos Setters
    public function setIDDireccion($ID_Direccion) {
        $this->ID_Direccion = $ID_Direccion;
    }
    
    public function setNombrevia($nombrevia) {
        $this->nombrevia = $nombrevia;
    }
    
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    public function setTipovia($tipovia) {
        $this->tipovia = $tipovia;
    }
    
    public function setPuerta($puerta) {
        $this->puerta = $puerta;
    }

    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }
}