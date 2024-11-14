<?php

class RepositorioIngredientesAlergenos {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($ingredienteAlergeno) {
        $sqlaco = "INSERT INTO Ingredientes_Alergenos (Ingredientes_idIngredientes, Alergenos_idAlergenos) 
                   VALUES (:idIngredientes, :idAlergenos, :tipo, :foto)";

        $stm = $this->con->prepare($sqlaco);
        
        $stm->execute([
            'idIngredientes' => $ingredienteAlergeno->getIDIngredientes(),
            'idAlergenos' => $ingredienteAlergeno->getIDAlergenos(),
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($idIngredientes, $idAlergenos) {
        $sqlaco = "SELECT *
                 FROM Ingredientes_Alergenos 
                 WHERE Ingredientes_idIngredientes = :idIngredientes AND Alergenos_idAlergenos = :idAlergenos";

        $stm = $this->con->prepare($sqlaco);
        
        $stm->execute([
            'idIngredientes' => $idIngredientes,
            'idAlergenos' => $idAlergenos,
        ]);
        
        $registro = $stm->fetch();

        if ($registro) {
            return new IngredientesAlergenos(
                $registro['Ingredientes_idIngredientes'],
                $registro['Alergenos_idAlergenos'],
            );
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $sqlaco = "SELECT * FROM Ingredientes_Alergenos";
        
        $stm = $this->con->prepare($sqlaco);
        $stm->execute();

        $ingredientesAlergenos = [];

        while ($registro = $stm->fetch()) {

            $ingredientesAlergenos[] = new IngredientesAlergenos(
                $registro['Ingredientes_idIngredientes'],
                $registro['Alergenos_idAlergenos'],
            );
        }
        
        return $ingredientesAlergenos;
    }

    // UPDATE
    public function update($ingredienteAlergeno) {
        $sqlaco = "UPDATE Ingredientes_Alergenos 
                    SET Alergenos_idAlergenos = :idAlergenos
                   WHERE Ingredientes_idIngredientes = :idIngredientes";
        
        $stm = $this->con->prepare($sqlaco);

        $stm->execute([
            'idIngredientes' => $ingredienteAlergeno->getIDIngredientes(),
            'idAlergenos' => $ingredienteAlergeno->getIDAlergenos(),
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($idIngredientes, $idAlergenos): bool {
        $sqlaco = "DELETE FROM Ingredientes_Alergenos 
                    WHERE Ingredientes_idIngredientes = :idIngredientes 
                    AND Alergenos_idAlergenos = :idAlergenos 
                    AND Alergenos_tipo = :tipo 
                    AND Alergenos_foto = :foto";
                    
        $stm = $this->con->prepare($sqlaco);
        
        $stm->execute([
            'idIngredientes' => $idIngredientes,
            'idAlergenos' => $idAlergenos,
        ]);

        return $stm->rowCount() > 0;
    }
}

?>
