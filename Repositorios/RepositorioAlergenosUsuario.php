<?php
 // NO LO USO

class RepositorioAlergenosUsuario {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // CREATE
    public function create(AlergenosUsuario $alergenoUsuario): bool {
        $sql = "INSERT INTO Alergenos_Usuario (Alergenos_idAlergenos, Usuario_idUsuario) 
                VALUES (:id_alergenos, :id_usuario)";

        $stm = $this->con->prepare($sql);
        
        $stm->execute([
            'id_alergenos' => $alergenoUsuario->getIdAlergenos(),
            'id_usuario' => $alergenoUsuario->getIdUsuarios()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID (Find relation by alérgeno and usuario IDs)
    public function findById($id_alergenos, $id_usuario): ?AlergenosUsuario {
        $sql = "SELECT * FROM Alergenos_Usuario 
                WHERE Alergenos_idAlergenos = :id_alergenos 
                AND Usuario_idUsuario = :id_usuario";

        $stm = $this->con->prepare($sql);
        $stm->execute(['id_alergenos' => $id_alergenos, 'id_usuario' => $id_usuario]);
        
        $registro = $stm->fetch();

        if ($registro) {
            return new AlergenosUsuario(
                $registro['Alergenos_idAlergenos'],
                $registro['Usuario_idUsuario']
            );
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $sql = "SELECT * FROM Alergenos_Usuario";

        $stm = $this->con->prepare($sql);
        $stm->execute();

        $alergenosUsuarios = [];
        
        while ($registro = $stm->fetch()) {
            $alergenosUsuarios[] = new AlergenosUsuario(
                $registro['Alergenos_idAlergenos'],
                $registro['Usuario_idUsuario']
            );
        }
        
        return $alergenosUsuarios;
    }

    // UPDATE
    public function update(AlergenosUsuario $alergenoUsuario): bool {
        $sql = "UPDATE Alergenos_Usuario 
                SET Alergenos_idAlergenos = :id_alergenos 
                WHERE Usuario_idUsuario = :id_usuario";

        $stm = $this->con->prepare($sql);
        
        $stm->execute([
            'id_alergenos' => $alergenoUsuario->getIdAlergenos(),
            'id_usuario' => $alergenoUsuario->getIdUsuarios()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id_alergenos, $id_usuario): bool {
        $sql = "DELETE FROM Alergenos_Usuario 
                WHERE Alergenos_idAlergenos = :id_alergenos 
                AND Usuario_idUsuario = :id_usuario";

        $stm = $this->con->prepare($sql);
        $stm->execute(['id_alergenos' => $id_alergenos, 'id_usuario' => $id_usuario]);

        return $stm->rowCount() > 0;
    }
}

?>
