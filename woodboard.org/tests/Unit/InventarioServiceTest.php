<?php

declare(strict_types=1);

use App\Business\Services\InventarioService;
use App\Data\Models\Inventario;
use App\Data\Repositories\InventarioRepository;
use PHPUnit\Framework\TestCase;

final class InventarioServiceTest extends TestCase
{
    public function testRegistraArticuloConExistenciaInicialCero(): void
    {
        $repository = $this->createMock(
            InventarioRepository::class
        );

        $repository
            ->expects($this->once())
            ->method('crear')
            ->with(
                $this->callback(
                    function (Inventario $articulo): bool {
                        return $articulo->getNombreItem() === 'Madera de pino'
                            && $articulo->getCantidadDisponible() === 0
                            && $articulo->getEstado() === true;
                    }
                )
            )
            ->willReturn(10);

        $service = new InventarioService(
            $repository
        );

        $resultado = $service->registrarArticulo([
            'nombre_item' => 'Madera de pino',
            'descripcion' => 'Madera para fabricación',
            'categoria' => 'Materia prima',
            'unidad_medida' => 'tablas'
        ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            10,
            $resultado['id_inventario']
        );
    }


    public function testRechazaArticuloSinNombre(): void
    {
        $repository = $this->createMock(
            InventarioRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new InventarioService(
            $repository
        );

        $resultado = $service->registrarArticulo([
            'nombre_item' => '',
            'descripcion' => 'Prueba',
            'categoria' => 'Materia prima',
            'unidad_medida' => 'unidades'
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testRechazaArticuloSinCategoria(): void
    {
        $repository = $this->createMock(
            InventarioRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new InventarioService(
            $repository
        );

        $resultado = $service->registrarArticulo([
            'nombre_item' => 'Bisagras',
            'descripcion' => '',
            'categoria' => '',
            'unidad_medida' => 'unidades'
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testCambiaEstadoDeArticulo(): void
    {
        $repository = $this->createMock(
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

        $repository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($articulo);

        $repository
            ->expects($this->once())
            ->method('cambiarEstado')
            ->with(
                1,
                false
            )
            ->willReturn(true);

        $service = new InventarioService(
            $repository
        );

        $resultado =
            $service->cambiarEstado(1);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertFalse(
            $resultado['estado']
        );
    }
}