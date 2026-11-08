<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Produccion;
use App\Data\Repositories\MetaProduccionRepository;
use App\Data\Repositories\ProduccionRepository;
use DateTime;

class ProduccionService
{
    private ProduccionRepository $produccionRepository;
    private MetaProduccionRepository $metaRepository;

    public function __construct(
        ProduccionRepository $produccionRepository,
        MetaProduccionRepository $metaRepository
    ) {
        $this->produccionRepository =
            $produccionRepository;

        $this->metaRepository =
            $metaRepository;
    }

    public function listarProduccion(): array
    {
        return $this->produccionRepository
            ->listarTodos();
    }

    public function obtenerMetasActivas(): array
    {
        return $this->metaRepository
            ->listarActivas();
    }

    public function registrarProduccion(
        array $datos,
        int $idUsuario
    ): array {
        $fecha = trim(
            (string) ($datos['fecha'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $cantidadProducida =
            (int) ($datos['cantidad_producida'] ?? 0);

        $idMeta =
            (int) ($datos['id_meta'] ?? 0);

        if (
            $fecha === ''
            || $descripcion === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Todos los campos obligatorios deben completarse.'
            ];
        }

        if (!$this->fechaValida($fecha)) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha ingresada no es válida.'
            ];
        }

        if ($cantidadProducida <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La cantidad producida debe ser mayor que cero.'
            ];
        }

        if ($idUsuario <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'No fue posible identificar al usuario.'
            ];
        }

        $meta =
            $this->metaRepository
                ->buscarPorId($idMeta);

        if (
            $meta === null
            || !$meta->getEstado()
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La meta seleccionada no es válida o se encuentra inactiva.'
            ];
        }

        $produccion = new Produccion(
            null,
            $fecha,
            $descripcion,
            $cantidadProducida,
            $idMeta,
            $idUsuario
        );

        $idProduccion =
            $this->produccionRepository
                ->crear($produccion);

        return [
            'ok' => true,
            'id_produccion' => $idProduccion
        ];
    }

    private function fechaValida(
        string $fecha
    ): bool {
        $objetoFecha =
            DateTime::createFromFormat(
                'Y-m-d',
                $fecha
            );

        return $objetoFecha !== false
            && $objetoFecha->format('Y-m-d')
            === $fecha;
    }
}