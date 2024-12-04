<?php

class RepositorioLineaPedido {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // CREATE
    public function create($linea) {
        $sqlaco = "INSERT INTO LineaPedido (idLineaPedido, linea_pedidos, Pedidos_idPedidos) 
                   VALUES (:idLineaPedido, :linea_pedidos, :idPedido)";

        $stm = $this->con->prepare($sqlaco);
        
        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'linea_pedidos' => json_encode($linea->getLineaPedidos()), // Encode linea_pedidos -> JSON
            'idPedido' => $linea->getIDPedido(),
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
                json_decode($registro['linea_pedidos'], true), // Decode linea_pedidos -> JSON
                $registro['Pedidos_idPedidos']
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
                json_decode($registro['linea_pedidos'], true), // Decode linea_pedidos -> JSON
                $registro['Pedidos_idPedidos'],
            );
        }
        
        return $lineas;
    }

    // UPDATE
    public function update($linea) {
        $sqlaco = "UPDATE LineaPedido 
                    SET linea_pedidos = :linea_pedidos, Pedidos_idPedidos = :idPedido 
                   WHERE idLineaPedido = :idLineaPedido";
        
        $stm = $this->con->prepare($sqlaco);

        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'linea_pedidos' => json_encode($linea->getLineaPedidos()), // Encode linea_pedidos -> JSON
            'idPedido' => $linea->getIDPedido(),
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
