<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\AreaService;

class AreaController
{
    private AreaService $areaService;

    public function __construct(
        AreaService $areaService
    ) {
        $this->areaService = $areaService;
    }

    public function listar(): array
    {
        return $this->areaService
            ->listarAreas();
    }

    public function crear(
        array $datos
    ): array {
        return $this->areaService
            ->registrarArea($datos);
    }

    public function obtener(
        int $idArea
    ) {
        return $this->areaService
            ->obtenerArea($idArea);
    }

    public function editar(
        int $idArea,
        array $datos
    ): array {
        return $this->areaService
            ->actualizarArea(
                $idArea,
                $datos
            );
    }

    public function cambiarEstado(
        int $idArea
    ): array {
        return $this->areaService
            ->cambiarEstado($idArea);
    }
}