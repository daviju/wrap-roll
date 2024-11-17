<?php

class RepositorioUsuario {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($usuario) {
        $stm = $this->con->prepare("INSERT INTO Usuario (idUsuario, nombre, foto, contraseña, monedero, carrito, rol) 
                                    VALUES (:idUsuario, :nombre, :foto, :contraseña, :monedero, :carrito, :rol)");
        
        $stm->execute([
            'idUsuario' => $usuario->getIDUsuario(),
            'nombre' => $usuario->getNombre(),
            'foto' => $usuario->getFoto(),
            'contraseña' => $usuario->getContraseña(),
            'monedero' => $usuario->getMonedero(),
            'carrito' => json_encode($usuario->getCarrtio()), // Convertimos el carrito a JSON
            'rol' => $usuario->getRol()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id){
        $stm = $this->con->prepare("SELECT Usuario.*, Direccion.* 
                                    FROM Usuario 
                                    LEFT JOIN Direccion ON Usuario.idUsuario = Direccion.Usuario_idUsuario 
                                    WHERE Usuario.idUsuario = :id");

        $stm->execute(['id' => $id]);
        
        $registro = $stm->fetch();

        if ($registro) {
            // Crear un objeto de Usuario
            $usuario = new Usuario(
                $registro['idUsuario'],
                $registro['nombre'],
                $registro['foto'],
                $registro['contraseña'],
                $registro['monedero'],
                json_decode($registro['carrito'], true), // Decodificamos el carrito a un array
                $registro['rol']
            );

            // Agregar la dirección al usuario si existe
            $direccion = null;
            if ($registro['nombrevia']) {
                $direccion = [
                    'nombrevia' => $registro['nombrevia'],
                    'numero' => $registro['numero'],
                    'tipovia' => $registro['tipovia'],
                    'puerta' => $registro['puerta'],
                    'escalera' => $registro['escalera'],
                    'planta' => $registro['planta'],
                    'localidad' => $registro['localidad']
                ];
            }

            $usuario->setDireccion($direccion);

            return $usuario;
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Usuario");
        $stm->execute();

        $usuarios = [];
        while ($registro = $stm->fetch()) {
            $usuario = new Usuario(
                $registro['idUsuario'],
                $registro['nombre'],
                $registro['foto'],
                $registro['contraseña'],
                $registro['monedero'],
                json_decode($registro['carrito'], true),
                $registro['rol']
            );
            $usuarios[] = $usuario;
        }
        
        return $usuarios;
    }

    // UPDATE
    public function update($usuario) {
        $stm = $this->con->prepare("UPDATE Usuario 
                                    SET nombre = :nombre, foto = :foto, contraseña = :contraseña, monedero = :monedero, carrito = :carrito, rol = :rol 
                                    WHERE idUsuario = :idUsuario");

        $stm->execute([
            'idUsuario' => $usuario->getIDUsuario(),
            'nombre' => $usuario->getNombre(),
            'foto' => $usuario->getFoto(),
            'contraseña' => $usuario->getContraseña(),
            'monedero' => $usuario->getMonedero(),
            'carrito' => json_encode($usuario->getCarrtio()),
            'rol' => $usuario->getRol()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $stm = $this->con->prepare("DELETE FROM Usuario 
                                    WHERE idUsuario = :id");
                                    
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}

?>
