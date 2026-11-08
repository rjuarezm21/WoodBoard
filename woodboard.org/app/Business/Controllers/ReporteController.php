<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\ReporteService;

class ReporteController
{
    private ReporteService $reporteService;

    public function __construct(
        ReporteService $reporteService
    ) {
        $this->reporteService =
            $reporteService;
    }


    public function generar(
        array $filtros
    ): array {
        return $this->reporteService
            ->generarReporte(
                $filtros
            );
    }
}