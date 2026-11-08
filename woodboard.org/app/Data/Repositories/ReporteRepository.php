<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use PDO;

class ReporteRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE VENTAS
    |--------------------------------------------------------------------------
    */

    public function obtenerVentas(
        string $fechaInicio,
        string $fechaFin
    ): array {
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

            WHERE v.fecha_venta
                BETWEEN :inicio AND :fin

            ORDER BY
                v.fecha_venta ASC,
                v.id_venta ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function obtenerProduccion(
        string $fechaInicio,
        string $fechaFin
    ): array {
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

            WHERE p.fecha
                BETWEEN :inicio AND :fin

            ORDER BY
                p.fecha ASC,
                p.id_produccion ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function obtenerMovimientosInventario(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                m.id_movimiento,
                m.tipo_movimiento,
                m.cantidad,
                m.fecha_movimiento,
                m.observacion,
                m.id_inventario,
                m.id_usuario,

                i.nombre_item,
                i.categoria,
                i.unidad_medida,

                u.nombre AS usuario_nombre,
                u.apellido AS usuario_apellido

            FROM movimiento_inventario m

            INNER JOIN inventario i
                ON i.id_inventario = m.id_inventario

            INNER JOIN usuario u
                ON u.id_usuario = m.id_usuario

            WHERE m.fecha_movimiento
                BETWEEN :inicio AND :fin

            ORDER BY
                m.fecha_movimiento ASC,
                m.id_movimiento ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }
}