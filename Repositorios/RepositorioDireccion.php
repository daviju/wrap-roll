<?php

class RepositorioDireccion {
    public $con;

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
    public static function findAll($idUsuario) {
        // Obtener conexión a la base de datos
        $con = Database::getConection();
    
        try {
            // Preparar la consulta con un parámetro para filtrar por ID de usuario
            $sql = "SELECT * FROM Direccion 
                    WHERE Usuario_idUsuario = :idUsuario";
            $stm = $con->prepare($sql);
    
            // Asignar el valor del parámetro
            $stm->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $stm->execute();
    
            $direcciones = [];
    
            // Recorrer los resultados y crear instancias de Direccion
            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
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
        } catch (PDOException $e) {
            // Manejo de errores
            throw new Exception("Error al obtener direcciones: " . $e->getMessage());
        }
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