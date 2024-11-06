<?php

class RepositorioLineaPedido {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($linea) {
        $sqlaco = "INSERT INTO LineaPedido (idLineaPedido, cantidad, descripcion, producto, Pedidos_idPedidos, Kebab_idKebab) 
                   VALUES (:idLineaPedido, :cantidad, :descripcion, :producto, :idPedido, :idKebab)";

        $stm = $this->con->prepare($sqlaco);
        
        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'cantidad' => $linea->getCantidad(),
            'descripcion' => $linea->getDescripcion(),
            'producto' => json_encode($linea->getProducto()), // Encode producto -> JSON
            'idPedido' => $linea->getIDPedido(),
            'idKebab' => $linea->getIDKebab()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id) {
        $sqlaco = "SELECT * FROM LineaPedido 
                    WHERE idLineaPedido = :id";

        $stm = $this->con->prepare($sqlaco);
        $stm->execute(['id' => $id]);
        
        $registro = $stm->fetch();

        if ($registro) {
            return new LineaPedido(
                $registro['idLineaPedido'],
                $registro['cantidad'],
                $registro['descripcion'],
                json_decode($registro['producto'], true), // Decode producto -> JSON
                $registro['Pedidos_idPedidos'],
                $registro['Kebab_idKebab']
            );
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $sqlaco = "SELECT * FROM LineaPedido";

        $stm = $this->con->prepare($sqlaco);
        $stm->execute();

        $lineas = [];
        
        while ($registro = $stm->fetch()) {
            $lineas[] = new LineaPedido(
                $registro['idLineaPedido'],
                $registro['cantidad'],
                $registro['descripcion'],
                json_decode($registro['producto'], true), // Decode producto -> JSON
                $registro['Pedidos_idPedidos'],
                $registro['Kebab_idKebab']
            );
        }
        
        return $lineas;
    }

    // UPDATE
    public function update($linea) {
        $sqlaco = "UPDATE LineaPedido 
                    SET cantidad = :cantidad, descripcion = :descripcion, producto = :producto, Pedidos_idPedidos = :idPedido, Kebab_idKebab = :idKebab 
                   WHERE idLineaPedido = :idLineaPedido";
        
        $stm = $this->con->prepare($sqlaco);

        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'cantidad' => $linea->getCantidad(),
            'descripcion' => $linea->getDescripcion(),
            'producto' => json_encode($linea->getProducto()), // Encode producto -> JSON
            'idPedido' => $linea->getIDPedido(),
            'idKebab' => $linea->getIDKebab()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $sqlaco = "DELETE FROM LineaPedido 
                    WHERE idLineaPedido = :id";

        $stm = $this->con->prepare($sqlaco);
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
?>
