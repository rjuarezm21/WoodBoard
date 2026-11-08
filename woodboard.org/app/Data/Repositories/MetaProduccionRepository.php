<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\MetaProduccion;
use PDO;

class MetaProduccionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(
        int $idMeta
    ): ?MetaProduccion {
        $sql = "
            SELECT
                id_meta,
                descripcion,
                cantidad_objetivo,
                fecha_inicio,
                fecha_fin,
                estado
            FROM meta_produccion
            WHERE id_meta = :id_meta
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_meta' => $idMeta
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->crearModelo($fila);
    }


    public function listarTodas(): array
    {
        $sql = "
            SELECT
                id_meta,
                descripcion,
                cantidad_objetivo,
                fecha_inicio,
                fecha_fin,
                estado
            FROM meta_produccion
            ORDER BY fecha_inicio DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $metas = [];

        foreach ($stmt->fetchAll() as $fila) {
            $metas[] =
                $this->crearModelo($fila);
        }

        return $metas;
    }


    public function listarActivas(): array
    {
        $sql = "
            SELECT
                id_meta,
                descripcion,
                cantidad_objetivo,
                fecha_inicio,
                fecha_fin,
                estado
            FROM meta_produccion
            WHERE estado = 1
            ORDER BY fecha_inicio DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $metas = [];

        foreach ($stmt->fetchAll() as $fila) {
            $metas[] =
                $this->crearModelo($fila);
        }

        return $metas;
    }


    public function crear(
        MetaProduccion $meta
    ): int {
        $sql = "
            INSERT INTO meta_produccion (
                descripcion,
                cantidad_objetivo,
                fecha_inicio,
                fecha_fin,
                estado
            )
            VALUES (
                :descripcion,
                :cantidad_objetivo,
                :fecha_inicio,
                :fecha_fin,
                :estado
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'descripcion' =>
                $meta->getDescripcion(),

            'cantidad_objetivo' =>
                $meta->getCantidadObjetivo(),

            'fecha_inicio' =>
                $meta->getFechaInicio(),

            'fecha_fin' =>
                $meta->getFechaFin(),

            'estado' =>
                $meta->getEstado()
                    ? 1
                    : 0
        ]);

        return (int)
            $this->pdo->lastInsertId();
    }


    public function actualizar(
        MetaProduccion $meta
    ): bool {
        $sql = "
            UPDATE meta_produccion
            SET
                descripcion = :descripcion,
                cantidad_objetivo = :cantidad_objetivo,
                fecha_inicio = :fecha_inicio,
                fecha_fin = :fecha_fin,
                estado = :estado
            WHERE id_meta = :id_meta
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'descripcion' =>
                $meta->getDescripcion(),

            'cantidad_objetivo' =>
                $meta->getCantidadObjetivo(),

            'fecha_inicio' =>
                $meta->getFechaInicio(),

            'fecha_fin' =>
                $meta->getFechaFin(),

            'estado' =>
                $meta->getEstado()
                    ? 1
                    : 0,

            'id_meta' =>
                $meta->getIdMeta()
        ]);
    }


    public function cambiarEstado(
        int $idMeta,
        bool $estado
    ): bool {
        $sql = "
            UPDATE meta_produccion
            SET estado = :estado
            WHERE id_meta = :id_meta
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'estado' =>
                $estado ? 1 : 0,

            'id_meta' =>
                $idMeta
        ]);
    }


    private function crearModelo(
        array $fila
    ): MetaProduccion {
        return new MetaProduccion(
            (int) $fila['id_meta'],
            $fila['descripcion'],
            (int) $fila['cantidad_objetivo'],
            $fila['fecha_inicio'],
            $fila['fecha_fin'],
            (bool) $fila['estado']
        );
    }
}