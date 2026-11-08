<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\MovimientoInventario;
use App\Data\Repositories\InventarioRepository;
use App\Data\Repositories\MovimientoInventarioRepository;
use DateTime;
use Throwable;

class MovimientoInventarioService
{
    private MovimientoInventarioRepository $movimientoRepository;
    private InventarioRepository $inventarioRepository;

    public function __construct(
        MovimientoInventarioRepository $movimientoRepository,
        InventarioRepository $inventarioRepository
    ) {
        $this->movimientoRepository =
            $movimientoRepository;

        $this->inventarioRepository =
            $inventarioRepository;
    }

    public function listarMovimientos(): array
    {
        return $this->movimientoRepository
            ->listarTodos();
    }

    public function obtenerArticulosActivos(): array
    {
        return $this->inventarioRepository
            ->listarActivos();
    }

    public function registrarMovimiento(
        array $datos,
        int $idUsuario
    ): array {
        $tipo = strtoupper(
            trim(
                (string) ($datos['tipo_movimiento'] ?? '')
            )
        );

        $cantidad =
            (int) ($datos['cantidad'] ?? 0);

        $fecha = trim(
            (string) ($datos['fecha_movimiento'] ?? '')
        );

        $observacion = trim(
            (string) ($datos['observacion'] ?? '')
        );

        $idInventario =
            (int) ($datos['id_inventario'] ?? 0);

        /*
         * Campos obligatorios.
         */
        if (
            $tipo === ''
            || $cantidad <= 0
            || $fecha === ''
            || $idInventario <= 0
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Complete todos los campos obligatorios.'
            ];
        }

        /*
         * Tipo permitido.
         */
        if (
            $tipo !== 'ENTRADA'
            && $tipo !== 'SALIDA'
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El tipo de movimiento no es válido.'
            ];
        }

        /*
         * Fecha válida.
         */
        if (!$this->fechaValida($fecha)) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha ingresada no es válida.'
            ];
        }

        /*
         * Usuario autenticado válido.
         */
        if ($idUsuario <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'No fue posible identificar al usuario.'
            ];
        }

        /*
         * Buscar artículo.
         */
        $articulo =
            $this->inventarioRepository
                ->buscarPorId(
                    $idInventario
                );

        if ($articulo === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El artículo seleccionado no existe.'
            ];
        }

        /*
         * No permitir movimientos
         * sobre artículos inactivos.
         */
        if (!$articulo->getEstado()) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El artículo seleccionado se encuentra inactivo.'
            ];
        }

        $existenciaActual =
            $articulo->getCantidadDisponible();

        /*
         * ENTRADA
         */
        if ($tipo === 'ENTRADA') {

            $nuevaCantidad =
                $existenciaActual
                + $cantidad;

        } else {

            /*
             * SALIDA
             */

            if ($cantidad > $existenciaActual) {

                return [
                    'ok' => false,
                    'mensaje' =>
                        'No hay existencia suficiente para realizar la salida.'
                ];
            }

            $nuevaCantidad =
                $existenciaActual
                - $cantidad;
        }

        $movimiento =
            new MovimientoInventario(
                null,
                $tipo,
                $cantidad,
                $fecha,
                $observacion !== ''
                    ? $observacion
                    : null,
                $idInventario,
                $idUsuario
            );

        try {

            $idMovimiento =
                $this->movimientoRepository
                    ->crearConActualizacionExistencia(
                        $movimiento,
                        $nuevaCantidad
                    );

            return [
                'ok' => true,
                'id_movimiento' =>
                    $idMovimiento
            ];

        } catch (Throwable $e) {

            return [
                'ok' => false,
                'mensaje' =>
                    'No fue posible registrar el movimiento.'
            ];
        }
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