<?php

class RepositorioUsuario
{
    public static $con;

    // Método para obtener un usuario por ID
    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM Usuario WHERE idUsuario = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            $registro = $stm->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return new Usuario(
                    $registro['idUsuario'],
                    $registro['nombre'],
                    $registro['foto'],
                    $registro['contrasena'],
                    $registro['monedero'],
                    $registro['email'],
                    json_decode($registro['carrito'], true),
                    $registro['rol'],
                    $registro['telefono'],
                );
            } else {
                echo json_encode(["error" => "Usuario no encontrado."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para verificar un usuario por email y contrasena
    public static function verifyUser($email, $password)
    {
        $con = Database::getConection();

        try {
            $usuario = self::findUserByEmail($email);

            if ($usuario && password_verify($password, $usuario['contrasena'])) {
                return new Usuario(
                    $usuario['idUsuario'],
                    $usuario['nombre'],
                    $usuario['foto'],
                    $usuario['contrasena'],
                    $usuario['monedero'],
                    $usuario['email'],
                    json_decode($usuario['carrito'], true),
                    $usuario['rol'],
                    $usuario['telefono']
                );
            }
            return null;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al verificar el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para obtener un usuario por email
    public static function findUserByEmail($email)
    {
        try {
            $con = Database::getConection();
            $sql = "SELECT * FROM Usuario WHERE email = :email";
            $stm = self::$con->prepare($sql); // Preparar la consulta SQL 
            $stm->execute(['email' => $email]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para crear un nuevo usuario
    public static function create(Usuario $usuario)
    {
        $con = Database::getConection();

        try {
            $carrito = json_encode($usuario->getCarrito());

            $sql = "INSERT INTO Usuario (nombre, foto, contrasena, monedero, email, carrito, rol, telefono)
                    VALUES (:nombre, :foto, :contrasena, :monedero, :email, :carrito, :rol, :telefono)";

            $stm = $con->prepare($sql);

            $stm->bindValue(':nombre', $usuario->getNombre());
            $stm->bindValue(':foto', $usuario->getFoto());
            $stm->bindValue(':contrasena', $usuario->getContrasena());
            $stm->bindValue(':monedero', $usuario->getMonedero());
            $stm->bindValue(':email', $usuario->getEmail());
            $stm->bindValue(':carrito', $carrito);
            $stm->bindValue(':rol', $usuario->getRol());
            $stm->bindValue(':telefono', $usuario->getTelefono());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el usuario: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para actualizar un usuario
    public static function update(Usuario $usuario)
    {
        try {
            $con = Database::getConection();

            $carrito = json_encode($usuario->getCarrito() ?? []);
            $sql = "UPDATE Usuario 
                    SET nombre = :nombre,
                        foto = :foto,
                        contrasena = :contrasena,
                        monedero = :monedero,
                        email = :email,
                        carrito = :carrito,
                        rol = :rol,
                        telefono = :telefono
                    WHERE idUsuario = :idUsuario;";

            $stm = $con->prepare($sql);

            $stm->bindValue(':idUsuario', $usuario->getIDUsuario());
            $stm->bindValue(':nombre', $usuario->getNombre());
            $stm->bindValue(':foto', $usuario->getFoto());
            $stm->bindValue(':contrasena', $usuario->getContrasena());
            $stm->bindValue(':monedero', $usuario->getMonedero());
            $stm->bindValue(':email', $usuario->getEmail());
            $stm->bindValue(':carrito', $carrito);
            $stm->bindValue(':rol', $usuario->getRol());
            $stm->bindValue(':telefono', $usuario->getTelefono());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el usuario: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar un usuario
    public static function delete($id)
    {
        $con = Database::getConection();

        try {
            $sql = "DELETE FROM Usuario 
                    WHERE idUsuario = :id";

            $stm = $con->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el usuario: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener todos los usuarios
    public static function findAll()
    {
        $con = Database::getConection();

        try {
            $sql = "SELECT * FROM Usuario";

            $stm = $con->prepare($sql);
            $stm->execute();
            $usuarios = [];

            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $user = new Usuario(
                    $registro['idUsuario'],
                    $registro['nombre'],
                    $registro['foto'],
                    $registro['contrasena'],
                    $registro['monedero'],
                    $registro['email'],
                    json_decode($registro['carrito'], true),
                    $registro['rol'],
                    $registro['telefono']
                );

                array_push($usuarios, $user);
            }

            return $usuarios;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los usuarios: " . $e->getMessage()]);
            return [];
        }
    }
}
