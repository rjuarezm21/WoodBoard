<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Area;
use PDO;

class AreaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $idArea): ?Area
    {
        $sql = "
            SELECT
                id_area,
                nombre_area,
                descripcion,
                estado
            FROM area
            WHERE id_area = :id_area
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_area' => $idArea
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->crearModelo($fila);
    }

    public function listarActivas(): array
    {
        $sql = "
            SELECT
                id_area,
                nombre_area,
                descripcion,
                estado
            FROM area
            WHERE estado = 1
            ORDER BY nombre_area
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $this->convertirFilasAModelos(
            $stmt->fetchAll()
        );
    }

    public function listarTodas(): array
    {
        $sql = "
            SELECT
                id_area,
                nombre_area,
                descripcion,
                estado
            FROM area
            ORDER BY nombre_area
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $this->convertirFilasAModelos(
            $stmt->fetchAll()
        );
    }

    public function crear(Area $area): int
    {
        $sql = "
            INSERT INTO area (
                nombre_area,
                descripcion,
                estado
            )
            VALUES (
                :nombre_area,
                :descripcion,
                :estado
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre_area' => $area->getNombreArea(),
            'descripcion' => $area->getDescripcion(),
            'estado' => $area->getEstado() ? 1 : 0
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(Area $area): bool
    {
        $sql = "
            UPDATE area
            SET
                nombre_area = :nombre_area,
                descripcion = :descripcion,
                estado = :estado
            WHERE id_area = :id_area
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre_area' => $area->getNombreArea(),
            'descripcion' => $area->getDescripcion(),
            'estado' => $area->getEstado() ? 1 : 0,
            'id_area' => $area->getIdArea()
        ]);
    }

    public function cambiarEstado(
        int $idArea,
        bool $estado
    ): bool {
        $sql = "
            UPDATE area
            SET estado = :estado
            WHERE id_area = :id_area
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'estado' => $estado ? 1 : 0,
            'id_area' => $idArea
        ]);
    }

    private function crearModelo(array $fila): Area
    {
        return new Area(
            (int) $fila['id_area'],
            $fila['nombre_area'],
            $fila['descripcion'],
            (bool) $fila['estado']
        );
    }

    private function convertirFilasAModelos(
        array $filas
    ): array {
        $areas = [];

        foreach ($filas as $fila) {
            $areas[] = $this->crearModelo($fila);
        }

        return $areas;
    }
}