<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Rol;
use PDO;

class RolRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $idRol): ?Rol
    {
        $sql = "
            SELECT
                id_rol,
                nombre_rol,
                descripcion,
                estado
            FROM rol
            WHERE id_rol = :id_rol
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_rol' => $idRol
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return new Rol(
            (int) $fila['id_rol'],
            $fila['nombre_rol'],
            $fila['descripcion'],
            (bool) $fila['estado']
        );
    }

    public function listarActivos(): array
    {
        $sql = "
            SELECT
                id_rol,
                nombre_rol,
                descripcion,
                estado
            FROM rol
            WHERE estado = 1
            ORDER BY nombre_rol
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $filas = $stmt->fetchAll();

        $roles = [];

        foreach ($filas as $fila) {
            $roles[] = new Rol(
                (int) $fila['id_rol'],
                $fila['nombre_rol'],
                $fila['descripcion'],
                (bool) $fila['estado']
            );
        }

        return $roles;
    }

    public function listarTodos(): array
    {
        $sql = "
            SELECT
                id_rol,
                nombre_rol,
                descripcion,
                estado
            FROM rol
            ORDER BY nombre_rol
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $filas = $stmt->fetchAll();

        $roles = [];

        foreach ($filas as $fila) {
            $roles[] = new Rol(
                (int) $fila['id_rol'],
                $fila['nombre_rol'],
                $fila['descripcion'],
                (bool) $fila['estado']
            );
        }

        return $roles;
    }
    public function actualizar(Rol $rol): bool
{
    $sql = "
        UPDATE rol
        SET
            nombre_rol = :nombre_rol,
            descripcion = :descripcion,
            estado = :estado
        WHERE id_rol = :id_rol
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        'nombre_rol' => $rol->getNombreRol(),
        'descripcion' => $rol->getDescripcion(),
        'estado' => $rol->getEstado() ? 1 : 0,
        'id_rol' => $rol->getIdRol()
    ]);
}
}