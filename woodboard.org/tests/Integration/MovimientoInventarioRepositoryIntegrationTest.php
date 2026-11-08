<?php

declare(strict_types=1);

use App\Data\Models\MovimientoInventario;
use App\Data\Repositories\MovimientoInventarioRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class MovimientoInventarioRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;

    private MovimientoInventarioRepository $repository;

    private int $idArea;
    private int $idUsuario;
    private int $idInventario;
    private ?int $idMovimiento = null;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        $this->repository =
            new MovimientoInventarioRepository(
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
                'Área para prueba',
                1
            )
        ");

        $stmt->execute([
            'nombre' =>
                'Área movimientos ' . uniqid()
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
                'Prueba',
                :correo,
                :contrasena,
                1,
                1,
                :id_area
            )
        ");

        $stmt->execute([
            'correo' =>
                'movimiento_' . uniqid()
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


        /*
        |--------------------------------------------------------------------------
        | Crear artículo temporal con 20 unidades
        |--------------------------------------------------------------------------
        */

        $stmt = $this->pdo->prepare("
            INSERT INTO inventario (
                nombre_item,
                descripcion,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado
            )
            VALUES (
                :nombre,
                'Artículo para integración',
                'Prueba',
                20,
                'unidades',
                1
            )
        ");

        $stmt->execute([
            'nombre' =>
                'Artículo ' . uniqid()
        ]);

        $this->idInventario =
            (int) $this->pdo
                ->lastInsertId();
    }


    public function testRegistraMovimientoYActualizaExistencia(): void
    {
        /*
         * Existencia inicial = 20
         * Entrada = 10
         * Nueva existencia = 30
         */

        $movimiento =
            new MovimientoInventario(
                null,
                'ENTRADA',
                10,
                '2026-10-06',
                'Entrada de prueba',
                $this->idInventario,
                $this->idUsuario
            );

        $this->idMovimiento =
            $this->repository
                ->crearConActualizacionExistencia(
                    $movimiento,
                    30
                );

        $this->assertGreaterThan(
            0,
            $this->idMovimiento
        );


        /*
        |--------------------------------------------------------------------------
        | Comprobar movimiento
        |--------------------------------------------------------------------------
        */

        $stmt = $this->pdo->prepare("
            SELECT
                tipo_movimiento,
                cantidad,
                id_inventario,
                id_usuario
            FROM movimiento_inventario
            WHERE id_movimiento = :id_movimiento
        ");

        $stmt->execute([
            'id_movimiento' =>
                $this->idMovimiento
        ]);

        $registro =
            $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse(
            $registro
        );

        $this->assertSame(
            'ENTRADA',
            $registro['tipo_movimiento']
        );

        $this->assertSame(
            10,
            (int) $registro['cantidad']
        );


        /*
        |--------------------------------------------------------------------------
        | Comprobar existencia actualizada
        |--------------------------------------------------------------------------
        */

        $stmt = $this->pdo->prepare("
            SELECT cantidad_disponible
            FROM inventario
            WHERE id_inventario = :id_inventario
        ");

        $stmt->execute([
            'id_inventario' =>
                $this->idInventario
        ]);

        $existencia =
            (int) $stmt->fetchColumn();

        $this->assertSame(
            30,
            $existencia
        );
    }


    protected function tearDown(): void
    {
        /*
         * Como Repository utiliza su propia transacción,
         * eliminamos manualmente los datos de prueba.
         */

        if ($this->idMovimiento !== null) {

            $stmt = $this->pdo->prepare("
                DELETE FROM movimiento_inventario
                WHERE id_movimiento = :id
            ");

            $stmt->execute([
                'id' => $this->idMovimiento
            ]);
        }


        if (isset($this->idInventario)) {

            $stmt = $this->pdo->prepare("
                DELETE FROM inventario
                WHERE id_inventario = :id
            ");

            $stmt->execute([
                'id' => $this->idInventario
            ]);
        }


        if (isset($this->idUsuario)) {

            $stmt = $this->pdo->prepare("
                DELETE FROM usuario
                WHERE id_usuario = :id
            ");

            $stmt->execute([
                'id' => $this->idUsuario
            ]);
        }


        if (isset($this->idArea)) {

            $stmt = $this->pdo->prepare("
                DELETE FROM area
                WHERE id_area = :id
            ");

            $stmt->execute([
                'id' => $this->idArea
            ]);
        }
    }
}