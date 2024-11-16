<?php
class LineaPedido {

    // Atributos
    public $ID_LineaPedido;

    public $cantidad;
    public $descripcion;
    public $producto;

    public $ID_Pedido;

    // Constructor
    public function __construct($ID_LineaPedido, $cantidad, $descripcion, $producto, $ID_Pedido) {
        $this->ID_LineaPedido = $ID_LineaPedido;
        
        $this->cantidad = $cantidad;
        $this->descripcion = $descripcion;
        $this->producto = $producto;
        
        $this->ID_Pedido = $ID_Pedido;
    }

    
    // To String
    public function __toString() {
        return "LineaPedido [ID_LineaPedido = $this->ID_LineaPedido, cantidad = $this->cantidad, descripcion = $this->descripcion, producto = " . json_encode($this->producto) . ", ID_Pedido = $this->ID_Pedido]";
    }


    // Métodos Getters
    public function getIDLineaPedido() {
        return $this->ID_LineaPedido;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getProducto() {
        return $this->producto;
    }

    public function getIDPedido() {
        return $this->ID_Pedido;
    }


    // Métodos Setters
    public function setIDLineaPedido($ID_LineaPedido) {
        $this->ID_LineaPedido = $ID_LineaPedido;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setProducto($producto) {
        $this->producto = $producto;
    }

    public function setIDPedido($ID_Pedido) {
        $this->ID_Pedido = $ID_Pedido;
    }
}
?>
