<?php
class LineaPedido {

    // Atributos
    private $ID_LineaPedido;
    private $cantidad;
    private $descripcion;
    private $producto;

    private $ID_Pedido;
    private $ID_Kebab;


    // Constructor
    public function __construct($ID_LineaPedido, $cantidad, $descripcion, $producto, $ID_Pedido, $ID_Kebab) {
        $this->ID_LineaPedido = $ID_LineaPedido;
        $this->cantidad = $cantidad;
        $this->descripcion = $descripcion;
        $this->producto = $producto;
        
        $this->ID_Pedido = $ID_Pedido;
        $this->ID_Kebab = $ID_Kebab;
    }

    
    // To String
    public function __toString() {
        return "LineaPedido [ID_LineaPedido = $this->ID_LineaPedido, cantidad = $this->cantidad, descripcion = $this->descripcion, producto = " . json_encode($this->producto) . ", ID_Pedido = $this->ID_Pedido, ID_Kebab = $this->ID_Kebab]";
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

    public function getIDKebab() {
        return $this->ID_Kebab;
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

    public function setIDKebab($ID_Kebab) {
        $this->ID_Kebab = $ID_Kebab;
    }
}
?>
