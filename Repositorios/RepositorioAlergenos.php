<?php

class RepositorioIngredientes {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($alergeno) {
        $stm = $this->con->prepare("INSERT INTO Alergenos (idAlergenos, tipo, foto) VALUES (:idAlergenos, :tipo, :foto)");
        
        $stm->execute([
            'idAlergenos' => $alergeno->getIDAlergenos(),
            'tipo' => $alergeno->getTipo(),
            'foto' => $alergeno->getFoto(),
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id){
        $stm = $this->con->prepare("SELECT * FROM Alergenos WHERE idAlergenos = :id");
        $stm->execute(['id' => $id]);
        
        $alergeno = null;
        $registro = $stm->fetch();

        if ($registro) {
            $alergeno = new Alergenos($registro['idAlergenos'], $registro['tipo'], $registro['foto']);
        }

        return $alergeno;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Alergenos");
        $stm->execute();

        $alergenos = [];
        while ($registro = $stm->fetch()) {
            $alergeno = new Alergenos($registro['idAlergenos'], $registro['tipo'], $registro['foto']);
            $alergenos[] = $alergeno;
        }
        
        return $alergenos;
    }

    // UPDATE
    public function update($alergeno) {
        $stm = $this->con->prepare("UPDATE Alergenos SET tipo = :tipo, foto = :foto WHERE idAlergenos = :idAlergenos");

        $stm->execute([
            'idAlergenos' => $alergeno->getIDAlergenos(),
            'tipo' => $alergeno->getTipo(),
            'foto' => $alergeno->getFoto(),
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $stm = $this->con->prepare("DELETE FROM Alergenos WHERE idAlergenos = :id");
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
?>
