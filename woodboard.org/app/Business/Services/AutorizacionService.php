<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Repositories\PermisoRepository;

class AutorizacionService
{
    private PermisoRepository $permisoRepository;

    public function __construct(
        PermisoRepository $permisoRepository
    ) {
        $this->permisoRepository = $permisoRepository;
    }

    public function tienePermiso(
        int $idRol,
        string $nombrePermiso
    ): bool {
        $nombrePermiso = trim($nombrePermiso);

        if ($idRol <= 0 || $nombrePermiso === '') {
            return false;
        }

        return $this->permisoRepository->rolTienePermiso(
            $idRol,
            $nombrePermiso
        );
    }
}