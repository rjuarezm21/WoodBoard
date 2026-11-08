<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Repositories\ReporteRepository;
use DateTimeImmutable;

class ReporteService
{
    private ReporteRepository $reporteRepository;

    public function __construct(
        ReporteRepository $reporteRepository
    ) {
        $this->reporteRepository =
            $reporteRepository;
    }


    public function generarReporte(
        array $filtros
    ): array {
        $tipo = strtolower(
            trim(
                (string) (
                    $filtros['tipo']
                    ?? ''
                )
            )
        );

        $fechaInicio =
            trim(
                (string) (
                    $filtros['fecha_inicio']
                    ?? ''
                )
            );

        $fechaFin =
            trim(
                (string) (
                    $filtros['fecha_fin']
                    ?? ''
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Validar tipo
        |--------------------------------------------------------------------------
        */

        $tiposPermitidos = [
            'ventas',
            'produccion',
            'inventario'
        ];

        if (
            !in_array(
                $tipo,
                $tiposPermitidos,
                true
            )
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El tipo de reporte no es válido.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Fechas predeterminadas
        |--------------------------------------------------------------------------
        */

        $hoy =
            new DateTimeImmutable();

        if (
            $fechaInicio === ''
            && $fechaFin === ''
        ) {
            $fechaInicio =
                $hoy
                    ->modify(
                        'first day of this month'
                    )
                    ->format('Y-m-d');

            $fechaFin =
                $hoy
                    ->modify(
                        'last day of this month'
                    )
                    ->format('Y-m-d');
        }


        /*
        |--------------------------------------------------------------------------
        | Validar fechas
        |--------------------------------------------------------------------------
        */

        if (
            !$this->fechaValida(
                $fechaInicio
            )
            || !$this->fechaValida(
                $fechaFin
            )
        ) {
            return [
                'ok' => false,

                'mensaje' =>
                    'Las fechas seleccionadas no son válidas.'
            ];
        }


        if ($fechaFin < $fechaInicio) {
            return [
                'ok' => false,

                'mensaje' =>
                    'La fecha final no puede ser anterior a la fecha inicial.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Generar según tipo
        |--------------------------------------------------------------------------
        */

        if ($tipo === 'ventas') {
            return $this->generarReporteVentas(
                $fechaInicio,
                $fechaFin
            );
        }


        if ($tipo === 'produccion') {
            return $this->generarReporteProduccion(
                $fechaInicio,
                $fechaFin
            );
        }


        return $this->generarReporteInventario(
            $fechaInicio,
            $fechaFin
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VENTAS
    |--------------------------------------------------------------------------
    */

    private function generarReporteVentas(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $registros =
            $this->reporteRepository
                ->obtenerVentas(
                    $fechaInicio,
                    $fechaFin
                );

        $unidades = 0;
        $monto = 0.0;

        foreach ($registros as $registro) {
            $unidades +=
                (int) $registro['cantidad'];

            $monto +=
                (float) $registro['monto_total'];
        }

        return [
            'ok' => true,

            'tipo' =>
                'ventas',

            'titulo' =>
                'Reporte de Ventas',

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'resumen' => [
                'total_registros' =>
                    count($registros),

                'unidades' =>
                    $unidades,

                'monto' =>
                    round(
                        $monto,
                        2
                    )
            ],

            'registros' =>
                $registros
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    private function generarReporteProduccion(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $registros =
            $this->reporteRepository
                ->obtenerProduccion(
                    $fechaInicio,
                    $fechaFin
                );

        $totalProducido = 0;

        $metas = [];

        foreach ($registros as $registro) {
            $totalProducido +=
                (int)
                $registro[
                    'cantidad_producida'
                ];

            $metas[
                (int)
                $registro['id_meta']
            ] = true;
        }

        return [
            'ok' => true,

            'tipo' =>
                'produccion',

            'titulo' =>
                'Reporte de Producción',

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'resumen' => [
                'total_registros' =>
                    count($registros),

                'total_producido' =>
                    $totalProducido,

                'metas_trabajadas' =>
                    count($metas)
            ],

            'registros' =>
                $registros
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    private function generarReporteInventario(
        string $fechaInicio,
        string $fechaFin
    ): array {
        $registros =
            $this->reporteRepository
                ->obtenerMovimientosInventario(
                    $fechaInicio,
                    $fechaFin
                );

        $entradas = 0;
        $salidas = 0;

        $articulos = [];

        foreach ($registros as $registro) {

            if (
                $registro[
                    'tipo_movimiento'
                ] === 'ENTRADA'
            ) {
                $entradas++;
            }

            if (
                $registro[
                    'tipo_movimiento'
                ] === 'SALIDA'
            ) {
                $salidas++;
            }

            $articulos[
                (int)
                $registro[
                    'id_inventario'
                ]
            ] = true;
        }

        return [
            'ok' => true,

            'tipo' =>
                'inventario',

            'titulo' =>
                'Reporte de Movimientos de Inventario',

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'resumen' => [
                'total_movimientos' =>
                    count($registros),

                'entradas' =>
                    $entradas,

                'salidas' =>
                    $salidas,

                'articulos' =>
                    count($articulos)
            ],

            'registros' =>
                $registros
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDAR FECHA
    |--------------------------------------------------------------------------
    */

    private function fechaValida(
        string $fecha
    ): bool {
        $objeto =
            DateTimeImmutable
                ::createFromFormat(
                    'Y-m-d',
                    $fecha
                );

        return $objeto !== false
            && $objeto->format(
                'Y-m-d'
            ) === $fecha;
    }
}