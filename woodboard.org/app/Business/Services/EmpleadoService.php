<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Empleado;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\EmpleadoRepository;
use DateTime;

class EmpleadoService
{
    private EmpleadoRepository $empleadoRepository;
    private AreaRepository $areaRepository;

    public function __construct(
        EmpleadoRepository $empleadoRepository,
        AreaRepository $areaRepository
    ) {
        $this->empleadoRepository = $empleadoRepository;
        $this->areaRepository = $areaRepository;
    }

    public function listarEmpleados(): array
    {
        return $this->empleadoRepository
            ->listarTodos();
    }

    public function obtenerEmpleado(
        int $idEmpleado
    ): ?Empleado {
        if ($idEmpleado <= 0) {
            return null;
        }

        return $this->empleadoRepository
            ->buscarPorId($idEmpleado);
    }

    public function obtenerAreasActivas(): array
    {
        return $this->areaRepository
            ->listarActivas();
    }

    public function registrarEmpleado(
        array $datos
    ): array {
        $nombre = trim(
            (string) ($datos['nombre'] ?? '')
        );

        $apellido = trim(
            (string) ($datos['apellido'] ?? '')
        );

        $puesto = trim(
            (string) ($datos['puesto'] ?? '')
        );

        $fechaIngreso = trim(
            (string) ($datos['fecha_ingreso'] ?? '')
        );

        $idArea = (int) (
            $datos['id_area'] ?? 0
        );

        if (
            $nombre === ''
            || $apellido === ''
            || $puesto === ''
            || $fechaIngreso === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Todos los campos obligatorios deben completarse.'
            ];
        }

        if (!$this->fechaValida($fechaIngreso)) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha de ingreso no es válida.'
            ];
        }

        $area = $this->areaRepository
            ->buscarPorId($idArea);

        if (
            $area === null
            || !$area->getEstado()
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El área seleccionada no es válida.'
            ];
        }

        $empleado = new Empleado(
            null,
            $nombre,
            $apellido,
            $puesto,
            $fechaIngreso,
            true,
            $idArea
        );

        $idEmpleado =
            $this->empleadoRepository
                ->crear($empleado);

        return [
            'ok' => true,
            'id_empleado' => $idEmpleado
        ];
    }

    public function actualizarEmpleado(
        int $idEmpleado,
        array $datos
    ): array {
        $empleado =
            $this->empleadoRepository
                ->buscarPorId($idEmpleado);

        if ($empleado === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El empleado no existe.'
            ];
        }

        $nombre = trim(
            (string) ($datos['nombre'] ?? '')
        );

        $apellido = trim(
            (string) ($datos['apellido'] ?? '')
        );

        $puesto = trim(
            (string) ($datos['puesto'] ?? '')
        );

        $fechaIngreso = trim(
            (string) ($datos['fecha_ingreso'] ?? '')
        );

        $idArea = (int) (
            $datos['id_area'] ?? 0
        );

        if (
            $nombre === ''
            || $apellido === ''
            || $puesto === ''
            || $fechaIngreso === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Todos los campos obligatorios deben completarse.'
            ];
        }

        if (!$this->fechaValida($fechaIngreso)) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha de ingreso no es válida.'
            ];
        }

        $area = $this->areaRepository
            ->buscarPorId($idArea);

        if (
            $area === null
            || !$area->getEstado()
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El área seleccionada no es válida.'
            ];
        }

        $empleado->setNombre($nombre);
        $empleado->setApellido($apellido);
        $empleado->setPuesto($puesto);
        $empleado->setFechaIngreso(
            $fechaIngreso
        );
        $empleado->setIdArea($idArea);

        $this->empleadoRepository
            ->actualizar($empleado);

        return [
            'ok' => true
        ];
    }

    public function cambiarEstado(
        int $idEmpleado
    ): array {
        $empleado =
            $this->empleadoRepository
                ->buscarPorId($idEmpleado);

        if ($empleado === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El empleado no existe.'
            ];
        }

        $nuevoEstado =
            !$empleado->getEstado();

        $this->empleadoRepository
            ->cambiarEstado(
                $idEmpleado,
                $nuevoEstado
            );

        return [
            'ok' => true,
            'estado' => $nuevoEstado
        ];
    }

    private function fechaValida(
        string $fecha
    ): bool {
        $objetoFecha =
            DateTime::createFromFormat(
                'Y-m-d',
                $fecha
            );

        return $objetoFecha !== false
            && $objetoFecha->format('Y-m-d')
            === $fecha;
    }
}