<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Venta;
use App\Data\Repositories\VentaRepository;
use DateTime;

class VentaService
{
    private VentaRepository $ventaRepository;

    public function __construct(
        VentaRepository $ventaRepository
    ) {
        $this->ventaRepository =
            $ventaRepository;
    }

    public function listarVentas(): array
    {
        return $this->ventaRepository
            ->listarTodas();
    }

    public function registrarVenta(
        array $datos,
        int $idUsuario
    ): array {
        $fechaVenta = trim(
            (string) ($datos['fecha_venta'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $cantidad =
            (int) ($datos['cantidad'] ?? 0);

        $montoTotal =
            (float) ($datos['monto_total'] ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Campos obligatorios
        |--------------------------------------------------------------------------
        */

        if (
            $fechaVenta === ''
            || $descripcion === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Todos los campos obligatorios deben completarse.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validar fecha
        |--------------------------------------------------------------------------
        */

        if (!$this->fechaValida($fechaVenta)) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La fecha de venta no es válida.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validar cantidad
        |--------------------------------------------------------------------------
        */

        if ($cantidad <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'La cantidad debe ser mayor que cero.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validar monto
        |--------------------------------------------------------------------------
        */

        if ($montoTotal <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El monto total debe ser mayor que cero.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validar usuario
        |--------------------------------------------------------------------------
        */

        if ($idUsuario <= 0) {
            return [
                'ok' => false,
                'mensaje' =>
                    'No fue posible identificar al usuario.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Crear modelo
        |--------------------------------------------------------------------------
        */

        $venta = new Venta(
            null,
            $fechaVenta,
            $descripcion,
            $cantidad,
            $montoTotal,
            $idUsuario
        );

        /*
        |--------------------------------------------------------------------------
        | Guardar
        |--------------------------------------------------------------------------
        */

        $idVenta =
            $this->ventaRepository
                ->crear($venta);

        return [
            'ok' => true,
            'id_venta' => $idVenta
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