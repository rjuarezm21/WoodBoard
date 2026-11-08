<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Area;
use App\Data\Repositories\AreaRepository;

class AreaService
{
    private AreaRepository $areaRepository;

    public function __construct(
        AreaRepository $areaRepository
    ) {
        $this->areaRepository = $areaRepository;
    }

    public function listarAreas(): array
    {
        return $this->areaRepository
            ->listarTodas();
    }

    public function obtenerArea(
        int $idArea
    ): ?Area {
        if ($idArea <= 0) {
            return null;
        }

        return $this->areaRepository
            ->buscarPorId($idArea);
    }

    public function registrarArea(
        array $datos
    ): array {
        $nombre = trim(
            (string) ($datos['nombre_area'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        if ($nombre === '') {
            return [
                'ok' => false,
                'mensaje' => 'El nombre del área es obligatorio.'
            ];
        }

        $area = new Area(
            null,
            $nombre,
            $descripcion !== '' ? $descripcion : null,
            true
        );

        $idArea = $this->areaRepository
            ->crear($area);

        return [
            'ok' => true,
            'id_area' => $idArea
        ];
    }

    public function actualizarArea(
        int $idArea,
        array $datos
    ): array {
        $area = $this->areaRepository
            ->buscarPorId($idArea);

        if ($area === null) {
            return [
                'ok' => false,
                'mensaje' => 'El área no existe.'
            ];
        }

        $nombre = trim(
            (string) ($datos['nombre_area'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        if ($nombre === '') {
            return [
                'ok' => false,
                'mensaje' => 'El nombre del área es obligatorio.'
            ];
        }

        $area->setNombreArea($nombre);

        $area->setDescripcion(
            $descripcion !== ''
                ? $descripcion
                : null
        );

        $this->areaRepository
            ->actualizar($area);

        return [
            'ok' => true
        ];
    }

    public function cambiarEstado(
        int $idArea
    ): array {
        $area = $this->areaRepository
            ->buscarPorId($idArea);

        if ($area === null) {
            return [
                'ok' => false,
                'mensaje' => 'El área no existe.'
            ];
        }

        $nuevoEstado =
            !$area->getEstado();

        $this->areaRepository
            ->cambiarEstado(
                $idArea,
                $nuevoEstado
            );

        return [
            'ok' => true,
            'estado' => $nuevoEstado
        ];
    }
}