<?php

declare(strict_types=1);

namespace App\Business\Controllers;

use App\Business\Services\UsuarioService;

class UsuarioController
{
    private UsuarioService $usuarioService;

    public function __construct(
        UsuarioService $usuarioService
    ) {
        $this->usuarioService = $usuarioService;
    }

    public function listar(): array
    {
        return $this->usuarioService->listarUsuarios();
    }

    public function datosFormularioCrear(): array
    {
        return [
            'roles' => $this->usuarioService->obtenerRolesActivos(),
            'areas' => $this->usuarioService->obtenerAreasActivas()
        ];
    }

    public function crear(array $datos): array
    {
        return $this->usuarioService->registrarUsuario(
            $datos
        );
    }

    public function datosFormularioEditar(
        int $idUsuario
    ): array {
        return [
            'usuario' => $this->usuarioService->obtenerUsuario(
                $idUsuario
            ),
            'roles' => $this->usuarioService->obtenerRolesActivos(),
            'areas' => $this->usuarioService->obtenerAreasActivas()
        ];
    }

    public function editar(
        int $idUsuario,
        array $datos
    ): array {
        return $this->usuarioService->actualizarUsuario(
            $idUsuario,
            $datos
        );
    }

    public function cambiarEstado(
        int $idUsuario,
        int $idUsuarioSesion
    ): array {
        return $this->usuarioService->cambiarEstado(
            $idUsuario,
            $idUsuarioSesion
        );
    }
}