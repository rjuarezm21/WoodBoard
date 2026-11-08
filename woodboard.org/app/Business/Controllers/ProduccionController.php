<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\ProduccionService;

class ProduccionController
{
    private ProduccionService $produccionService;

    public function __construct(
        ProduccionService $produccionService
    ) {
        $this->produccionService =
            $produccionService;
    }

    public function listar(): array
    {
        return $this->produccionService
            ->listarProduccion();
    }

    public function datosFormularioCrear(): array
    {
        return [
            'metas' =>
                $this->produccionService
                    ->obtenerMetasActivas()
        ];
    }

    public function crear(
        array $datos,
        int $idUsuario
    ): array {
        return $this->produccionService
            ->registrarProduccion(
                $datos,
                $idUsuario
            );
    }
}