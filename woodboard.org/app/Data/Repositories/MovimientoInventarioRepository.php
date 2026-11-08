<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\MovimientoInventario;
use PDO;
use Throwable;

class MovimientoInventarioRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array
    {
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
                i.unidad_medida,

                u.nombre AS usuario_nombre,
                u.apellido AS usuario_apellido

            FROM movimiento_inventario m

            INNER JOIN inventario i
                ON i.id_inventario = m.id_inventario

            INNER JOIN usuario u
                ON u.id_usuario = m.id_usuario

            ORDER BY
                m.fecha_movimiento DESC,
                m.id_movimiento DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crearConActualizacionExistencia(
        MovimientoInventario $movimiento,
        int $nuevaCantidad
    ): int {
        try {

            $this->pdo->beginTransaction();

            /*
             * 1. Actualizar existencia.
             */
            $sqlInventario = "
                UPDATE inventario
                SET cantidad_disponible = :cantidad_disponible
                WHERE id_inventario = :id_inventario
            ";

            $stmtInventario =
                $this->pdo->prepare(
                    $sqlInventario
                );

            $stmtInventario->execute([
                'cantidad_disponible' =>
                    $nuevaCantidad,

                'id_inventario' =>
                    $movimiento->getIdInventario()
            ]);

            /*
             * 2. Registrar movimiento.
             */
            $sqlMovimiento = "
                INSERT INTO movimiento_inventario (
                    tipo_movimiento,
                    cantidad,
                    fecha_movimiento,
                    observacion,
                    id_inventario,
                    id_usuario
                )
                VALUES (
                    :tipo_movimiento,
                    :cantidad,
                    :fecha_movimiento,
                    :observacion,
                    :id_inventario,
                    :id_usuario
                )
            ";

            $stmtMovimiento =
                $this->pdo->prepare(
                    $sqlMovimiento
                );

            $stmtMovimiento->execute([
                'tipo_movimiento' =>
                    $movimiento->getTipoMovimiento(),

                'cantidad' =>
                    $movimiento->getCantidad(),

                'fecha_movimiento' =>
                    $movimiento->getFechaMovimiento(),

                'observacion' =>
                    $movimiento->getObservacion(),

                'id_inventario' =>
                    $movimiento->getIdInventario(),

                'id_usuario' =>
                    $movimiento->getIdUsuario()
            ]);

            $idMovimiento =
                (int) $this->pdo
                    ->lastInsertId();

            $this->pdo->commit();

            return $idMovimiento;

        } catch (Throwable $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }
}