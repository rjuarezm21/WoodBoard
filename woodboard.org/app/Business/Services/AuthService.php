<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Usuario;
use App\Data\Repositories\UsuarioRepository;

class AuthService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function autenticar(string $correo, string $contrasena): ?Usuario
    {
        $correo = trim($correo);

        if ($correo === '' || $contrasena === '') {
            return null;
        }

        $usuario = $this->usuarioRepository->buscarPorCorreo($correo);

        if ($usuario === null) {
            return null;
        }

        if (!$usuario->getEstado()) {
            return null;
        }

        if (!password_verify($contrasena, $usuario->getContrasena())) {
            return null;
        }

        return $usuario;
    }
}