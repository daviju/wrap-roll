<?php

class RepositorioDireccion {
    private $con;

    public function __construct($con) {
        $this -> con = $con;
    }


    // CREATE
    public function create($direccion) {
        $stm = $this->con->prepare("INSERT INTO Direccion (idDireccion, nombrevia, numero, tipovia, puerta, escalera, planta, localidad, Usuario_idUsuario) 
                                    VALUES (:idDireccion, :nombrevia, :numero, :tipovia, :puerta, :escalera, :planta, :localidad, :idUsuario)");

        $stm->execute([
            'idDireccion' => $direccion->getIDDireccion(),
            'nombrevia' => $direccion->getNombrevia(),
            'numero' => $direccion->getNumero(),
            'tipovia' => $direccion->getTipovia(),
            'puerta' => $direccion->getPuerta(),
            'escalera' => $direccion->getEscalera(),
            'planta' => $direccion->getPlanta(),
            'localidad' => $direccion->getLocalidad(),
            'idUsuario' => $direccion->getID_Usuario()
        ]);

        return $stm->rowCount() > 0;
    }


    // FIND BY ID
    public function findById($id) {
        $stm = $this->con->prepare("SELECT * FROM Direccion 
                                    WHERE idDireccion = :id");

        $stm->execute(['id' => $id]);

        $registro = $stm->fetch();

        if ($registro) {
            return new Direccion(
                $registro['idDireccion'],
                $registro['nombrevia'],
                $registro['numero'],
                $registro['tipovia'],
                $registro['puerta'],
                $registro['escalera'],  
                $registro['planta'],
                $registro['localidad'],
                $registro['Usuario_idUsuario']
            );            
        }

        return null;
    }


    // FIND ALL
    public function findAll() {
        $stm = $this->con->prepare("SELECT * FROM Direccion");
        $stm->execute();

        $direcciones = [];

        while ($registro = $stm->fetch()) {
            $direcciones[] = new Direccion(
                $registro['idDireccion'],
                $registro['nombrevia'],
                $registro['numero'],
                $registro['tipovia'],
                $registro['puerta'],
                $registro['escalera'],
                $registro['planta'],
                $registro['localidad'], 
                $registro['Usuario_idUsuario']
            );
        }

        return $direcciones;
    }


    // UPDATE
    public function update($direccion) {
        $stm = $this->con->prepare("UPDATE Direccion 
                                    SET nombrevia = :nombrevia, numero = :numero, tipovia = :tipovia, puerta = :puerta, escalera = :escalera, planta = :planta, localidad = :localidad 
                                    WHERE idDireccion = :idDireccion");

        $stm->execute([
            'idDireccion' => $direccion->getIDDireccion(),
            'nombrevia' => $direccion->getNombrevia(),
            'numero' => $direccion->getNumero(),
            'tipovia' => $direccion->getTipovia(),
            'puerta' => $direccion->getPuerta(),
            'escalera' => $direccion->getEscalera(),    
            'planta' => $direccion->getPlanta(),
            'localidad' => $direccion->getLocalidad()
        ]);

        return $stm->rowCount() > 0;
    }


    // DELETE
    public function delete($id) {
        $stm = $this->con->prepare("DELETE FROM Direccion 
                                    WHERE idDireccion = :id");

        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}