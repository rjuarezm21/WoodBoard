<?php

declare(strict_types=1);

use App\Data\Models\Empleado;
use App\Data\Repositories\EmpleadoRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class EmpleadoRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;
    private EmpleadoRepository $repository;
    private int $idAreaPrueba;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        /*
         * Todo lo que hagamos en la prueba
         * se revertirá al terminar.
         */
        $this->pdo->beginTransaction();

        $this->repository =
            new EmpleadoRepository(
                $this->pdo
            );

        /*
         * Creamos un área temporal para
         * no depender de datos existentes.
         */
        $sql = "
            INSERT INTO area (
                nombre_area,
                descripcion,
                estado
            )
            VALUES (
                :nombre_area,
                :descripcion,
                :estado
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre_area' =>
                'Área Integración ' . uniqid(),

            'descripcion' =>
                'Área temporal para pruebas',

            'estado' => 1
        ]);

        $this->idAreaPrueba =
            (int) $this->pdo->lastInsertId();
    }


    public function testCrearYBuscarEmpleado(): void
    {
        $empleado = new Empleado(
            null,
            'María',
            'Integración',
            'Asistente',
            '2026-10-06',
            true,
            $this->idAreaPrueba
        );

        $idEmpleado =
            $this->repository
                ->crear($empleado);

        $this->assertGreaterThan(
            0,
            $idEmpleado
        );


        $empleadoGuardado =
            $this->repository
                ->buscarPorId($idEmpleado);


        $this->assertInstanceOf(
            Empleado::class,
            $empleadoGuardado
        );

        $this->assertSame(
            'María',
            $empleadoGuardado->getNombre()
        );

        $this->assertSame(
            'Integración',
            $empleadoGuardado->getApellido()
        );

        $this->assertSame(
            'Asistente',
            $empleadoGuardado->getPuesto()
        );

        $this->assertSame(
            '2026-10-06',
            $empleadoGuardado->getFechaIngreso()
        );

        $this->assertTrue(
            $empleadoGuardado->getEstado()
        );

        $this->assertSame(
            $this->idAreaPrueba,
            $empleadoGuardado->getIdArea()
        );
    }


    public function testActualizarEmpleado(): void
    {
        $empleado = new Empleado(
            null,
            'Carlos',
            'Prueba',
            'Auxiliar',
            '2026-10-01',
            true,
            $this->idAreaPrueba
        );

        $idEmpleado =
            $this->repository
                ->crear($empleado);


        $empleadoGuardado =
            $this->repository
                ->buscarPorId($idEmpleado);


        $this->assertNotNull(
            $empleadoGuardado
        );


        $empleadoGuardado->setNombre(
            'Carlos Alberto'
        );

        $empleadoGuardado->setPuesto(
            'Supervisor'
        );


        $resultado =
            $this->repository
                ->actualizar(
                    $empleadoGuardado
                );


        $this->assertTrue(
            $resultado
        );


        $empleadoActualizado =
            $this->repository
                ->buscarPorId($idEmpleado);


        $this->assertNotNull(
            $empleadoActualizado
        );

        $this->assertSame(
            'Carlos Alberto',
            $empleadoActualizado->getNombre()
        );

        $this->assertSame(
            'Supervisor',
            $empleadoActualizado->getPuesto()
        );
    }


    public function testCambiarEstadoEmpleado(): void
    {
        $empleado = new Empleado(
            null,
            'Ana',
            'Prueba',
            'Operadora',
            '2026-10-02',
            true,
            $this->idAreaPrueba
        );

        $idEmpleado =
            $this->repository
                ->crear($empleado);


        $resultado =
            $this->repository
                ->cambiarEstado(
                    $idEmpleado,
                    false
                );


        $this->assertTrue(
            $resultado
        );


        $empleadoActualizado =
            $this->repository
                ->buscarPorId($idEmpleado);


        $this->assertNotNull(
            $empleadoActualizado
        );

        $this->assertFalse(
            $empleadoActualizado
                ->getEstado()
        );
    }


    protected function tearDown(): void
    {
        /*
         * Eliminamos todos los cambios
         * realizados durante cada prueba.
         */
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}