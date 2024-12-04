<?php
class LineaPedido {

    // Atributos
    public $ID_LineaPedido;
    public $linea_pedidos; // JSON
    public $ID_Pedido;

    // Constructor
    public function __construct($ID_LineaPedido, $linea_pedidos, $ID_Pedido) {
        $this->ID_LineaPedido = $ID_LineaPedido;
        $this->linea_pedidos = $linea_pedidos; // Debe ser un JSON
        $this->ID_Pedido = $ID_Pedido;
    }

    // To String
    public function __toString() {
        return "LineaPedido [ID_LineaPedido = $this->ID_LineaPedido, linea_pedidos = " . json_encode($this->linea_pedidos) . ", ID_Pedido = $this->ID_Pedido]";
    }

    // Métodos Getters
    public function getIDLineaPedido() {
        return $this->ID_LineaPedido;
    }

    public function getLineaPedidos() {
        // Decodifica el JSON a un array
        return json_decode($this->linea_pedidos, true);
    }

    public function getIDPedido() {
        return $this->ID_Pedido;
    }

    // Métodos Setters
    public function setIDLineaPedido($ID_LineaPedido) {
        $this->ID_LineaPedido = $ID_LineaPedido;
    }

    public function setLineaPedidos($linea_pedidos) {
        // Convierte el array o el objeto a JSON antes de almacenar
        $this->linea_pedidos = json_encode($linea_pedidos);
    }

    public function setIDPedido($ID_Pedido) {
        $this->ID_Pedido = $ID_Pedido;
    }
}

?>