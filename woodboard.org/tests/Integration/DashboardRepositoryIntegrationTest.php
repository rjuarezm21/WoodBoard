<?php

declare(strict_types=1);

use App\Data\Repositories\DashboardRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class DashboardRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;

    private DashboardRepository $repository;

    private int $idArea;
    private int $idUsuario;
    private int $idMeta;
    private int $idInventario;


    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo =
            $crearConexion();

        $this->pdo
            ->beginTransaction();

        $this->repository =
            new DashboardRepository(
                $this->pdo
            );


        /*
        |--------------------------------------------------------------------------
        | Área temporal
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
                INSERT INTO area (
                    nombre_area,
                    descripcion,
                    estado
                )
                VALUES (
                    :nombre,
                    'Área dashboard',
                    1
                )
            ");

        $stmt->execute([
            'nombre' =>
                'Área dashboard '
                . uniqid()
        ]);

        $this->idArea =
            (int)
            $this->pdo
                ->lastInsertId();


        /*
        |--------------------------------------------------------------------------
        | Usuario temporal
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
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
                    'Dashboard',
                    :correo,
                    :contrasena,
                    1,
                    1,
                    :id_area
                )
            ");

        $stmt->execute([
            'correo' =>
                'dashboard_'
                . uniqid()
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
            (int)
            $this->pdo
                ->lastInsertId();


        /*
        |--------------------------------------------------------------------------
        | Meta temporal
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
                INSERT INTO meta_produccion (
                    descripcion,
                    cantidad_objetivo,
                    fecha_inicio,
                    fecha_fin,
                    estado
                )
                VALUES (
                    'Meta dashboard',
                    100,
                    '2026-10-01',
                    '2026-10-31',
                    1
                )
            ");

        $stmt->execute();

        $this->idMeta =
            (int)
            $this->pdo
                ->lastInsertId();


        /*
        |--------------------------------------------------------------------------
        | Producción
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
                INSERT INTO produccion (
                    fecha,
                    descripcion,
                    cantidad_producida,
                    id_meta,
                    id_usuario
                )
                VALUES (
                    '2026-10-06',
                    'Producción dashboard',
                    40,
                    :id_meta,
                    :id_usuario
                )
            ");

        $stmt->execute([
            'id_meta' =>
                $this->idMeta,

            'id_usuario' =>
                $this->idUsuario
        ]);


        /*
        |--------------------------------------------------------------------------
        | Venta
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
                INSERT INTO venta (
                    fecha_venta,
                    descripcion,
                    cantidad,
                    monto_total,
                    id_usuario
                )
                VALUES (
                    '2026-10-06',
                    'Mesa dashboard',
                    2,
                    2500,
                    :id_usuario
                )
            ");

        $stmt->execute([
            'id_usuario' =>
                $this->idUsuario
        ]);


        /*
        |--------------------------------------------------------------------------
        | Inventario
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
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
                    'Artículo dashboard',
                    'Prueba',
                    20,
                    'unidades',
                    1
                )
            ");

        $stmt->execute([
            'nombre' =>
                'Artículo dashboard '
                . uniqid()
        ]);

        $this->idInventario =
            (int)
            $this->pdo
                ->lastInsertId();


        /*
        |--------------------------------------------------------------------------
        | Movimiento
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->pdo->prepare("
                INSERT INTO movimiento_inventario (
                    tipo_movimiento,
                    cantidad,
                    fecha_movimiento,
                    observacion,
                    id_inventario,
                    id_usuario
                )
                VALUES (
                    'ENTRADA',
                    10,
                    '2026-10-06',
                    'Movimiento dashboard',
                    :id_inventario,
                    :id_usuario
                )
            ");

        $stmt->execute([
            'id_inventario' =>
                $this->idInventario,

            'id_usuario' =>
                $this->idUsuario
        ]);
    }


    public function testObtieneResumenGeneral(): void
    {
        $resultado =
            $this->repository
                ->obtenerResumen(
                    '2026-10-01',
                    '2026-10-31'
                );

        $this->assertGreaterThanOrEqual(
            2500,
            $resultado[
                'ventas_mes'
            ]
        );

        $this->assertGreaterThanOrEqual(
            2,
            $resultado[
                'unidades_vendidas'
            ]
        );

        $this->assertGreaterThanOrEqual(
            40,
            $resultado[
                'produccion_mes'
            ]
        );
    }


    public function testObtieneResumenProduccion(): void
    {
        $resultado =
            $this->repository
                ->obtenerResumenProduccionPeriodo(
                    '2026-10-01',
                    '2026-10-31'
                );

        $this->assertGreaterThanOrEqual(
            40,
            $resultado[
                'total_producido'
            ]
        );

        $this->assertGreaterThanOrEqual(
            1,
            $resultado[
                'total_registros'
            ]
        );
    }


    public function testObtieneResumenInventario(): void
    {
        $resultado =
            $this->repository
                ->obtenerResumenInventarioPeriodo(
                    '2026-10-01',
                    '2026-10-31'
                );

        $this->assertGreaterThanOrEqual(
            1,
            $resultado[
                'articulos_activos'
            ]
        );

        $this->assertGreaterThanOrEqual(
            1,
            $resultado[
                'total_movimientos'
            ]
        );
    }


    public function testObtieneResumenVentas(): void
    {
        $resultado =
            $this->repository
                ->obtenerResumenVentasPeriodo(
                    '2026-10-01',
                    '2026-10-31'
                );

        $this->assertGreaterThanOrEqual(
            2500,
            $resultado[
                'monto_total'
            ]
        );

        $this->assertGreaterThanOrEqual(
            2,
            $resultado[
                'unidades_vendidas'
            ]
        );

        $this->assertGreaterThanOrEqual(
            1,
            $resultado[
                'total_ventas'
            ]
        );
    }


    protected function tearDown(): void
    {
        if (
            $this->pdo
                ->inTransaction()
        ) {
            $this->pdo
                ->rollBack();
        }
    }
}