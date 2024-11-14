<?php

class RepositorioIngredientes {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($ingrediente) {
        $stm = $this->con->prepare("INSERT INTO Ingredientes (idIngredientes, nombre, precio, tipo, foto) 
                                    VALUES (:idIngredientes, :nombre, :precio, :tipo, :foto)");
        
        $stm->execute([
            'idIngredientes' => $ingrediente->getIDIngredientes(),
            'nombre' => $ingrediente->getNombre(),
            'precio' => $ingrediente->getPrecio(),
            'tipo' => $ingrediente->getTipo(),
            'foto' => $ingrediente->getFoto(),
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id){
        $stm = $this->con->prepare("SELECT * 
                                    FROM Ingredientes 
                                    WHERE idIngredientes = :id");

        $stm->execute(['id' => $id]);
        
        $ingrediente = null;
        $registro = $stm->fetch();

        if ($registro) {
            $ingrediente = new Ingredientes($registro['idIngredientes'], $registro['nombre'], $registro['precio'], $registro['tipo'], $registro['foto']);
        }

        return $ingrediente;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Ingredientes");
        $stm->execute();

        $ingredientes = [];
        
        while ($registro = $stm->fetch()) {
            $ingrediente = new Ingredientes($registro['idIngredientes'], $registro['nombre'], $registro['precio'], $registro['tipo'], $registro['foto']);
            
            $ingredientes[] = $ingrediente;
        }
        
        return $ingredientes;
    }

    // UPDATE
    public function update($ingrediente) {
        $stm = $this->con->prepare("UPDATE Ingredientes 
                                    SET nombre = :nombre, precio = :precio, tipo = :tipo, foto = :foto 
                                    WHERE idIngredientes = :idIngredientes");
        
        $stm->execute([
            'idIngredientes' => $ingrediente->getIDIngredientes(),
            'nombre' => $ingrediente->getNombre(),
            'precio' => $ingrediente->getPrecio(),
            'tipo' => $ingrediente->getTipo(),
            'foto' => $ingrediente->getFoto(),
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $stm = $this->con->prepare("DELETE 
                                    FROM Ingredientes 
                                    WHERE idIngredientes = :id");
                                    
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
?>
