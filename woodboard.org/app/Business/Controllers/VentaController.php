<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\VentaService;

class VentaController
{
    private VentaService $ventaService;

    public function __construct(
        VentaService $ventaService
    ) {
        $this->ventaService =
            $ventaService;
    }

    public function listar(): array
    {
        return $this->ventaService
            ->listarVentas();
    }

    public function crear(
        array $datos,
        int $idUsuario
    ): array {
        return $this->ventaService
            ->registrarVenta(
                $datos,
                $idUsuario
            );
    }
}