<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\RolService;

class RolController
{
    private RolService $rolService;

    public function __construct(
        RolService $rolService
    ) {
        $this->rolService = $rolService;
    }

    public function listar(): array
    {
        return $this->rolService
            ->listarRolesConPermisos();
    }

    public function datosEditar(
        int $idRol
    ): ?array {
        return $this->rolService
            ->datosEdicion($idRol);
    }

    public function editar(
        int $idRol,
        array $datos
    ): array {
        return $this->rolService
            ->actualizarRol(
                $idRol,
                $datos
            );
    }
}