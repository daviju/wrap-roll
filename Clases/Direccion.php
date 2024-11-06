<?php

Class Direccion{

    // Atributos
    private $ID_Direccion;
    private $nombrevia;
    private $numero;
    private $tipovia;
    private $puerta;
    private $escalera;
    private $planta;
    private $localidad;


    // Constructor
    public function __construct($ID_Direccion, $nombrevia, $numero, $tipovia, $puerta, $escalera, $planta, $localidad) {
        $this->ID_Direccion = $ID_Direccion;
        $this->nombrevia = $nombrevia;
        $this->numero = $numero;
        $this->tipovia = $tipovia;
        $this->puerta = $puerta;
        $this->escalera = $escalera;
        $this->planta = $planta;
        $this->localidad = $localidad;
    }


    // To String
    public function __toString() {
        return $this->ID_Direccion . " " . $this->nombrevia . " " . $this->numero . " " . $this->tipovia . " " . $this->puerta . " " . $this->escalera . " " . $this->planta . " " . $this->localidad;
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
}