<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Usuario;
use PDO;

class UsuarioRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorCorreo(string $correo): ?Usuario
    {
        $sql = "
            SELECT
                id_usuario,
                nombre,
                apellido,
                correo,
                contrasena,
                estado,
                id_rol,
                id_area
            FROM usuario
            WHERE correo = :correo
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'correo' => $correo
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->crearModelo($fila);
    }

    public function buscarPorId(int $idUsuario): ?Usuario
    {
        $sql = "
            SELECT
                id_usuario,
                nombre,
                apellido,
                correo,
                contrasena,
                estado,
                id_rol,
                id_area
            FROM usuario
            WHERE id_usuario = :id_usuario
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_usuario' => $idUsuario
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->crearModelo($fila);
    }

    public function listarTodos(): array
    {
        $sql = "
            SELECT
                u.id_usuario,
                u.nombre,
                u.apellido,
                u.correo,
                u.estado,
                u.id_rol,
                u.id_area,
                r.nombre_rol,
                a.nombre_area
            FROM usuario u

            INNER JOIN rol r
                ON r.id_rol = u.id_rol

            INNER JOIN area a
                ON a.id_area = u.id_area

            ORDER BY u.nombre, u.apellido
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function existeCorreo(string $correo): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM usuario
            WHERE correo = :correo
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'correo' => $correo
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function existeCorreoEnOtroUsuario(
        string $correo,
        int $idUsuario
    ): bool {
        $sql = "
            SELECT COUNT(*)
            FROM usuario
            WHERE correo = :correo
              AND id_usuario <> :id_usuario
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'correo' => $correo,
            'id_usuario' => $idUsuario
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function crear(Usuario $usuario): int
    {
        $sql = "
            INSERT INTO usuario (
                nombre,
                apellido,
                correo,
                contrasena,
                estado,
                id_rol,
                id_area
            )
            VALUES (
                :nombre,
                :apellido,
                :correo,
                :contrasena,
                :estado,
                :id_rol,
                :id_area
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'correo' => $usuario->getCorreo(),
            'contrasena' => $usuario->getContrasena(),
            'estado' => $usuario->getEstado() ? 1 : 0,
            'id_rol' => $usuario->getIdRol(),
            'id_area' => $usuario->getIdArea()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(Usuario $usuario): bool
    {
        $sql = "
            UPDATE usuario
            SET
                nombre = :nombre,
                apellido = :apellido,
                correo = :correo,
                contrasena = :contrasena,
                estado = :estado,
                id_rol = :id_rol,
                id_area = :id_area
            WHERE id_usuario = :id_usuario
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'correo' => $usuario->getCorreo(),
            'contrasena' => $usuario->getContrasena(),
            'estado' => $usuario->getEstado() ? 1 : 0,
            'id_rol' => $usuario->getIdRol(),
            'id_area' => $usuario->getIdArea(),
            'id_usuario' => $usuario->getIdUsuario()
        ]);
    }

    public function cambiarEstado(
        int $idUsuario,
        bool $estado
    ): bool {
        $sql = "
            UPDATE usuario
            SET estado = :estado
            WHERE id_usuario = :id_usuario
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'estado' => $estado ? 1 : 0,
            'id_usuario' => $idUsuario
        ]);
    }

    private function crearModelo(array $fila): Usuario
    {
        return new Usuario(
            (int) $fila['id_usuario'],
            $fila['nombre'],
            $fila['apellido'],
            $fila['correo'],
            $fila['contrasena'],
            (bool) $fila['estado'],
            (int) $fila['id_rol'],
            (int) $fila['id_area']
        );
    }
}