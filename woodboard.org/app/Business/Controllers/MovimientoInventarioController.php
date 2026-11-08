<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\MovimientoInventarioService;

class MovimientoInventarioController
{
    private MovimientoInventarioService $service;

    public function __construct(
        MovimientoInventarioService $service
    ) {
        $this->service = $service;
    }

    public function listar(): array
    {
        return $this->service
            ->listarMovimientos();
    }

    public function datosFormularioCrear(): array
    {
        return [
            'articulos' =>
                $this->service
                    ->obtenerArticulosActivos()
        ];
    }

    public function crear(
        array $datos,
        int $idUsuario
    ): array {
        return $this->service
            ->registrarMovimiento(
                $datos,
                $idUsuario
            );
    }
}