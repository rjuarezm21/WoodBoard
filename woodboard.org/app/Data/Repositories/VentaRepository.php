<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Venta;
use PDO;

class VentaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(
        int $idVenta
    ): ?Venta {
        $sql = "
            SELECT
                id_venta,
                fecha_venta,
                descripcion,
                cantidad,
                monto_total,
                id_usuario
            FROM venta
            WHERE id_venta = :id_venta
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_venta' => $idVenta
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
                v.id_venta,
                v.fecha_venta,
                v.descripcion,
                v.cantidad,
                v.monto_total,
                v.id_usuario,

                u.nombre AS usuario_nombre,
                u.apellido AS usuario_apellido

            FROM venta v

            INNER JOIN usuario u
                ON u.id_usuario = v.id_usuario

            ORDER BY
                v.fecha_venta DESC,
                v.id_venta DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crear(
        Venta $venta
    ): int {
        $sql = "
            INSERT INTO venta (
                fecha_venta,
                descripcion,
                cantidad,
                monto_total,
                id_usuario
            )
            VALUES (
                :fecha_venta,
                :descripcion,
                :cantidad,
                :monto_total,
                :id_usuario
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'fecha_venta' =>
                $venta->getFechaVenta(),

            'descripcion' =>
                $venta->getDescripcion(),

            'cantidad' =>
                $venta->getCantidad(),

            'monto_total' =>
                $venta->getMontoTotal(),

            'id_usuario' =>
                $venta->getIdUsuario()
        ]);

        return (int)
            $this->pdo->lastInsertId();
    }

    private function crearModelo(
        array $fila
    ): Venta {
        return new Venta(
            (int) $fila['id_venta'],
            $fila['fecha_venta'],
            $fila['descripcion'],
            (int) $fila['cantidad'],
            (float) $fila['monto_total'],
            (int) $fila['id_usuario']
        );
    }
}