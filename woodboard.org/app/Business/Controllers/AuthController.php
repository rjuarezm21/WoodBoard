<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function iniciarSesion(
        string $correo,
        string $contrasena
    ): bool {
        $usuario = $this->authService->autenticar(
            $correo,
            $contrasena
        );

        if ($usuario === null) {
            return false;
        }

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario->getIdUsuario();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['apellido'] = $usuario->getApellido();
        $_SESSION['correo'] = $usuario->getCorreo();
        $_SESSION['id_rol'] = $usuario->getIdRol();
        $_SESSION['id_area'] = $usuario->getIdArea();

        return true;
    }

    public function cerrarSesion(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parametros = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $parametros['path'],
                $parametros['domain'],
                $parametros['secure'],
                $parametros['httponly']
            );
        }

        session_destroy();
    }

    public function estaAutenticado(): bool
    {
        return isset($_SESSION['usuario_id']);
    }
}