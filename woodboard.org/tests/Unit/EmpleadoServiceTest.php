<?php

declare(strict_types=1);

use App\Business\Services\EmpleadoService;
use App\Data\Models\Area;
use App\Data\Models\Empleado;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\EmpleadoRepository;
use PHPUnit\Framework\TestCase;

final class EmpleadoServiceTest extends TestCase
{
    public function testRegistraEmpleadoConDatosValidos(): void
    {
        $empleadoRepository = $this->createMock(
            EmpleadoRepository::class
        );

        $areaRepository = $this->createMock(
            AreaRepository::class
        );

        $area = new Area(
            1,
            'Administración',
            'Área administrativa',
            true
        );

        $areaRepository
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($area);

        $empleadoRepository
            ->expects($this->once())
            ->method('crear')
            ->with(
                $this->isInstanceOf(
                    Empleado::class
                )
            )
            ->willReturn(10);

        $service = new EmpleadoService(
            $empleadoRepository,
            $areaRepository
        );

        $resultado = $service->registrarEmpleado([
            'nombre' => 'María',
            'apellido' => 'López',
            'puesto' => 'Asistente',
            'fecha_ingreso' => '2026-10-06',
            'id_area' => 1
        ]);

        $this->assertTrue(
            $resultado['ok']
        );

        $this->assertSame(
            10,
            $resultado['id_empleado']
        );
    }

    public function testRechazaCamposVacios(): void
    {
        $empleadoRepository = $this->createMock(
            EmpleadoRepository::class
        );

        $areaRepository = $this->createMock(
            AreaRepository::class
        );

        $empleadoRepository
            ->expects($this->never())
            ->method('crear');

        $service = new EmpleadoService(
            $empleadoRepository,
            $areaRepository
        );

        $resultado = $service->registrarEmpleado([
            'nombre' => '',
            'apellido' => 'López',
            'puesto' => 'Asistente',
            'fecha_ingreso' => '2026-10-06',
            'id_area' => 1
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }

    public function testRechazaFechaInvalida(): void
    {
        $empleadoRepository = $this->createMock(
            EmpleadoRepository::class
        );

        $areaRepository = $this->createMock(
            AreaRepository::class
        );

        $empleadoRepository
            ->expects($this->never())
            ->method('crear');

        $service = new EmpleadoService(
            $empleadoRepository,
            $areaRepository
        );

        $resultado = $service->registrarEmpleado([
            'nombre' => 'Carlos',
            'apellido' => 'Pérez',
            'puesto' => 'Auxiliar',
            'fecha_ingreso' => '2026-25-99',
            'id_area' => 1
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }

    public function testRechazaAreaInactiva(): void
    {
        $empleadoRepository = $this->createMock(
            EmpleadoRepository::class
        );

        $areaRepository = $this->createMock(
            AreaRepository::class
        );

        $area = new Area(
            2,
            'Área inactiva',
            null,
            false
        );

        $areaRepository
            ->method('buscarPorId')
            ->with(2)
            ->willReturn($area);

        $empleadoRepository
            ->expects($this->never())
            ->method('crear');

        $service = new EmpleadoService(
            $empleadoRepository,
            $areaRepository
        );

        $resultado = $service->registrarEmpleado([
            'nombre' => 'Carlos',
            'apellido' => 'Pérez',
            'puesto' => 'Auxiliar',
            'fecha_ingreso' => '2026-10-06',
            'id_area' => 2
        ]);

        $this->assertFalse(
            $resultado['ok']
        );
    }
}