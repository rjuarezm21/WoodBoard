<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\MetaProduccionService;

class MetaProduccionController
{
    private MetaProduccionService $metaService;

    public function __construct(
        MetaProduccionService $metaService
    ) {
        $this->metaService = $metaService;
    }

    public function listar(): array
    {
        return $this->metaService
            ->listarMetas();
    }

    public function obtener(
        int $idMeta
    ) {
        return $this->metaService
            ->obtenerMeta($idMeta);
    }

    public function crear(
        array $datos
    ): array {
        return $this->metaService
            ->registrarMeta($datos);
    }

    public function editar(
        int $idMeta,
        array $datos
    ): array {
        return $this->metaService
            ->actualizarMeta(
                $idMeta,
                $datos
            );
    }

    public function cambiarEstado(
        int $idMeta
    ): array {
        return $this->metaService
            ->cambiarEstado($idMeta);
    }
}