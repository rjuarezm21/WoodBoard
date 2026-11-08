<?php

declare(strict_types=1);

use App\Data\Models\Venta;
use App\Data\Repositories\VentaRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class VentaRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;
    private VentaRepository $repository;

    private int $idArea;
    private int $idUsuario;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        $this->pdo->beginTransaction();

        $this->repository =
            new VentaRepository(
                $this->pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Crear área temporal
        |--------------------------------------------------------------------------
        */

        $stmt = $this->pdo->prepare("
            INSERT INTO area (
                nombre_area,
                descripcion,
                estado
            )
            VALUES (
                :nombre,
                'Área temporal para ventas',
                1
            )
        ");

        $stmt->execute([
            'nombre' =>
                'Área ventas ' . uniqid()
        ]);

        $this->idArea =
            (int) $this->pdo
                ->lastInsertId();


        /*
        |--------------------------------------------------------------------------
        | Crear usuario temporal
        |--------------------------------------------------------------------------
        */

        $stmt = $this->pdo->prepare("
            INSERT INTO usuario (
                nombre,
                apellido,
                correo,
                contrasena,
                estado,
                id_rol,
                id_area
            )
            VALUES (
                'Usuario',
                'Ventas',
                :correo,
                :contrasena,
                1,
                1,
                :id_area
            )
        ");

        $stmt->execute([
            'correo' =>
                'ventas_' . uniqid()
                . '@woodboard.test',

            'contrasena' =>
                password_hash(
                    'Prueba123',
                    PASSWORD_DEFAULT
                ),

            'id_area' =>
                $this->idArea
        ]);

        $this->idUsuario =
            (int) $this->pdo
                ->lastInsertId();
    }


    public function testCrearYBuscarVenta(): void
    {
        $venta = new Venta(
            null,
            '2026-10-06',
            'Mesa de comedor integración',
            2,
            2500.00,
            $this->idUsuario
        );

        $idVenta =
            $this->repository
                ->crear($venta);

        $this->assertGreaterThan(
            0,
            $idVenta
        );

        $ventaGuardada =
            $this->repository
                ->buscarPorId(
                    $idVenta
                );

        $this->assertInstanceOf(
            Venta::class,
            $ventaGuardada
        );

        $this->assertSame(
            '2026-10-06',
            $ventaGuardada
                ->getFechaVenta()
        );

        $this->assertSame(
            'Mesa de comedor integración',
            $ventaGuardada
                ->getDescripcion()
        );

        $this->assertSame(
            2,
            $ventaGuardada
                ->getCantidad()
        );

        $this->assertSame(
            2500.00,
            $ventaGuardada
                ->getMontoTotal()
        );

        $this->assertSame(
            $this->idUsuario,
            $ventaGuardada
                ->getIdUsuario()
        );
    }


    public function testListarVentasIncluyeUsuario(): void
    {
        $venta = new Venta(
            null,
            '2026-10-06',
            'Venta listado',
            1,
            1200.00,
            $this->idUsuario
        );

        $this->repository
            ->crear($venta);

        $ventas =
            $this->repository
                ->listarTodas();

        $this->assertNotEmpty(
            $ventas
        );

        $encontrada = false;

        foreach ($ventas as $fila) {

            if (
                $fila['descripcion']
                === 'Venta listado'
            ) {
                $encontrada = true;

                $this->assertSame(
                    'Usuario',
                    $fila['usuario_nombre']
                );

                $this->assertSame(
                    'Ventas',
                    $fila['usuario_apellido']
                );

                break;
            }
        }

        $this->assertTrue(
            $encontrada
        );
    }


    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}