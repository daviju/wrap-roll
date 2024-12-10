<?php
/*
    Clase LineaPedido

    Descripción:
        La clase `LineaPedido` representa una línea individual de un pedido en el sistema de gestión de pedidos. Cada línea de pedido está asociada a un pedido específico (referenciado por `ID_Pedido`) y contiene los detalles de los productos o artículos incluidos en ese pedido, que se almacenan en formato JSON en el atributo `linea_pedidos`.

    Atributos:
        - `ID_LineaPedido`: Identificador único de la línea de pedido.
        - `linea_pedidos`: Un objeto JSON que contiene los detalles de los artículos o productos que forman parte de esta línea de pedido.
        - `ID_Pedido`: Identificador del pedido al que pertenece esta línea de pedido.

    Métodos:
        - `__construct($ID_LineaPedido, $linea_pedidos, $ID_Pedido)`: Constructor que inicializa los atributos de la clase. Acepta un identificador único para la línea de pedido (`ID_LineaPedido`), los detalles de los productos como un JSON (`linea_pedidos`), y el identificador del pedido al que pertenece esta línea (`ID_Pedido`).
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de `LineaPedido`, mostrando `ID_LineaPedido`, los detalles de `linea_pedidos` (en formato JSON) y el `ID_Pedido`.
        - `getIDLineaPedido()`: Retorna el `ID_LineaPedido`, el identificador de la línea de pedido.
        - `getLineaPedidos()`: Retorna los detalles de los productos de esta línea de pedido, decodificados desde el formato JSON a un array.
        - `getIDPedido()`: Retorna el `ID_Pedido`, el identificador del pedido al que pertenece la línea de pedido.
        - `setIDLineaPedido($ID_LineaPedido)`: Establece el valor del `ID_LineaPedido`.
        - `setLineaPedidos($linea_pedidos)`: Establece los detalles de los productos, convirtiendo el array de productos en JSON antes de almacenarlos.
        - `setIDPedido($ID_Pedido)`: Establece el valor del `ID_Pedido`.

    Propósito:
        Esta clase es crucial para gestionar las líneas dentro de un pedido, donde cada línea contiene productos o artículos específicos. El uso de JSON permite almacenar de manera flexible y estructurada los detalles de los artículos en cada línea de pedido, permitiendo una fácil expansión y modificación de la estructura de los datos sin necesidad de modificar la base de datos.

    Ejemplo de uso:
        Crear un objeto de tipo `LineaPedido` y acceder a sus métodos:
        ```php
        $lineaPedido = new LineaPedido(1, '{"producto_id": 101, "cantidad": 2, "precio": 9.99}', 5);
        echo $lineaPedido->getIDLineaPedido();  // Muestra 1
        echo $lineaPedido->getIDPedido();  // Muestra 5
        print_r($lineaPedido->getLineaPedidos());  // Muestra el array decodificado de los productos
        ```

    TODO:
        * Asegurar que el formato JSON almacenado en `linea_pedidos` siempre sea válido y esté bien estructurado.
        * Validar que los datos de la línea de pedido no contengan información inconsistente o mal formada antes de ser almacenados.
        * Mejorar la gestión de errores al manipular JSON, por ejemplo, mediante el manejo de excepciones o validaciones de integridad.
*/

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