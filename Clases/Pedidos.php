<?php
class Pedido {

    // Atributos
    private $ID_Pedido;
    private $estado;
    private $direccion;
    private $preciototal;
    private $ID_Usuario;


    // Constructor
    public function __construct($ID_Pedido, $estado, $direccion, $preciototal, $ID_Usuario) {
        $this->ID_Pedido = $ID_Pedido;
        $this->estado = $estado;
        $this->direccion = $direccion;
        $this->preciototal = $preciototal;
        $this->ID_Usuario = $ID_Usuario;
    }


    // To String
    public function __toString() {
        return "Pedido [ID_Pedido = $this->ID_Pedido, estado = $this->estado, dirección = $this->direccion, precio total = $this->preciototal, ID_Usuario = $this->ID_Usuario]";
    }


    // Métodos Getters
    public function getIDPedido() {
        return $this->ID_Pedido;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getPrecioTotal() {
        return $this->preciototal;
    }

    public function getIDUsuario() {
        return $this->ID_Usuario;
    }

    
    // Métodos Setters
    public function setIDPedido($ID_Pedido) {
        $this->ID_Pedido = $ID_Pedido;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setPrecioTotal($preciototal) {
        $this->preciototal = $preciototal;
    }

    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }
}
?>
