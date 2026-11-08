<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\MetaProduccion;
use App\Data\Repositories\MetaProduccionRepository;
use DateTime;

class MetaProduccionService
{
    private MetaProduccionRepository $metaRepository;

    public function __construct(
        MetaProduccionRepository $metaRepository
    ) {
        $this->metaRepository = $metaRepository;
    }

    public function listarMetas(): array
    {
        return $this->metaRepository
            ->listarTodas();
    }

    public function obtenerMeta(
        int $idMeta
    ): ?MetaProduccion {
        if ($idMeta <= 0) {
            return null;
        }

        return $this->metaRepository
            ->buscarPorId($idMeta);
    }

    public function registrarMeta(
        array $datos
    ): array {
        $validacion =
            $this->validarDatos($datos);

        if (!$validacion['ok']) {
            return $validacion;
        }

        $meta = new MetaProduccion(
            null,
            $validacion['descripcion'],
            $validacion['cantidad_objetivo'],
            $validacion['fecha_inicio'],
            $validacion['fecha_fin'],
            true
        );

        $idMeta =
            $this->metaRepository
                ->crear($meta);

        return [
            'ok' => true,
            'id_meta' => $idMeta
        ];
    }

    public function actualizarMeta(
        int $idMeta,
        array $datos
    ): array {
        $meta =
            $this->metaRepository
                ->buscarPorId($idMeta);

        if ($meta === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La meta no existe.'
            ];
        }

        $validacion =
            $this->validarDatos($datos);

        if (!$validacion['ok']) {
            return $validacion;
        }

        $meta->setDescripcion(
            $validacion['descripcion']
        );

        $meta->setCantidadObjetivo(
            $validacion['cantidad_objetivo']
        );

        $meta->setFechaInicio(
            $validacion['fecha_inicio']
        );

        $meta->setFechaFin(
            $validacion['fecha_fin']
        );

        $this->metaRepository
            ->actualizar($meta);

        return [
            'ok' => true
        ];
    }

    public function cambiarEstado(
        int $idMeta
    ): array {
        $meta =
            $this->metaRepository
                ->buscarPorId($idMeta);

        if ($meta === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La meta no existe.'
            ];
        }

        $nuevoEstado =
            !$meta->getEstado();

        $this->metaRepository
            ->cambiarEstado(
                $idMeta,
                $nuevoEstado
            );

        return [
            'ok' => true,
            'estado' => $nuevoEstado
        ];
    }

    private function validarDatos(
        array $datos
    ): array {
        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $cantidadObjetivo =
            (int) ($datos['cantidad_objetivo'] ?? 0);

        $fechaInicio = trim(
            (string) ($datos['fecha_inicio'] ?? '')
        );

        $fechaFin = trim(
            (string) ($datos['fecha_fin'] ?? '')
        );

        if (
            $descripcion === ''
            || $fechaInicio === ''
            || $fechaFin === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Todos los campos obligatorios deben completarse.'
            ];
        }

        if ($cantidadObjetivo <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La cantidad objetivo debe ser mayor que cero.'
            ];
        }

        if (
            !$this->fechaValida($fechaInicio)
            || !$this->fechaValida($fechaFin)
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Las fechas ingresadas no son válidas.'
            ];
        }

        if ($fechaFin < $fechaInicio) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha final no puede ser anterior a la fecha inicial.'
            ];
        }

        return [
            'ok' => true,
            'descripcion' => $descripcion,
            'cantidad_objetivo' => $cantidadObjetivo,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ];
    }

    private function fechaValida(
        string $fecha
    ): bool {
        $objeto =
            DateTime::createFromFormat(
                'Y-m-d',
                $fecha
            );

        return $objeto !== false
            && $objeto->format('Y-m-d')
            === $fecha;
    }
}