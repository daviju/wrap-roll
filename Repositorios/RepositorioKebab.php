<?php

class RepositorioKebab {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($kebab) {
        $stm = $this->con->prepare("INSERT INTO Kebab (idKebab, nombre, foto, precio) 
                                    VALUES (:idKebab, :nombre, :foto, :precio)");
        
        $stm->execute([
            'idKebab' => $kebab->getIDKebab(),
            'nombre' => $kebab->getNombre(),
            'foto' => $kebab->getFoto(),
            'precio' => $kebab->getPrecio()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id) {
        $stm = $this->con->prepare("SELECT * 
                                    FROM Kebab 
                                    WHERE idKebab = :id");
                                    
        $stm->execute(['id' => $id]);
        
        $kebab = null;
        $registro = $stm->fetch();

        if ($registro) {
            $kebab = new Kebab(
                $registro['idKebab'],
                $registro['nombre'],
                $registro['foto'],
                $registro['precio']
            );
        }
        return $kebab;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Kebab");
        $stm->execute();

        $kebabs = [];
        while ($registro = $stm->fetch()) {
            $kebab = new Kebab(
                $registro['idKebab'],
                $registro['nombre'],
                $registro['foto'],
                $registro['precio']
            );
            $kebabs[] = $kebab;
        }
        return $kebabs;
    }

    // UPDATE
    public function update($kebab) {
        $stm = $this->con->prepare("UPDATE Kebab SET nombre = :nombre, foto = :foto, precio = :precio WHERE idKebab = :idKebab");

        $stm->execute([
            'idKebab' => $kebab->getIDKebab(),
            'nombre' => $kebab->getNombre(),
            'foto' => $kebab->getFoto(),
            'precio' => $kebab->getPrecio()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        try {
            // Eliminar los ingredientes asociados antes de eliminar el kebab
            $this->eliminarIngredientes($id);

            // Eliminar el kebab
            $stm = $this->con->prepare("DELETE FROM Kebab WHERE idKebab = :id");
            $stm->execute(['id' => $id]);

            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el kebab: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar los ingredientes asociados a un kebab
    private function eliminarIngredientes($kebabId) {
        try {
            $sql = "DELETE FROM kebabingredientes WHERE Kebab_idKebab = :Kebab_idKebab";
            $stm = $this->con->prepare($sql);
            $stm->execute(['Kebab_idKebab' => $kebabId]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar los ingredientes asociados: " . $e->getMessage()]);
        }
    }
}
?>
