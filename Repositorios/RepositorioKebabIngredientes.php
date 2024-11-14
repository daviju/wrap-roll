<?php

class RepositorioKebabIngredientes {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($kebabIngredientes) {
        $stm = $this->con->prepare("INSERT INTO KebabIngredientes (Kebab_idKebab, Ingredientes_idIngredientes) 
                                    VALUES (:idKebab, :idIngrediente)");
        
        $stm->execute([
            'idKebab' => $kebabIngredientes->getIDKebab(),
            'idIngrediente' => $kebabIngredientes->getIDIngrediente()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY IDs
    public function findByIds($idKebab, $idIngrediente) {
        $stm = $this->con->prepare("SELECT * 
                                    FROM KebabIngredientes 
                                    WHERE Kebab_idKebab = :idKebab 
                                    AND Ingredientes_idIngredientes = :idIngrediente");

        $stm->execute([
            'idKebab' => $idKebab,
            'idIngrediente' => $idIngrediente
        ]);
        
        $registro = $stm->fetch();

        if ($registro) {
            return new KebabIngredientes(
                $registro['Kebab_idKebab'],
                $registro['Ingredientes_idIngredientes']
            );
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM KebabIngredientes");
        $stm->execute();

        $kebabsIngredientes = [];
        while ($registro = $stm->fetch()) {
            $kebabsIngredientes[] = new KebabIngredientes(
                $registro['Kebab_idKebab'],
                $registro['Ingredientes_idIngredientes']
            );
        }
        
        return $kebabsIngredientes;
    }

    // UPDATE
    public function update($kebabIngredientes) {
        $stm = $this->con->prepare("UPDATE KebabIngredientes 
                                    SET Ingredientes_idIngredientes = :idIngrediente 
                                    WHERE Kebab_idKebab = :idKebab");

        $stm->execute([
            'idKebab' => $kebabIngredientes->getIDKebab(),
            'idIngrediente' => $kebabIngredientes->getIDIngrediente()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($idKebab, $idIngrediente): bool {
        $stm = $this->con->prepare("DELETE 
                                    FROM KebabIngredientes 
                                    WHERE Kebab_idKebab = :idKebab 
                                    AND Ingredientes_idIngredientes = :idIngrediente");
                                    
        $stm->execute([
            'idKebab' => $idKebab,
            'idIngrediente' => $idIngrediente
        ]);

        return $stm->rowCount() > 0;
    }
}

?>
