<?php

declare(strict_types=1);

use App\Business\Services\VentaService;
use App\Data\Models\Venta;
use App\Data\Repositories\VentaRepository;
use PHPUnit\Framework\TestCase;

final class VentaServiceTest extends TestCase
{
    public function testRegistraVentaConDatosValidos(): void
    {
        $repository = $this->createMock(
            VentaRepository::class
        );

        $repository
            ->expects($this->once())
            ->method('crear')
            ->with(
                $this->callback(
                    function (Venta $venta): bool {
                        return $venta->getDescripcion()
                                === 'Mesa de comedor'
                            && $venta->getCantidad() === 2
                            && $venta->getMontoTotal() === 2500.00
                            && $venta->getIdUsuario() === 1;
                    }
                )
            )
            ->willReturn(15);

        $service = new VentaService(
            $repository
        );

        $resultado =
            $service->registrarVenta(
                [
                    'fecha_venta' => '2026-10-06',
                    'descripcion' => 'Mesa de comedor',
                    'cantidad' => 2,
                    'monto_total' => 2500.00
                ],
                1
            );

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            15,
            $resultado['id_venta']
        );
    }


    public function testRechazaCantidadCero(): void
    {
        $repository = $this->createMock(
            VentaRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new VentaService(
            $repository
        );

        $resultado =
            $service->registrarVenta(
                [
                    'fecha_venta' => '2026-10-06',
                    'descripcion' => 'Silla',
                    'cantidad' => 0,
                    'monto_total' => 500
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'La cantidad debe ser mayor que cero.',
            $resultado['mensaje']
        );
    }


    public function testRechazaMontoCero(): void
    {
        $repository = $this->createMock(
            VentaRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new VentaService(
            $repository
        );

        $resultado =
            $service->registrarVenta(
                [
                    'fecha_venta' => '2026-10-06',
                    'descripcion' => 'Escritorio',
                    'cantidad' => 1,
                    'monto_total' => 0
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'El monto total debe ser mayor que cero.',
            $resultado['mensaje']
        );
    }


    public function testRechazaFechaInvalida(): void
    {
        $repository = $this->createMock(
            VentaRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new VentaService(
            $repository
        );

        $resultado =
            $service->registrarVenta(
                [
                    'fecha_venta' => '2026-15-40',
                    'descripcion' => 'Mueble',
                    'cantidad' => 1,
                    'monto_total' => 1000
                ],
                1
            );

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testRechazaUsuarioInvalido(): void
    {
        $repository = $this->createMock(
            VentaRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new VentaService(
            $repository
        );

        $resultado =
            $service->registrarVenta(
                [
                    'fecha_venta' => '2026-10-06',
                    'descripcion' => 'Mueble',
                    'cantidad' => 1,
                    'monto_total' => 1000
                ],
                0
            );

        $this->assertFalse(
            $resultado['ok']
        );
    }
}