<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\InventarioService;

class InventarioController
{
    private InventarioService $inventarioService;

    public function __construct(
        InventarioService $inventarioService
    ) {
        $this->inventarioService =
            $inventarioService;
    }

    public function listar(): array
    {
        return $this->inventarioService
            ->listarInventario();
    }

    public function obtener(
        int $idInventario
    ) {
        return $this->inventarioService
            ->obtenerArticulo(
                $idInventario
            );
    }

    public function crear(
        array $datos
    ): array {
        return $this->inventarioService
            ->registrarArticulo($datos);
    }

    public function editar(
        int $idInventario,
        array $datos
    ): array {
        return $this->inventarioService
            ->actualizarArticulo(
                $idInventario,
                $datos
            );
    }

    public function cambiarEstado(
        int $idInventario
    ): array {
        return $this->inventarioService
            ->cambiarEstado(
                $idInventario
            );
    }
}