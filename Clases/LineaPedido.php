<?php
class LineaPedido {

    // Atributos
    public $ID_LineaPedido;
    
    public $cantidad;
    public $precio;
    public $linea_pedidos;

    public $ID_Pedido;

    // Constructor
    public function __construct($ID_LineaPedido, $cantidad, $precio, $linea_pedidos, $ID_Pedido) {
        $this->ID_LineaPedido = $ID_LineaPedido;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->linea_pedidos = $linea_pedidos;
        $this->ID_Pedido = $ID_Pedido;
    }

    // To String
    public function __toString() {
        return "LineaPedido [ID_LineaPedido = $this->ID_LineaPedido, cantidad = $this->cantidad, precio = $this->precio, linea_pedidos = " . json_encode($this->linea_pedidos) . ", ID_Pedido = $this->ID_Pedido]";
    }

    // Métodos Getters
    public function getIDLineaPedido() {
        return $this->ID_LineaPedido;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getLineaPedidos() {
        return $this->linea_pedidos;
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

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setLineaPedidos($linea_pedidos) {
        $this->linea_pedidos = $linea_pedidos;
    }

    public function setIDPedido($ID_Pedido) {
        $this->ID_Pedido = $ID_Pedido;
    }
}
?>
