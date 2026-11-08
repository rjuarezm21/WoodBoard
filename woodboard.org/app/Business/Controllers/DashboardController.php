<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\DashboardService;

class DashboardController
{
    private DashboardService $dashboardService;

    public function __construct(
        DashboardService $dashboardService
    ) {
        $this->dashboardService =
            $dashboardService;
    }

    public function general(): array
    {
        return $this->dashboardService
            ->obtenerDashboardGeneral();
    }

    public function produccion(
        array $filtros = []
    ): array {
        return $this->dashboardService
            ->obtenerDashboardProduccion(
                $filtros
            );
    }

    public function inventario(
        array $filtros = []
    ): array {
        return $this->dashboardService
            ->obtenerDashboardInventario(
                $filtros
            );
    }

    public function ventas(
        array $filtros = []
    ): array {
        return $this->dashboardService
            ->obtenerDashboardVentas(
                $filtros
            );
    }
}