<?php

declare(strict_types=1);

use App\Data\Models\Usuario;
use App\Data\Repositories\UsuarioRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class UsuarioRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;

    private UsuarioRepository $repository;

    private string $correoPrueba;

    protected function setUp(): void
    {
        $crearConexion =
            require __DIR__
            . '/../../config/database_test.php';

        $this->pdo = $crearConexion();

        /*
         * Iniciamos una transacción.
         * Al terminar la prueba se revierte,
         * para no dejar datos de prueba.
         */
        $this->pdo->beginTransaction();

        $this->repository =
            new UsuarioRepository(
                $this->pdo
            );

        $this->correoPrueba =
            'integracion_'
            . uniqid()
            . '@woodboard.test';


        /*
         * Insertamos un usuario temporal
         * directamente en la base de prueba.
         */
        $sql = "
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
                :nombre,
                :apellido,
                :correo,
                :contrasena,
                :estado,
                :id_rol,
                :id_area
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre' => 'Usuario',
            'apellido' => 'Integracion',
            'correo' => $this->correoPrueba,

            'contrasena' => password_hash(
                'Prueba123',
                PASSWORD_DEFAULT
            ),

            'estado' => 1,
            'id_rol' => 1,
            'id_area' => 1
        ]);
    }


    public function testBuscarUsuarioPorCorreoEnBaseReal(): void
    {
        $usuario =
            $this->repository
                ->buscarPorCorreo(
                    $this->correoPrueba
                );

        $this->assertInstanceOf(
            Usuario::class,
            $usuario
        );

        $this->assertSame(
            'Usuario',
            $usuario->getNombre()
        );

        $this->assertSame(
            'Integracion',
            $usuario->getApellido()
        );

        $this->assertSame(
            $this->correoPrueba,
            $usuario->getCorreo()
        );

        $this->assertTrue(
            $usuario->getEstado()
        );

        $this->assertSame(
            1,
            $usuario->getIdRol()
        );

        $this->assertSame(
            1,
            $usuario->getIdArea()
        );
    }


    public function testRetornaNullSiCorreoNoExiste(): void
    {
        $usuario =
            $this->repository
                ->buscarPorCorreo(
                    'correo_que_no_existe@woodboard.test'
                );

        $this->assertNull(
            $usuario
        );
    }


    protected function tearDown(): void
    {
        /*
         * Eliminamos todos los cambios
         * realizados durante la prueba.
         */
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}