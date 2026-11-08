<?php

declare(strict_types=1);

use App\Business\Services\MovimientoInventarioService;
use App\Data\Models\Inventario;
use App\Data\Models\MovimientoInventario;
use App\Data\Repositories\InventarioRepository;
use App\Data\Repositories\MovimientoInventarioRepository;
use PHPUnit\Framework\TestCase;

final class MovimientoInventarioServiceTest extends TestCase
{
    public function testEntradaSumaExistencia(): void
    {
        $movimientoRepository = $this->createMock(
            MovimientoInventarioRepository::class
        );

        $inventarioRepository = $this->createMock(
            InventarioRepository::class
        );

        $articulo = new Inventario(
            1,
            'Bisagras',
            null,
            'Herrajes',
            20,
            'unidades',
            true
        );

        $inventarioRepository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($articulo);

        $movimientoRepository
            ->expects($this->once())
            ->method('crearConActualizacionExistencia')
            ->with(
                $this->isInstanceOf(
                    MovimientoInventario::class
                ),
                30
            )
            ->willReturn(5);

        $service =
            new MovimientoInventarioService(
                $movimientoRepository,
                $inventarioRepository
            );

        $resultado =
            $service->registrarMovimiento(
                [
                    'tipo_movimiento' => 'ENTRADA',
                    'cantidad' => 10,
                    'fecha_movimiento' => '2026-10-06',
                    'observacion' => 'Compra de bisagras',
                    'id_inventario' => 1
                ],
                1
            );

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            5,
            $resultado['id_movimiento']
        );
    }


    public function testSalidaRestaExistencia(): void
    {
        $movimientoRepository = $this->createMock(
            MovimientoInventarioRepository::class
        );

        $inventarioRepository = $this->createMock(
            InventarioRepository::class
        );

        $articulo = new Inventario(
            1,
            'Madera',
            null,
            'Materia prima',
            50,
            'tablas',
            true
        );

        $inventarioRepository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($articulo);

        $movimientoRepository
            ->expects($this->once())
            ->method('crearConActualizacionExistencia')
            ->with(
                $this->isInstanceOf(
                    MovimientoInventario::class
                ),
                35
            )
            ->willReturn(6);

        $service =
            new MovimientoInventarioService(
                $movimientoRepository,
                $inventarioRepository
            );

        $resultado =
            $service->registrarMovimiento(
                [
                    'tipo_movimiento' => 'SALIDA',
                    'cantidad' => 15,
                    'fecha_movimiento' => '2026-10-06',
                    'observacion' => 'Uso en producción',
                    'id_inventario' => 1
                ],
                1
            );

        $this->assertTrue(
            $resultado['ok']
        );
    }


    public function testRechazaSalidaMayorALaExistencia(): void
    {
        $movimientoRepository = $this->createMock(
            MovimientoInventarioRepository::class
        );

        $inventarioRepository = $this->createMock(
            InventarioRepository::class
        );

        $articulo = new Inventario(
            1,
            'Barniz',
            null,
            'Acabados',
            5,
            'galones',
            true
        );

        $inventarioRepository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($articulo);

        $movimientoRepository
            ->expects($this->never())
            ->method(
                'crearConActualizacionExistencia'
            );

        $service =
            new MovimientoInventarioService(
                $movimientoRepository,
                $inventarioRepository
            );

        $resultado =
            $service->registrarMovimiento(
                [
                    'tipo_movimiento' => 'SALIDA',
                    'cantidad' => 10,
                    'fecha_movimiento' => '2026-10-06',
                    'observacion' => '',
                    'id_inventario' => 1
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'No hay existencia suficiente para realizar la salida.',
            $resultado['mensaje']
        );
    }


    public function testRechazaArticuloInactivo(): void
    {
        $movimientoRepository = $this->createMock(
            MovimientoInventarioRepository::class
        );

        $inventarioRepository = $this->createMock(
            InventarioRepository::class
        );

        $articulo = new Inventario(
            2,
            'Artículo inactivo',
            null,
            'Prueba',
            20,
            'unidades',
            false
        );

        $inventarioRepository
            ->method('buscarPorId')
            ->with(2)
            ->willReturn($articulo);

        $movimientoRepository
            ->expects($this->never())
            ->method(
                'crearConActualizacionExistencia'
            );

        $service =
            new MovimientoInventarioService(
                $movimientoRepository,
                $inventarioRepository
            );

        $resultado =
            $service->registrarMovimiento(
                [
                    'tipo_movimiento' => 'ENTRADA',
                    'cantidad' => 10,
                    'fecha_movimiento' => '2026-10-06',
                    'observacion' => '',
                    'id_inventario' => 2
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testRechazaCantidadCero(): void
    {
        $movimientoRepository = $this->createMock(
            MovimientoInventarioRepository::class
        );

        $inventarioRepository = $this->createMock(
            InventarioRepository::class
        );

        $movimientoRepository
            ->expects($this->never())
            ->method(
                'crearConActualizacionExistencia'
            );

        $service =
            new MovimientoInventarioService(
                $movimientoRepository,
                $inventarioRepository
            );

        $resultado =
            $service->registrarMovimiento(
                [
                    'tipo_movimiento' => 'ENTRADA',
                    'cantidad' => 0,
                    'fecha_movimiento' => '2026-10-06',
                    'observacion' => '',
                    'id_inventario' => 1
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );
    }
}