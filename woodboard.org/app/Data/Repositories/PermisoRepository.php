<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Permiso;
use PDO;

class PermisoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerPorRol(int $idRol): array
    {
        $sql = "
            SELECT
                p.id_permiso,
                p.nombre_permiso,
                p.descripcion
            FROM permiso p
            INNER JOIN rol_permiso rp
                ON rp.id_permiso = p.id_permiso
            WHERE rp.id_rol = :id_rol
            ORDER BY p.id_permiso
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_rol' => $idRol
        ]);

        $filas = $stmt->fetchAll();

        $permisos = [];

        foreach ($filas as $fila) {
            $permisos[] = new Permiso(
                (int) $fila['id_permiso'],
                $fila['nombre_permiso'],
                $fila['descripcion']
            );
        }

        return $permisos;
    }

    public function listarTodos(): array
    {
        $sql = "
            SELECT
                id_permiso,
                nombre_permiso,
                descripcion
            FROM permiso
            ORDER BY id_permiso
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $filas = $stmt->fetchAll();

        $permisos = [];

        foreach ($filas as $fila) {
            $permisos[] = new Permiso(
                (int) $fila['id_permiso'],
                $fila['nombre_permiso'],
                $fila['descripcion']
            );
        }

        return $permisos;
    }

    public function rolTienePermiso(
        int $idRol,
        string $nombrePermiso
    ): bool {
        $sql = "
            SELECT COUNT(*)
            FROM rol_permiso rp
            INNER JOIN permiso p
                ON p.id_permiso = rp.id_permiso
            WHERE rp.id_rol = :id_rol
              AND p.nombre_permiso = :nombre_permiso
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_rol' => $idRol,
            'nombre_permiso' => $nombrePermiso
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function reemplazarPermisosRol(
        int $idRol,
        array $idsPermisos
    ): void {
        $this->pdo->beginTransaction();

        try {
            $sqlEliminar = "
                DELETE FROM rol_permiso
                WHERE id_rol = :id_rol
            ";

            $stmtEliminar = $this->pdo->prepare(
                $sqlEliminar
            );

            $stmtEliminar->execute([
                'id_rol' => $idRol
            ]);

            if (count($idsPermisos) > 0) {
                $sqlInsertar = "
                    INSERT INTO rol_permiso (
                        id_rol,
                        id_permiso
                    )
                    VALUES (
                        :id_rol,
                        :id_permiso
                    )
                ";

                $stmtInsertar = $this->pdo->prepare(
                    $sqlInsertar
                );

                foreach ($idsPermisos as $idPermiso) {
                    $stmtInsertar->execute([
                        'id_rol' => $idRol,
                        'id_permiso' => (int) $idPermiso
                    ]);
                }
            }

            $this->pdo->commit();

        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}