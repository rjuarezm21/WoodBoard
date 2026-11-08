<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Produccion;
use PDO;

class ProduccionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(
        int $idProduccion
    ): ?Produccion {
        $sql = "
            SELECT
                id_produccion,
                fecha,
                descripcion,
                cantidad_producida,
                id_meta,
                id_usuario
            FROM produccion
            WHERE id_produccion = :id_produccion
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_produccion' => $idProduccion
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
                p.id_produccion,
                p.fecha,
                p.descripcion,
                p.cantidad_producida,
                p.id_meta,
                p.id_usuario,
                m.descripcion AS meta_descripcion,
                u.nombre AS usuario_nombre,
                u.apellido AS usuario_apellido
            FROM produccion p

            INNER JOIN meta_produccion m
                ON m.id_meta = p.id_meta

            INNER JOIN usuario u
                ON u.id_usuario = p.id_usuario

            ORDER BY
                p.fecha DESC,
                p.id_produccion DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crear(
        Produccion $produccion
    ): int {
        $sql = "
            INSERT INTO produccion (
                fecha,
                descripcion,
                cantidad_producida,
                id_meta,
                id_usuario
            )
            VALUES (
                :fecha,
                :descripcion,
                :cantidad_producida,
                :id_meta,
                :id_usuario
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'fecha' =>
                $produccion->getFecha(),

            'descripcion' =>
                $produccion->getDescripcion(),

            'cantidad_producida' =>
                $produccion->getCantidadProducida(),

            'id_meta' =>
                $produccion->getIdMeta(),

            'id_usuario' =>
                $produccion->getIdUsuario()
        ]);

        return (int) $this->pdo
            ->lastInsertId();
    }

    private function crearModelo(
        array $fila
    ): Produccion {
        return new Produccion(
            (int) $fila['id_produccion'],
            $fila['fecha'],
            $fila['descripcion'],
            (int) $fila['cantidad_producida'],
            (int) $fila['id_meta'],
            (int) $fila['id_usuario']
        );
    }
}