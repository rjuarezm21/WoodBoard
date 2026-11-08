<?php

declare(strict_types=1);

use App\Business\Services\AutorizacionService;
use App\Data\Repositories\PermisoRepository;
use PHPUnit\Framework\TestCase;

final class AutorizacionServiceTest extends TestCase
{
    public function testPermiteAccesoCuandoRolTienePermiso(): void
    {
        $repository = $this->createMock(
            PermisoRepository::class
        );

        $repository
            ->method('rolTienePermiso')
            ->with(
                1,
                'gestionar_usuarios'
            )
            ->willReturn(true);

        $service = new AutorizacionService(
            $repository
        );

        $resultado = $service->tienePermiso(
            1,
            'gestionar_usuarios'
        );

        $this->assertTrue($resultado);
    }


    public function testRechazaAccesoCuandoRolNoTienePermiso(): void
    {
        $repository = $this->createMock(
            PermisoRepository::class
        );

        $repository
            ->method('rolTienePermiso')
            ->with(
                4,
                'gestionar_usuarios'
            )
            ->willReturn(false);

        $service = new AutorizacionService(
            $repository
        );

        $resultado = $service->tienePermiso(
            4,
            'gestionar_usuarios'
        );

        $this->assertFalse($resultado);
    }


    public function testRechazaRolInvalido(): void
    {
        $repository = $this->createMock(
            PermisoRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('rolTienePermiso');

        $service = new AutorizacionService(
            $repository
        );

        $resultado = $service->tienePermiso(
            0,
            'gestionar_usuarios'
        );

        $this->assertFalse($resultado);
    }


    public function testRechazaPermisoVacio(): void
    {
        $repository = $this->createMock(
            PermisoRepository::class
        );

        $repository
            ->expects($this->never())
            ->method('rolTienePermiso');

        $service = new AutorizacionService(
            $repository
        );

        $resultado = $service->tienePermiso(
            1,
            ''
        );

        $this->assertFalse($resultado);
    }
}