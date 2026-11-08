<?php

declare(strict_types=1);

use App\Business\Services\AuthService;
use App\Data\Models\Usuario;
use App\Data\Repositories\UsuarioRepository;
use PHPUnit\Framework\TestCase;

final class AuthServiceTest extends TestCase
{
    public function testAutenticaUsuarioConDatosCorrectos(): void
    {
        $hash = password_hash(
            'Prueba123',
            PASSWORD_DEFAULT
        );

        $usuario = new Usuario(
            1,
            'Usuario',
            'Prueba',
            'prueba@woodboard.org',
            $hash,
            true,
            1,
            1
        );

        $repository = $this->createMock(
            UsuarioRepository::class
        );

        $repository
            ->method('buscarPorCorreo')
            ->with('prueba@woodboard.org')
            ->willReturn($usuario);

        $service = new AuthService(
            $repository
        );

        $resultado = $service->autenticar(
            'prueba@woodboard.org',
            'Prueba123'
        );

        $this->assertNotNull($resultado);

        $this->assertSame(
            1,
            $resultado->getIdUsuario()
        );
    }


    public function testRechazaContrasenaIncorrecta(): void
    {
        $hash = password_hash(
            'Prueba123',
            PASSWORD_DEFAULT
        );

        $usuario = new Usuario(
            1,
            'Usuario',
            'Prueba',
            'prueba@woodboard.org',
            $hash,
            true,
            1,
            1
        );

        $repository = $this->createMock(
            UsuarioRepository::class
        );

        $repository
            ->method('buscarPorCorreo')
            ->willReturn($usuario);

        $service = new AuthService(
            $repository
        );

        $resultado = $service->autenticar(
            'prueba@woodboard.org',
            'Incorrecta123'
        );

        $this->assertNull($resultado);
    }


    public function testRechazaUsuarioInactivo(): void
    {
        $hash = password_hash(
            'Prueba123',
            PASSWORD_DEFAULT
        );

        $usuario = new Usuario(
            1,
            'Usuario',
            'Prueba',
            'prueba@woodboard.org',
            $hash,
            false,
            1,
            1
        );

        $repository = $this->createMock(
            UsuarioRepository::class
        );

        $repository
            ->method('buscarPorCorreo')
            ->willReturn($usuario);

        $service = new AuthService(
            $repository
        );

        $resultado = $service->autenticar(
            'prueba@woodboard.org',
            'Prueba123'
        );

        $this->assertNull($resultado);
    }
}