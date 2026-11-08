<?php

declare(strict_types=1);

use App\Data\Models\MetaProduccion;
use App\Data\Repositories\MetaProduccionRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class MetaProduccionRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;

    private MetaProduccionRepository $repository;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        $this->pdo->beginTransaction();

        $this->repository =
            new MetaProduccionRepository(
                $this->pdo
            );
    }


    public function testCrearYBuscarMeta(): void
    {
        $meta = new MetaProduccion(
            null,
            'Meta integración',
            50,
            '2026-10-01',
            '2026-10-31',
            true
        );

        $idMeta =
            $this->repository->crear(
                $meta
            );

        $this->assertGreaterThan(
            0,
            $idMeta
        );


        $metaGuardada =
            $this->repository
                ->buscarPorId($idMeta);


        $this->assertInstanceOf(
            MetaProduccion::class,
            $metaGuardada
        );

        $this->assertSame(
            'Meta integración',
            $metaGuardada
                ->getDescripcion()
        );

        $this->assertSame(
            50,
            $metaGuardada
                ->getCantidadObjetivo()
        );

        $this->assertSame(
            '2026-10-01',
            $metaGuardada
                ->getFechaInicio()
        );

        $this->assertSame(
            '2026-10-31',
            $metaGuardada
                ->getFechaFin()
        );

        $this->assertTrue(
            $metaGuardada
                ->getEstado()
        );
    }


    public function testActualizarMeta(): void
    {
        $meta = new MetaProduccion(
            null,
            'Meta inicial',
            20,
            '2026-10-01',
            '2026-10-15',
            true
        );

        $idMeta =
            $this->repository
                ->crear($meta);


        $metaGuardada =
            $this->repository
                ->buscarPorId($idMeta);


        $this->assertNotNull(
            $metaGuardada
        );


        $metaGuardada
            ->setDescripcion(
                'Meta actualizada'
            );

        $metaGuardada
            ->setCantidadObjetivo(
                100
            );


        $resultado =
            $this->repository
                ->actualizar(
                    $metaGuardada
                );


        $this->assertTrue(
            $resultado
        );


        $metaActualizada =
            $this->repository
                ->buscarPorId($idMeta);


        $this->assertNotNull(
            $metaActualizada
        );

        $this->assertSame(
            'Meta actualizada',
            $metaActualizada
                ->getDescripcion()
        );

        $this->assertSame(
            100,
            $metaActualizada
                ->getCantidadObjetivo()
        );
    }


    public function testCambiarEstadoMeta(): void
    {
        $meta = new MetaProduccion(
            null,
            'Meta para estado',
            30,
            '2026-10-01',
            '2026-10-31',
            true
        );

        $idMeta =
            $this->repository
                ->crear($meta);


        $resultado =
            $this->repository
                ->cambiarEstado(
                    $idMeta,
                    false
                );


        $this->assertTrue(
            $resultado
        );


        $metaActualizada =
            $this->repository
                ->buscarPorId($idMeta);


        $this->assertNotNull(
            $metaActualizada
        );

        $this->assertFalse(
            $metaActualizada
                ->getEstado()
        );
    }


    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}