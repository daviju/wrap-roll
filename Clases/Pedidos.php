<?php
class Pedido {

    // Atributos
    public $ID_Pedido;

    public $estado;
    public $preciototal;
    public $fecha_hora;
    
    public $ID_Usuario;

    // Constructor
    public function __construct($ID_Pedido, $estado, $preciototal, $fechaHora, $ID_Usuario) {
        $this->ID_Pedido = $ID_Pedido;
        $this->estado = $estado;
        $this->preciototal = $preciototal;
        $this->fecha_hora = $fechaHora;  // Asegúrate de que la variable de fecha coincida
        $this->ID_Usuario = $ID_Usuario;
    }

    // To String
    public function __toString() {
        return "Pedido [ID_Pedido = $this->ID_Pedido, estado = $this->estado, precio total = $this->preciototal, fecha y hora = $this->fecha_hora, ID_Usuario = $this->ID_Usuario]";
    }

    // Métodos Getters
    public function getIDPedido() {
        return $this->ID_Pedido;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getPrecioTotal() {
        return $this->preciototal;
    }

    public function getFechaHora() {
        return $this->fecha_hora;
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

    public function setPrecioTotal($preciototal) {
        $this->preciototal = $preciototal;
    }

    public function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }
}
?>
