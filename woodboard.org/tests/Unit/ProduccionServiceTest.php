<?php

declare(strict_types=1);

use App\Business\Services\ProduccionService;
use App\Data\Models\MetaProduccion;
use App\Data\Models\Produccion;
use App\Data\Repositories\MetaProduccionRepository;
use App\Data\Repositories\ProduccionRepository;
use PHPUnit\Framework\TestCase;

final class ProduccionServiceTest extends TestCase
{
    public function testRegistraProduccionConDatosValidos(): void
    {
        $produccionRepository = $this->createMock(
            ProduccionRepository::class
        );

        $metaRepository = $this->createMock(
            MetaProduccionRepository::class
        );

        $meta = new MetaProduccion(
            1,
            'Fabricar mesas',
            50,
            '2026-10-01',
            '2026-10-31',
            true
        );

        $metaRepository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($meta);

        $produccionRepository
            ->expects($this->once())
            ->method('crear')
            ->with(
                $this->isInstanceOf(
                    Produccion::class
                )
            )
            ->willReturn(20);

        $service = new ProduccionService(
            $produccionRepository,
            $metaRepository
        );

        $resultado = $service->registrarProduccion(
            [
                'fecha' => '2026-10-06',
                'descripcion' => 'Producción de mesas',
                'cantidad_producida' => 8,
                'id_meta' => 1
            ],
            1
        );

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            20,
            $resultado['id_produccion']
        );
    }


    public function testRechazaCantidadCero(): void
    {
        $produccionRepository = $this->createMock(
            ProduccionRepository::class
        );

        $metaRepository = $this->createMock(
            MetaProduccionRepository::class
        );

        $produccionRepository
            ->expects($this->never())
            ->method('crear');

        $service = new ProduccionService(
            $produccionRepository,
            $metaRepository
        );

        $resultado = $service->registrarProduccion(
            [
                'fecha' => '2026-10-06',
                'descripcion' => 'Producción',
                'cantidad_producida' => 0,
                'id_meta' => 1
            ],
            1
        );

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'La cantidad producida debe ser mayor que cero.',
            $resultado['mensaje']
        );
    }


    public function testRechazaMetaInactiva(): void
    {
        $produccionRepository = $this->createMock(
            ProduccionRepository::class
        );

        $metaRepository = $this->createMock(
            MetaProduccionRepository::class
        );

        $meta = new MetaProduccion(
            2,
            'Meta inactiva',
            30,
            '2026-10-01',
            '2026-10-31',
            false
        );

        $metaRepository
            ->method('buscarPorId')
            ->with(2)
            ->willReturn($meta);

        $produccionRepository
            ->expects($this->never())
            ->method('crear');

        $service = new ProduccionService(
            $produccionRepository,
            $metaRepository
        );

        $resultado = $service->registrarProduccion(
            [
                'fecha' => '2026-10-06',
                'descripcion' => 'Producción',
                'cantidad_producida' => 10,
                'id_meta' => 2
            ],
            1
        );

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testRechazaUsuarioInvalido(): void
    {
        $produccionRepository = $this->createMock(
            ProduccionRepository::class
        );

        $metaRepository = $this->createMock(
            MetaProduccionRepository::class
        );

        $produccionRepository
            ->expects($this->never())
            ->method('crear');

        $service = new ProduccionService(
            $produccionRepository,
            $metaRepository
        );

        $resultado = $service->registrarProduccion(
            [
                'fecha' => '2026-10-06',
                'descripcion' => 'Producción',
                'cantidad_producida' => 5,
                'id_meta' => 1
            ],
            0
        );

        $this->assertFalse(
            $resultado['ok']
        );
    }
}