<?php

class RepositorioUsuario {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($usuario) {
        $stm = $this->con->prepare("INSERT INTO Usuario (idUsuario, nombre, foto, contraseña, monedero, email, carrito, rol) 
                                    VALUES (:idUsuario, :nombre, :foto, :contraseña, :monedero, :email, :carrito, :rol)");
        
        $stm->execute([
            'idUsuario' => $usuario->getIDUsuario(),
            'nombre' => $usuario->getNombre(),
            'foto' => $usuario->getFoto(),
            'contraseña' => $usuario->getContraseña(),
            'monedero' => $usuario->getMonedero(),
            'email' => $usuario->getEmail(),
            'carrito' => json_encode($usuario->getCarrtio()), // Convertimos el carrito a JSON
            'rol' => $usuario->getRol()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id){
        $stm = $this->con->prepare("SELECT * FROM Usuario 
                                    WHERE idUsuario = :id");

        $stm->execute(['id' => $id]);
        
        $registro = $stm->fetch();

        if ($registro) {
            $usuario = new Usuario(
                $registro['idUsuario'],
                $registro['nombre'],
                $registro['foto'],
                $registro['contraseña'],
                $registro['direccion'],
                $registro['monedero'],
                $registro['email'],
                json_decode($registro['carrito'], true), // Decodificamos el JSON a un array
                $registro['rol']
            );
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
                $registro['email'],
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
                                    SET nombre = :nombre, foto = :foto, contraseña = :contraseña, monedero = :monedero, email = :email, carrito = :carrito, rol = :rol 
                                    WHERE idUsuario = :idUsuario");

        $stm->execute([
            'idUsuario' => $usuario->getIDUsuario(),
            'nombre' => $usuario->getNombre(),
            'foto' => $usuario->getFoto(),
            'contraseña' => $usuario->getContraseña(),
            'monedero' => $usuario->getMonedero(),
            'email' => $usuario->getEmail(),
            'carrito' => json_encode($usuario->getCarrtio()),
            'rol' => $usuario->getRol()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $stm = $this->con->prepare("DELETE FROM Usuario WHERE idUsuario = :id");
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
