<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Empleado;
use PDO;

class EmpleadoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $idEmpleado): ?Empleado
    {
        $sql = "
            SELECT
                id_empleado,
                nombre,
                apellido,
                puesto,
                fecha_ingreso,
                estado,
                id_area
            FROM empleado
            WHERE id_empleado = :id_empleado
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_empleado' => $idEmpleado
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
                e.id_empleado,
                e.nombre,
                e.apellido,
                e.puesto,
                e.fecha_ingreso,
                e.estado,
                e.id_area,
                a.nombre_area
            FROM empleado e

            INNER JOIN area a
                ON a.id_area = e.id_area

            ORDER BY
                e.nombre,
                e.apellido
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crear(Empleado $empleado): int
    {
        $sql = "
            INSERT INTO empleado (
                nombre,
                apellido,
                puesto,
                fecha_ingreso,
                estado,
                id_area
            )
            VALUES (
                :nombre,
                :apellido,
                :puesto,
                :fecha_ingreso,
                :estado,
                :id_area
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre' =>
                $empleado->getNombre(),

            'apellido' =>
                $empleado->getApellido(),

            'puesto' =>
                $empleado->getPuesto(),

            'fecha_ingreso' =>
                $empleado->getFechaIngreso(),

            'estado' =>
                $empleado->getEstado()
                    ? 1
                    : 0,

            'id_area' =>
                $empleado->getIdArea()
        ]);

        return (int) $this->pdo
            ->lastInsertId();
    }

    public function actualizar(
        Empleado $empleado
    ): bool {
        $sql = "
            UPDATE empleado
            SET
                nombre = :nombre,
                apellido = :apellido,
                puesto = :puesto,
                fecha_ingreso = :fecha_ingreso,
                estado = :estado,
                id_area = :id_area
            WHERE id_empleado = :id_empleado
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre' =>
                $empleado->getNombre(),

            'apellido' =>
                $empleado->getApellido(),

            'puesto' =>
                $empleado->getPuesto(),

            'fecha_ingreso' =>
                $empleado->getFechaIngreso(),

            'estado' =>
                $empleado->getEstado()
                    ? 1
                    : 0,

            'id_area' =>
                $empleado->getIdArea(),

            'id_empleado' =>
                $empleado->getIdEmpleado()
        ]);
    }

    public function cambiarEstado(
        int $idEmpleado,
        bool $estado
    ): bool {
        $sql = "
            UPDATE empleado
            SET estado = :estado
            WHERE id_empleado = :id_empleado
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'estado' =>
                $estado ? 1 : 0,

            'id_empleado' =>
                $idEmpleado
        ]);
    }

    private function crearModelo(
        array $fila
    ): Empleado {
        return new Empleado(
            (int) $fila['id_empleado'],
            $fila['nombre'],
            $fila['apellido'],
            $fila['puesto'],
            $fila['fecha_ingreso'],
            (bool) $fila['estado'],
            (int) $fila['id_area']
        );
    }
}