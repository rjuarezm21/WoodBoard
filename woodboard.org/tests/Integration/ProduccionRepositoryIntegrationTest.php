<?php

declare(strict_types=1);

use App\Data\Models\Produccion;
use App\Data\Repositories\ProduccionRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class ProduccionRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;
    private ProduccionRepository $repository;

    private int $idMeta;
    private int $idUsuario;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        $this->pdo->beginTransaction();

        $this->repository =
            new ProduccionRepository(
                $this->pdo
            );

        /*
         * Crear área temporal
         */
        $stmt = $this->pdo->prepare("
            INSERT INTO area (
                nombre_area,
                descripcion,
                estado
            )
            VALUES (
                :nombre_area,
                :descripcion,
                1
            )
        ");

        $stmt->execute([
            'nombre_area' =>
                'Área Producción ' . uniqid(),

            'descripcion' =>
                'Área temporal'
        ]);

        $idArea =
            (int) $this->pdo->lastInsertId();


        /*
         * Crear usuario temporal
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
                'Integración',
                :correo,
                :contrasena,
                1,
                1,
                :id_area
            )
        ");

        $stmt->execute([
            'correo' =>
                'produccion_' . uniqid()
                . '@woodboard.test',

            'contrasena' =>
                password_hash(
                    'Prueba123',
                    PASSWORD_DEFAULT
                ),

            'id_area' =>
                $idArea
        ]);

        $this->idUsuario =
            (int) $this->pdo->lastInsertId();


        /*
         * Crear meta temporal
         */
        $stmt = $this->pdo->prepare("
            INSERT INTO meta_produccion (
                descripcion,
                cantidad_objetivo,
                fecha_inicio,
                fecha_fin,
                estado
            )
            VALUES (
                'Meta integración',
                100,
                '2026-10-01',
                '2026-10-31',
                1
            )
        ");

        $stmt->execute();

        $this->idMeta =
            (int) $this->pdo->lastInsertId();
    }


    public function testCrearYBuscarProduccion(): void
    {
        $produccion = new Produccion(
            null,
            '2026-10-06',
            'Fabricación de mesas',
            12,
            $this->idMeta,
            $this->idUsuario
        );

        $idProduccion =
            $this->repository
                ->crear($produccion);

        $this->assertGreaterThan(
            0,
            $idProduccion
        );

        $registro =
            $this->repository
                ->buscarPorId(
                    $idProduccion
                );

        $this->assertInstanceOf(
            Produccion::class,
            $registro
        );

        $this->assertSame(
            '2026-10-06',
            $registro->getFecha()
        );

        $this->assertSame(
            'Fabricación de mesas',
            $registro->getDescripcion()
        );

        $this->assertSame(
            12,
            $registro->getCantidadProducida()
        );

        $this->assertSame(
            $this->idMeta,
            $registro->getIdMeta()
        );

        $this->assertSame(
            $this->idUsuario,
            $registro->getIdUsuario()
        );
    }


    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}