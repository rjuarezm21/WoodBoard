<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use PDO;

class DashboardRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL
    |--------------------------------------------------------------------------
    */

    public function obtenerResumen(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $stmt = $this->pdo->prepare("
            SELECT COALESCE(SUM(monto_total), 0)
            FROM venta
            WHERE fecha_venta BETWEEN :inicio AND :fin
        ");

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $ventasMes =
            (float) $stmt->fetchColumn();


        $stmt = $this->pdo->prepare("
            SELECT COALESCE(SUM(cantidad), 0)
            FROM venta
            WHERE fecha_venta BETWEEN :inicio AND :fin
        ");

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $unidadesVendidas =
            (int) $stmt->fetchColumn();


        $stmt = $this->pdo->prepare("
            SELECT COALESCE(SUM(cantidad_producida), 0)
            FROM produccion
            WHERE fecha BETWEEN :inicio AND :fin
        ");

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $produccionMes =
            (int) $stmt->fetchColumn();


        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM inventario
            WHERE estado = 1
        ");

        $stmt->execute();

        $articulosActivos =
            (int) $stmt->fetchColumn();


        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM meta_produccion
            WHERE estado = 1
        ");

        $stmt->execute();

        $metasActivas =
            (int) $stmt->fetchColumn();


        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM (
                SELECT
                    m.id_meta

                FROM meta_produccion m

                LEFT JOIN produccion p
                    ON p.id_meta = m.id_meta

                WHERE m.estado = 1

                GROUP BY
                    m.id_meta,
                    m.cantidad_objetivo

                HAVING
                    COALESCE(
                        SUM(p.cantidad_producida),
                        0
                    ) >= m.cantidad_objetivo
            ) AS metas_cumplidas
        ");

        $stmt->execute();

        $metasCumplidas =
            (int) $stmt->fetchColumn();


        return [
            'ventas_mes' =>
                $ventasMes,

            'unidades_vendidas' =>
                $unidadesVendidas,

            'produccion_mes' =>
                $produccionMes,

            'articulos_activos' =>
                $articulosActivos,

            'metas_activas' =>
                $metasActivas,

            'metas_cumplidas' =>
                $metasCumplidas
        ];
    }


    public function obtenerVentasPorMes(
        string $desde
    ): array {
        $sql = "
            SELECT
                DATE_FORMAT(
                    fecha_venta,
                    '%Y-%m'
                ) AS periodo,

                COALESCE(
                    SUM(monto_total),
                    0
                ) AS total

            FROM venta

            WHERE fecha_venta >= :desde

            GROUP BY
                DATE_FORMAT(
                    fecha_venta,
                    '%Y-%m'
                )

            ORDER BY periodo ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'desde' => $desde
        ]);

        return $stmt->fetchAll();
    }


    public function obtenerProduccionPorMes(
        string $desde
    ): array {
        $sql = "
            SELECT
                DATE_FORMAT(
                    fecha,
                    '%Y-%m'
                ) AS periodo,

                COALESCE(
                    SUM(cantidad_producida),
                    0
                ) AS total

            FROM produccion

            WHERE fecha >= :desde

            GROUP BY
                DATE_FORMAT(
                    fecha,
                    '%Y-%m'
                )

            ORDER BY periodo ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'desde' => $desde
        ]);

        return $stmt->fetchAll();
    }


    public function obtenerProgresoMetas(): array
    {
        $sql = "
            SELECT
                m.id_meta,
                m.descripcion,
                m.cantidad_objetivo,
                m.fecha_inicio,
                m.fecha_fin,

                COALESCE(
                    SUM(p.cantidad_producida),
                    0
                ) AS cantidad_producida

            FROM meta_produccion m

            LEFT JOIN produccion p
                ON p.id_meta = m.id_meta

            WHERE m.estado = 1

            GROUP BY
                m.id_meta,
                m.descripcion,
                m.cantidad_objetivo,
                m.fecha_inicio,
                m.fecha_fin

            ORDER BY
                m.fecha_fin ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    /*
    |--------------------------------------------------------------------------
    | METAS EN EL PERÍODO
    |--------------------------------------------------------------------------
    */

    public function obtenerMetasPeriodo(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                m.id_meta,
                m.descripcion,
                m.cantidad_objetivo,
                m.fecha_inicio,
                m.fecha_fin,
                COALESCE(SUM(p.cantidad_producida), 0)
                    AS cantidad_producida
            FROM meta_produccion m
            LEFT JOIN produccion p
                ON p.id_meta = m.id_meta
            WHERE m.fecha_inicio <= :fin
                AND m.fecha_fin >= :inicio
            GROUP BY
                m.id_meta,
                m.descripcion,
                m.cantidad_objetivo,
                m.fecha_inicio,
                m.fecha_fin
            ORDER BY m.fecha_fin ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DE PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function obtenerResumenProduccionPeriodo(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                COALESCE(
                    SUM(cantidad_producida),
                    0
                ) AS total_producido,

                COUNT(*) AS total_registros,

                COUNT(
                    DISTINCT id_meta
                ) AS metas_trabajadas,

                COUNT(
                    DISTINCT fecha
                ) AS dias_con_produccion

            FROM produccion

            WHERE fecha
                BETWEEN :inicio AND :fin
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $fila = $stmt->fetch();

        return [
            'total_producido' =>
                (int) ($fila['total_producido'] ?? 0),

            'total_registros' =>
                (int) ($fila['total_registros'] ?? 0),

            'metas_trabajadas' =>
                (int) ($fila['metas_trabajadas'] ?? 0),

            'dias_con_produccion' =>
                (int) ($fila['dias_con_produccion'] ?? 0)
        ];
    }


    public function obtenerProduccionPorDia(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                fecha,

                COALESCE(
                    SUM(cantidad_producida),
                    0
                ) AS total

            FROM produccion

            WHERE fecha
                BETWEEN :inicio AND :fin

            GROUP BY fecha

            ORDER BY fecha ASC
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
    | DASHBOARD DE INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function obtenerResumenInventarioPeriodo(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM inventario
            WHERE estado = 1
        ");

        $stmt->execute();

        $articulosActivos =
            (int) $stmt->fetchColumn();


        $sql = "
            SELECT
                COUNT(*) AS total_movimientos,

                COALESCE(
                    SUM(
                        CASE
                            WHEN tipo_movimiento = 'ENTRADA'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS entradas,

                COALESCE(
                    SUM(
                        CASE
                            WHEN tipo_movimiento = 'SALIDA'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS salidas,

                COUNT(
                    DISTINCT id_inventario
                ) AS articulos_con_movimiento

            FROM movimiento_inventario

            WHERE fecha_movimiento
                BETWEEN :inicio AND :fin
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $fila = $stmt->fetch();

        return [
            'articulos_activos' =>
                $articulosActivos,

            'total_movimientos' =>
                (int) ($fila['total_movimientos'] ?? 0),

            'entradas' =>
                (int) ($fila['entradas'] ?? 0),

            'salidas' =>
                (int) ($fila['salidas'] ?? 0),

            'articulos_con_movimiento' =>
                (int) ($fila['articulos_con_movimiento'] ?? 0)
        ];
    }


    public function obtenerMovimientosInventarioPorDia(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                fecha_movimiento AS fecha,

                COALESCE(
                    SUM(
                        CASE
                            WHEN tipo_movimiento = 'ENTRADA'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS entradas,

                COALESCE(
                    SUM(
                        CASE
                            WHEN tipo_movimiento = 'SALIDA'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS salidas

            FROM movimiento_inventario

            WHERE fecha_movimiento
                BETWEEN :inicio AND :fin

            GROUP BY
                fecha_movimiento

            ORDER BY
                fecha_movimiento ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }


    public function obtenerExistenciasInventario(): array
    {
        $sql = "
            SELECT
                id_inventario,
                nombre_item,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado

            FROM inventario

            WHERE estado = 1

            ORDER BY
                nombre_item ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function obtenerUltimosMovimientosInventario(
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

                i.nombre_item,
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
                m.fecha_movimiento DESC,
                m.id_movimiento DESC

            LIMIT 10
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
    | DASHBOARD DE VENTAS
    |--------------------------------------------------------------------------
    */

    public function obtenerResumenVentasPeriodo(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                COALESCE(
                    SUM(monto_total),
                    0
                ) AS monto_total,

                COALESCE(
                    SUM(cantidad),
                    0
                ) AS unidades_vendidas,

                COUNT(*) AS total_ventas

            FROM venta

            WHERE fecha_venta
                BETWEEN :inicio AND :fin
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        $fila = $stmt->fetch();

        return [
            'monto_total' =>
                (float) ($fila['monto_total'] ?? 0),

            'unidades_vendidas' =>
                (int) ($fila['unidades_vendidas'] ?? 0),

            'total_ventas' =>
                (int) ($fila['total_ventas'] ?? 0)
        ];
    }


    public function obtenerVentasPorDia(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                fecha_venta AS fecha,

                COALESCE(
                    SUM(monto_total),
                    0
                ) AS monto,

                COALESCE(
                    SUM(cantidad),
                    0
                ) AS unidades

            FROM venta

            WHERE fecha_venta
                BETWEEN :inicio AND :fin

            GROUP BY
                fecha_venta

            ORDER BY
                fecha_venta ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }


    public function obtenerProductosMasVendidos(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $sql = "
            SELECT
                descripcion,

                COALESCE(
                    SUM(cantidad),
                    0
                ) AS cantidad_vendida,

                COALESCE(
                    SUM(monto_total),
                    0
                ) AS monto_vendido

            FROM venta

            WHERE fecha_venta
                BETWEEN :inicio AND :fin

            GROUP BY
                descripcion

            ORDER BY
                cantidad_vendida DESC,
                monto_vendido DESC

            LIMIT 10
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ]);

        return $stmt->fetchAll();
    }
}