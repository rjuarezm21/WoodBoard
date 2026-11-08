<?php

declare(strict_types=1);

use App\Business\Services\DashboardService;
use App\Data\Repositories\DashboardRepository;
use PHPUnit\Framework\TestCase;

final class DashboardServiceTest extends TestCase
{
    public function testDashboardGeneralPreparaInformacion(): void
    {
        $repository = $this->createMock(
            DashboardRepository::class
        );

        $repository
            ->method('obtenerResumen')
            ->willReturn([
                'ventas_mes' => 5000.00,
                'unidades_vendidas' => 10,
                'produccion_mes' => 25,
                'articulos_activos' => 5,
                'metas_activas' => 2,
                'metas_cumplidas' => 1
            ]);

        $repository
            ->method('obtenerVentasPorMes')
            ->willReturn([]);

        $repository
            ->method('obtenerProduccionPorMes')
            ->willReturn([]);

        $repository
            ->method('obtenerProgresoMetas')
            ->willReturn([]);

        $service =
            new DashboardService(
                $repository
            );

        $resultado =
            $service
                ->obtenerDashboardGeneral();

        $this->assertSame(
            5000.00,
            $resultado['resumen']['ventas_mes']
        );

        $this->assertSame(
            10,
            $resultado['resumen']['unidades_vendidas']
        );

        $this->assertCount(
            6,
            $resultado['ventas']['etiquetas']
        );

        $this->assertCount(
            6,
            $resultado['produccion']['etiquetas']
        );
    }


    public function testDashboardProduccionRechazaRangoInvalido(): void
    {
        $repository = $this->createMock(
            DashboardRepository::class
        );

        $service =
            new DashboardService(
                $repository
            );

        $resultado =
            $service
                ->obtenerDashboardProduccion([
                    'fecha_inicio' =>
                        '2026-10-31',

                    'fecha_fin' =>
                        '2026-10-01'
                ]);

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'La fecha final no puede ser anterior a la fecha inicial.',
            $resultado['mensaje']
        );
    }


    public function testDashboardProduccionCalculaVariacion(): void
    {
        $repository = $this->createMock(
            DashboardRepository::class
        );

        $repository
            ->expects($this->exactly(2))
            ->method(
                'obtenerResumenProduccionPeriodo'
            )
            ->willReturnOnConsecutiveCalls(
                [
                    'total_producido' => 150,
                    'total_registros' => 5,
                    'metas_trabajadas' => 2,
                    'dias_con_produccion' => 5
                ],
                [
                    'total_producido' => 100,
                    'total_registros' => 4,
                    'metas_trabajadas' => 2,
                    'dias_con_produccion' => 4
                ]
            );

        $repository
            ->method('obtenerProduccionPorDia')
            ->willReturn([]);

        $repository
            ->method('obtenerProgresoMetas')
            ->willReturn([]);

        $service =
            new DashboardService(
                $repository
            );

        $resultado =
            $service
                ->obtenerDashboardProduccion([
                    'fecha_inicio' =>
                        '2026-10-01',

                    'fecha_fin' =>
                        '2026-10-10'
                ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            150,
            $resultado[
                'resumen'
            ][
                'total_producido'
            ]
        );

        $this->assertSame(
            50.0,
            $resultado[
                'resumen'
            ][
                'variacion'
            ]
        );
    }


    public function testDashboardInventarioPreparaMovimientos(): void
    {
        $repository = $this->createMock(
            DashboardRepository::class
        );

        $repository
            ->method(
                'obtenerResumenInventarioPeriodo'
            )
            ->willReturn([
                'articulos_activos' => 3,
                'total_movimientos' => 2,
                'entradas' => 1,
                'salidas' => 1,
                'articulos_con_movimiento' => 2
            ]);

        $repository
            ->method(
                'obtenerMovimientosInventarioPorDia'
            )
            ->willReturn([
                [
                    'fecha' =>
                        '2026-10-05',

                    'entradas' =>
                        1,

                    'salidas' =>
                        0
                ],
                [
                    'fecha' =>
                        '2026-10-06',

                    'entradas' =>
                        0,

                    'salidas' =>
                        1
                ]
            ]);

        $repository
            ->method(
                'obtenerExistenciasInventario'
            )
            ->willReturn([]);

        $repository
            ->method(
                'obtenerUltimosMovimientosInventario'
            )
            ->willReturn([]);

        $service =
            new DashboardService(
                $repository
            );

        $resultado =
            $service
                ->obtenerDashboardInventario([
                    'fecha_inicio' =>
                        '2026-10-01',

                    'fecha_fin' =>
                        '2026-10-31'
                ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            [
                '05/10/2026',
                '06/10/2026'
            ],
            $resultado[
                'grafica'
            ][
                'etiquetas'
            ]
        );

        $this->assertSame(
            [1, 0],
            $resultado[
                'grafica'
            ][
                'entradas'
            ]
        );

        $this->assertSame(
            [0, 1],
            $resultado[
                'grafica'
            ][
                'salidas'
            ]
        );
    }


    public function testDashboardVentasCalculaPromedioYVariacion(): void
    {
        $repository = $this->createMock(
            DashboardRepository::class
        );

        $repository
            ->expects($this->exactly(2))
            ->method(
                'obtenerResumenVentasPeriodo'
            )
            ->willReturnOnConsecutiveCalls(
                [
                    'monto_total' =>
                        3000.00,

                    'unidades_vendidas' =>
                        5,

                    'total_ventas' =>
                        3
                ],
                [
                    'monto_total' =>
                        2000.00,

                    'unidades_vendidas' =>
                        4,

                    'total_ventas' =>
                        2
                ]
            );

        $repository
            ->method(
                'obtenerVentasPorDia'
            )
            ->willReturn([]);

        $repository
            ->method(
                'obtenerProductosMasVendidos'
            )
            ->willReturn([]);

        $service =
            new DashboardService(
                $repository
            );

        $resultado =
            $service
                ->obtenerDashboardVentas([
                    'fecha_inicio' =>
                        '2026-10-01',

                    'fecha_fin' =>
                        '2026-10-10'
                ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            1000.00,
            $resultado[
                'resumen'
            ][
                'promedio_venta'
            ]
        );

        $this->assertSame(
            50.0,
            $resultado[
                'resumen'
            ][
                'variacion'
            ]
        );
    }
}