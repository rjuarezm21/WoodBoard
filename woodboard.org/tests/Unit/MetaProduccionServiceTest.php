<?php

declare(strict_types=1);

use App\Business\Services\MetaProduccionService;
use App\Data\Models\MetaProduccion;
use App\Data\Repositories\MetaProduccionRepository;
use PHPUnit\Framework\TestCase;

final class MetaProduccionServiceTest extends TestCase
{
    public function testRegistraMetaConDatosValidos(): void
    {
        $repository = $this->createMock(
            MetaProduccionRepository::class
        );

        $repository
            ->expects($this->once())
            ->method('crear')
            ->with(
                $this->isInstanceOf(
                    MetaProduccion::class
                )
            )
            ->willReturn(15);

        $service = new MetaProduccionService(
            $repository
        );

        $resultado = $service->registrarMeta([
            'descripcion' =>
                'Fabricar mesas de comedor',

            'cantidad_objetivo' => 50,

            'fecha_inicio' =>
                '2026-10-01',

            'fecha_fin' =>
                '2026-10-31'
        ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            15,
            $resultado['id_meta']
        );
    }


    public function testRechazaCantidadObjetivoCero(): void
    {
        $repository = $this->createMock(
            MetaProduccionRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new MetaProduccionService(
            $repository
        );

        $resultado = $service->registrarMeta([
            'descripcion' =>
                'Fabricar escritorios',

            'cantidad_objetivo' => 0,

            'fecha_inicio' =>
                '2026-10-01',

            'fecha_fin' =>
                '2026-10-31'
        ]);

        $this->assertFalse(
            $resultado['ok']
        );

        $this->assertSame(
            'La cantidad objetivo debe ser mayor que cero.',
            $resultado['mensaje']
        );
    }


    public function testRechazaCantidadObjetivoNegativa(): void
    {
        $repository = $this->createMock(
            MetaProduccionRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new MetaProduccionService(
            $repository
        );

        $resultado = $service->registrarMeta([
            'descripcion' =>
                'Fabricar sillas',

            'cantidad_objetivo' => -20,

            'fecha_inicio' =>
                '2026-10-01',

            'fecha_fin' =>
                '2026-10-31'
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }


    public function testRechazaRangoDeFechasInvalido(): void
    {
        $repository = $this->createMock(
            MetaProduccionRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('crear');

        $service = new MetaProduccionService(
            $repository
        );

        $resultado = $service->registrarMeta([
            'descripcion' =>
                'Fabricar muebles',

            'cantidad_objetivo' => 30,

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


    public function testAceptaRangoDeFechasValido(): void
    {
        $repository = $this->createMock(
            MetaProduccionRepository::class
        );

        $repository
            ->method('crear')
            ->willReturn(20);

        $service = new MetaProduccionService(
            $repository
        );

        $resultado = $service->registrarMeta([
            'descripcion' =>
                'Fabricar gaveteros',

            'cantidad_objetivo' => 25,

            'fecha_inicio' =>
                '2026-10-01',

            'fecha_fin' =>
                '2026-10-15'
        ]);

        $this->assertTrue(
            $resultado['ok']
        );
    }
}