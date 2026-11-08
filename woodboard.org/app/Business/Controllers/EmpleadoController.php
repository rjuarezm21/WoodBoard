<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\EmpleadoService;

class EmpleadoController
{
    private EmpleadoService $empleadoService;

    public function __construct(
        EmpleadoService $empleadoService
    ) {
        $this->empleadoService =
            $empleadoService;
    }

    public function listar(): array
    {
        return $this->empleadoService
            ->listarEmpleados();
    }

    public function datosFormularioCrear(): array
    {
        return [
            'areas' =>
                $this->empleadoService
                    ->obtenerAreasActivas()
        ];
    }

    public function crear(
        array $datos
    ): array {
        return $this->empleadoService
            ->registrarEmpleado($datos);
    }

    public function datosFormularioEditar(
        int $idEmpleado
    ): array {
        return [
            'empleado' =>
                $this->empleadoService
                    ->obtenerEmpleado(
                        $idEmpleado
                    ),

            'areas' =>
                $this->empleadoService
                    ->obtenerAreasActivas()
        ];
    }

    public function editar(
        int $idEmpleado,
        array $datos
    ): array {
        return $this->empleadoService
            ->actualizarEmpleado(
                $idEmpleado,
                $datos
            );
    }

    public function cambiarEstado(
        int $idEmpleado
    ): array {
        return $this->empleadoService
            ->cambiarEstado($idEmpleado);
    }
}