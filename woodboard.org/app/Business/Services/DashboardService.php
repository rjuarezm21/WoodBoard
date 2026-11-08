<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Repositories\DashboardRepository;
use App\Business\Services\Strategies\IndicadorDiarioStrategy;
use App\Business\Services\Strategies\ProduccionDiariaStrategy;
use App\Business\Services\Strategies\VentasDiariasStrategy;
use DateTimeImmutable;

class DashboardService
{
    private DashboardRepository $dashboardRepository;

    public function __construct(
        DashboardRepository $dashboardRepository
    ) {
        $this->dashboardRepository =
            $dashboardRepository;
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL
    |--------------------------------------------------------------------------
    */

    public function obtenerDashboardGeneral(): array
    {
        $hoy =
            new DateTimeImmutable();

        $inicioMes =
            $hoy
                ->modify(
                    'first day of this month'
                )
                ->format('Y-m-d');

        $finMes =
            $hoy
                ->modify(
                    'last day of this month'
                )
                ->format('Y-m-d');

        $desde =
            $hoy
                ->modify(
                    'first day of this month'
                )
                ->modify(
                    '-5 months'
                )
                ->format('Y-m-d');

        $resumen =
            $this->dashboardRepository
                ->obtenerResumen(
                    $inicioMes,
                    $finMes
                );

        $ventasBD =
            $this->dashboardRepository
                ->obtenerVentasPorMes(
                    $desde
                );

        $produccionBD =
            $this->dashboardRepository
                ->obtenerProduccionPorMes(
                    $desde
                );

        $metasBD =
            $this->dashboardRepository
                ->obtenerProgresoMetas();

        return [
            'resumen' =>
                $resumen,

            'ventas' =>
                $this->prepararSerieMensual(
                    $ventasBD,
                    $hoy
                ),

            'produccion' =>
                $this->prepararSerieMensual(
                    $produccionBD,
                    $hoy
                ),

            'metas' =>
                $this->prepararMetas(
                    $metasBD
                ),

            'mes_actual' =>
                $this->nombreMes(
                    (int) $hoy->format('n')
                )
                . ' '
                . $hoy->format('Y')
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DE PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function obtenerDashboardProduccion(
        array $filtros = []
    ): array {
        $hoy =
            new DateTimeImmutable();

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

        $inicio =
            new DateTimeImmutable(
                $fechaInicio
            );

        $fin =
            new DateTimeImmutable(
                $fechaFin
            );

        $diasPeriodo =
            $inicio
                ->diff($fin)
                ->days + 1;

        $finAnterior =
            $inicio
                ->modify('-1 day');

        $inicioAnterior =
            $finAnterior
                ->modify(
                    '-'
                    . ($diasPeriodo - 1)
                    . ' days'
                );

        $resumenActual =
            $this->dashboardRepository
                ->obtenerResumenProduccionPeriodo(
                    $fechaInicio,
                    $fechaFin
                );

        $resumenAnterior =
            $this->dashboardRepository
                ->obtenerResumenProduccionPeriodo(
                    $inicioAnterior
                        ->format('Y-m-d'),

                    $finAnterior
                        ->format('Y-m-d')
                );

        $promedioDiario = 0;

        if ($diasPeriodo > 0) {
            $promedioDiario =
                $resumenActual[
                    'total_producido'
                ]
                / $diasPeriodo;
        }

        $produccionAnterior =
            $resumenAnterior[
                'total_producido'
            ];

        $variacion = 0;

        if ($produccionAnterior > 0) {
            $variacion =
                (
                    (
                        $resumenActual[
                            'total_producido'
                        ]
                        - $produccionAnterior
                    )
                    / $produccionAnterior
                )
                * 100;

        } elseif (
            $resumenActual[
                'total_producido'
            ] > 0
        ) {
            $variacion = 100;
        }

        $produccionDiaria =
            $this->dashboardRepository
                ->obtenerProduccionPorDia(
                    $fechaInicio,
                    $fechaFin
                );

        $metas =
            $this->dashboardRepository
                ->obtenerProgresoMetas();

        $metasPeriodo =
            $this->dashboardRepository
                ->obtenerMetasPeriodo(
                    $fechaInicio,
                    $fechaFin
                );

        $resumenMetas =
            $this->prepararResumenMetas(
                $metasPeriodo,
                $fechaFin
            );

        return [
            'ok' =>
                true,

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'periodo_anterior' => [
                'fecha_inicio' =>
                    $inicioAnterior
                        ->format('Y-m-d'),

                'fecha_fin' =>
                    $finAnterior
                        ->format('Y-m-d')
            ],

            'resumen' => [
                'total_producido' =>
                    $resumenActual[
                        'total_producido'
                    ],

                'total_registros' =>
                    $resumenActual[
                        'total_registros'
                    ],

                'metas_trabajadas' =>
                    $resumenActual[
                        'metas_trabajadas'
                    ],

                'promedio_diario' =>
                    round(
                        $promedioDiario,
                        2
                    ),

                'produccion_anterior' =>
                    $produccionAnterior,

                'variacion' =>
                    round(
                        $variacion,
                        1
                    )
            ],

            'grafica' =>
                $this->prepararIndicadorDiario($produccionDiaria, new ProduccionDiariaStrategy()),

            'metas' =>
                $this->prepararMetas(
                    $metas
                ),

            'resumen_metas' =>
                $resumenMetas
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DE INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function obtenerDashboardInventario(
        array $filtros = []
    ): array {
        $hoy =
            new DateTimeImmutable();

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
        | Período predeterminado
        |--------------------------------------------------------------------------
        */

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
        | Validación
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
        | Calcular período anterior equivalente
        |--------------------------------------------------------------------------
        */

        $inicio =
            new DateTimeImmutable(
                $fechaInicio
            );

        $fin =
            new DateTimeImmutable(
                $fechaFin
            );

        $diasPeriodo =
            $inicio
                ->diff($fin)
                ->days + 1;

        $finAnterior =
            $inicio
                ->modify('-1 day');

        $inicioAnterior =
            $finAnterior
                ->modify(
                    '-'
                    . ($diasPeriodo - 1)
                    . ' days'
                );


        /*
        |--------------------------------------------------------------------------
        | Período actual
        |--------------------------------------------------------------------------
        */

        $resumenActual =
            $this->dashboardRepository
                ->obtenerResumenInventarioPeriodo(
                    $fechaInicio,
                    $fechaFin
                );


        /*
        |--------------------------------------------------------------------------
        | Período anterior
        |--------------------------------------------------------------------------
        */

        $resumenAnterior =
            $this->dashboardRepository
                ->obtenerResumenInventarioPeriodo(
                    $inicioAnterior
                        ->format('Y-m-d'),

                    $finAnterior
                        ->format('Y-m-d')
                );


        /*
        |--------------------------------------------------------------------------
        | Comparación de movimientos
        |--------------------------------------------------------------------------
        */

        $movimientosActuales =
            $resumenActual[
                'total_movimientos'
            ];

        $movimientosAnteriores =
            $resumenAnterior[
                'total_movimientos'
            ];

        $variacion = 0;

        if ($movimientosAnteriores > 0) {
            $variacion =
                (
                    (
                        $movimientosActuales
                        - $movimientosAnteriores
                    )
                    / $movimientosAnteriores
                )
                * 100;

        } elseif (
            $movimientosActuales > 0
        ) {
            $variacion = 100;
        }


        /*
        |--------------------------------------------------------------------------
        | Movimientos diarios
        |--------------------------------------------------------------------------
        */

        $movimientosDiarios =
            $this->dashboardRepository
                ->obtenerMovimientosInventarioPorDia(
                    $fechaInicio,
                    $fechaFin
                );


        /*
        |--------------------------------------------------------------------------
        | Existencias
        |--------------------------------------------------------------------------
        */

        $existencias =
            $this->dashboardRepository
                ->obtenerExistenciasInventario();


        /*
        |--------------------------------------------------------------------------
        | Últimos movimientos
        |--------------------------------------------------------------------------
        */

        $ultimosMovimientos =
            $this->dashboardRepository
                ->obtenerUltimosMovimientosInventario(
                    $fechaInicio,
                    $fechaFin
                );


        /*
        |--------------------------------------------------------------------------
        | Preparar gráfica
        |--------------------------------------------------------------------------
        */

        $etiquetas = [];
        $entradas = [];
        $salidas = [];

        foreach (
            $movimientosDiarios
            as $fila
        ) {
            $fecha =
                new DateTimeImmutable(
                    $fila['fecha']
                );

            $etiquetas[] =
                $fecha->format(
                    'd/m/Y'
                );

            $entradas[] =
                (int) $fila[
                    'entradas'
                ];

            $salidas[] =
                (int) $fila[
                    'salidas'
                ];
        }


        return [
            'ok' =>
                true,

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'periodo_anterior' => [
                'fecha_inicio' =>
                    $inicioAnterior
                        ->format('Y-m-d'),

                'fecha_fin' =>
                    $finAnterior
                        ->format('Y-m-d')
            ],

            'resumen' => [
                'articulos_activos' =>
                    $resumenActual[
                        'articulos_activos'
                    ],

                'total_movimientos' =>
                    $resumenActual[
                        'total_movimientos'
                    ],

                'entradas' =>
                    $resumenActual[
                        'entradas'
                    ],

                'salidas' =>
                    $resumenActual[
                        'salidas'
                    ],

                'articulos_con_movimiento' =>
                    $resumenActual[
                        'articulos_con_movimiento'
                    ],

                'movimientos_anterior' =>
                    $movimientosAnteriores,

                'variacion' =>
                    round(
                        $variacion,
                        1
                    )
            ],

            'grafica' => [
                'etiquetas' =>
                    $etiquetas,

                'entradas' =>
                    $entradas,

                'salidas' =>
                    $salidas
            ],

            'existencias' =>
                $existencias,

            'ultimos_movimientos' =>
                $ultimosMovimientos
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DE VENTAS
    |--------------------------------------------------------------------------
    */

    public function obtenerDashboardVentas(
        array $filtros = []
    ): array {
        $hoy =
            new DateTimeImmutable();

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

        $inicio =
            new DateTimeImmutable(
                $fechaInicio
            );

        $fin =
            new DateTimeImmutable(
                $fechaFin
            );

        $diasPeriodo =
            $inicio
                ->diff($fin)
                ->days + 1;

        $finAnterior =
            $inicio
                ->modify('-1 day');

        $inicioAnterior =
            $finAnterior
                ->modify(
                    '-'
                    . ($diasPeriodo - 1)
                    . ' days'
                );

        $resumenActual =
            $this->dashboardRepository
                ->obtenerResumenVentasPeriodo(
                    $fechaInicio,
                    $fechaFin
                );

        $resumenAnterior =
            $this->dashboardRepository
                ->obtenerResumenVentasPeriodo(
                    $inicioAnterior
                        ->format('Y-m-d'),

                    $finAnterior
                        ->format('Y-m-d')
                );

        $promedioVenta = 0;

        if (
            $resumenActual[
                'total_ventas'
            ] > 0
        ) {
            $promedioVenta =
                $resumenActual[
                    'monto_total'
                ]
                /
                $resumenActual[
                    'total_ventas'
                ];
        }

        $montoAnterior =
            $resumenAnterior[
                'monto_total'
            ];

        $variacion = 0;

        if ($montoAnterior > 0) {
            $variacion =
                (
                    (
                        $resumenActual[
                            'monto_total'
                        ]
                        - $montoAnterior
                    )
                    / $montoAnterior
                )
                * 100;

        } elseif (
            $resumenActual[
                'monto_total'
            ] > 0
        ) {
            $variacion = 100;
        }

        $ventasDiarias =
            $this->dashboardRepository
                ->obtenerVentasPorDia(
                    $fechaInicio,
                    $fechaFin
                );

        $productos =
            $this->dashboardRepository
                ->obtenerProductosMasVendidos(
                    $fechaInicio,
                    $fechaFin
                );

        return [
            'ok' =>
                true,

            'fecha_inicio' =>
                $fechaInicio,

            'fecha_fin' =>
                $fechaFin,

            'periodo_anterior' => [
                'fecha_inicio' =>
                    $inicioAnterior
                        ->format('Y-m-d'),

                'fecha_fin' =>
                    $finAnterior
                        ->format('Y-m-d')
            ],

            'resumen' => [
                'monto_total' =>
                    $resumenActual[
                        'monto_total'
                    ],

                'unidades_vendidas' =>
                    $resumenActual[
                        'unidades_vendidas'
                    ],

                'total_ventas' =>
                    $resumenActual[
                        'total_ventas'
                    ],

                'promedio_venta' =>
                    round(
                        $promedioVenta,
                        2
                    ),

                'monto_anterior' =>
                    $montoAnterior,

                'variacion' =>
                    round(
                        $variacion,
                        1
                    )
            ],

            'grafica' =>
                $this->prepararIndicadorDiario($ventasDiarias, new VentasDiariasStrategy()),

            'productos' =>
                $productos
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARAR PRODUCCIÓN DIARIA
    |--------------------------------------------------------------------------
    */

    /**
     * Strategy (GoF): delega el formato de las series diarias a
     * una estrategia intercambiable sin modificar los dashboards.
     */
    private function prepararIndicadorDiario(
        array $datos,
        IndicadorDiarioStrategy $estrategia
    ): array {
        return $estrategia->preparar($datos);
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARAR SERIE MENSUAL
    |--------------------------------------------------------------------------
    */

    private function prepararSerieMensual(
        array $datosBD,
        DateTimeImmutable $hoy
    ): array {
        $valoresBD = [];

        foreach ($datosBD as $fila) {
            $valoresBD[
                $fila['periodo']
            ] =
                (float) $fila['total'];
        }

        $etiquetas = [];
        $valores = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha =
                $hoy
                    ->modify(
                        'first day of this month'
                    )
                    ->modify(
                        '-'
                        . $i
                        . ' months'
                    );

            $periodo =
                $fecha->format(
                    'Y-m'
                );

            $etiquetas[] =
                $this->nombreMes(
                    (int)
                    $fecha->format('n')
                );

            $valores[] =
                $valoresBD[
                    $periodo
                ]
                ?? 0;
        }

        return [
            'etiquetas' =>
                $etiquetas,

            'valores' =>
                $valores
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARAR METAS
    |--------------------------------------------------------------------------
    */

    private function prepararMetas(
        array $metasBD
    ): array {
        $resultado = [];

        foreach ($metasBD as $meta) {
            $objetivo =
                (int) $meta[
                    'cantidad_objetivo'
                ];

            $producido =
                (int) $meta[
                    'cantidad_producida'
                ];

            $porcentaje = 0;

            if ($objetivo > 0) {
                $porcentaje =
                    (
                        $producido
                        / $objetivo
                    )
                    * 100;
            }

            $resultado[] = [
                'id_meta' =>
                    (int) $meta['id_meta'],

                'descripcion' =>
                    $meta['descripcion'],

                'objetivo' =>
                    $objetivo,

                'producido' =>
                    $producido,

                'porcentaje' =>
                    round(
                        $porcentaje,
                        1
                    ),

                'porcentaje_barra' =>
                    round(
                        min(
                            100,
                            $porcentaje
                        ),
                        1
                    ),

                'fecha_fin' =>
                    $meta['fecha_fin']
            ];
        }

        return $resultado;
    }


    /*
    |--------------------------------------------------------------------------
    | RESUMEN DE CUMPLIMIENTO DE METAS
    |--------------------------------------------------------------------------
    */

    private function prepararResumenMetas(
        array $metasBD,
        string $fechaFin
    ): array {
        $total = count($metasBD);
        $cumplidas = 0;
        $enProgreso = 0;
        $vencidas = 0;

        // Para fechas futuras se utiliza la fecha actual como corte.
        $hoy = (new DateTimeImmutable())->format('Y-m-d');
        $fechaCorte = min($fechaFin, $hoy);

        foreach ($metasBD as $meta) {
            $objetivo = (int) $meta['cantidad_objetivo'];
            $producido = (int) $meta['cantidad_producida'];
            $limite = substr((string) $meta['fecha_fin'], 0, 10);

            if ($objetivo > 0 && $producido >= $objetivo) {
                $cumplidas++;
            } elseif ($limite < $fechaCorte) {
                $vencidas++;
            } else {
                $enProgreso++;
            }
        }

        return [
            'total' => $total,
            'cumplidas' => $cumplidas,
            'en_progreso' => $enProgreso,
            'vencidas' => $vencidas,
            'porcentaje_cumplimiento' =>
                $total > 0
                    ? round(($cumplidas / $total) * 100, 1)
                    : 0.0
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


    /*
    |--------------------------------------------------------------------------
    | NOMBRE DEL MES
    |--------------------------------------------------------------------------
    */

    private function nombreMes(
        int $numeroMes
    ): string {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return $meses[
            $numeroMes
        ] ?? '';
    }
}