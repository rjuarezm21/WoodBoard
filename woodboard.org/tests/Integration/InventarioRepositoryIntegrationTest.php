<?php

declare(strict_types=1);

use App\Data\Models\Inventario;
use App\Data\Repositories\InventarioRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class InventarioRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;

    private InventarioRepository $repository;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        $this->pdo->beginTransaction();

        $this->repository =
            new InventarioRepository(
                $this->pdo
            );
    }


    public function testCrearYBuscarArticulo(): void
    {
        $articulo = new Inventario(
            null,
            'Madera integración',
            'Artículo temporal',
            'Materia prima',
            0,
            'tablas',
            true
        );

        $idInventario =
            $this->repository
                ->crear($articulo);

        $this->assertGreaterThan(
            0,
            $idInventario
        );

        $guardado =
            $this->repository
                ->buscarPorId(
                    $idInventario
                );

        $this->assertInstanceOf(
            Inventario::class,
            $guardado
        );

        $this->assertSame(
            'Madera integración',
            $guardado->getNombreItem()
        );

        $this->assertSame(
            0,
            $guardado->getCantidadDisponible()
        );

        $this->assertTrue(
            $guardado->getEstado()
        );
    }


    public function testActualizarArticuloSinAlterarExistencia(): void
    {
        $articulo = new Inventario(
            null,
            'Artículo inicial',
            null,
            'Materia prima',
            0,
            'unidades',
            true
        );

        $idInventario =
            $this->repository
                ->crear($articulo);

        $guardado =
            $this->repository
                ->buscarPorId(
                    $idInventario
                );

        $this->assertNotNull(
            $guardado
        );

        $guardado->setNombreItem(
            'Artículo actualizado'
        );

        $guardado->setCategoria(
            'Herrajes'
        );

        /*
         * Aunque el objeto se cambie aquí,
         * Repository::actualizar() no debe
         * modificar cantidad_disponible.
         */
        $guardado->setCantidadDisponible(
            999
        );

        $resultado =
            $this->repository
                ->actualizar(
                    $guardado
                );

        $this->assertTrue(
            $resultado
        );

        $actualizado =
            $this->repository
                ->buscarPorId(
                    $idInventario
                );

        $this->assertNotNull(
            $actualizado
        );

        $this->assertSame(
            'Artículo actualizado',
            $actualizado->getNombreItem()
        );

        $this->assertSame(
            0,
            $actualizado->getCantidadDisponible()
        );
    }


    public function testCambiarEstadoArticulo(): void
    {
        $articulo = new Inventario(
            null,
            'Artículo estado',
            null,
            'Prueba',
            0,
            'unidades',
            true
        );

        $idInventario =
            $this->repository
                ->crear($articulo);

        $resultado =
            $this->repository
                ->cambiarEstado(
                    $idInventario,
                    false
                );

        $this->assertTrue(
            $resultado
        );

        $actualizado =
            $this->repository
                ->buscarPorId(
                    $idInventario
                );

        $this->assertNotNull(
            $actualizado
        );

        $this->assertFalse(
            $actualizado->getEstado()
        );
    }


    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}