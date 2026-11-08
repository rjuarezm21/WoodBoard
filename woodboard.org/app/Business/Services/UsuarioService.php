<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Usuario;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\RolRepository;
use App\Data\Repositories\UsuarioRepository;

class UsuarioService
{
    private UsuarioRepository $usuarioRepository;
    private RolRepository $rolRepository;
    private AreaRepository $areaRepository;

    public function __construct(
        UsuarioRepository $usuarioRepository,
        RolRepository $rolRepository,
        AreaRepository $areaRepository
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->rolRepository = $rolRepository;
        $this->areaRepository = $areaRepository;
    }

    public function listarUsuarios(): array
    {
        return $this->usuarioRepository->listarTodos();
    }

    public function obtenerUsuario(int $idUsuario): ?Usuario
    {
        if ($idUsuario <= 0) {
            return null;
        }

        return $this->usuarioRepository->buscarPorId(
            $idUsuario
        );
    }

    public function obtenerRolesActivos(): array
    {
        return $this->rolRepository->listarActivos();
    }

    public function obtenerAreasActivas(): array
    {
        return $this->areaRepository->listarActivas();
    }

    public function registrarUsuario(array $datos): array
    {
        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $apellido = trim((string) ($datos['apellido'] ?? ''));
        $correo = trim((string) ($datos['correo'] ?? ''));
        $contrasena = (string) ($datos['contrasena'] ?? '');

        $idRol = (int) ($datos['id_rol'] ?? 0);
        $idArea = (int) ($datos['id_area'] ?? 0);

        if (
            $nombre === ''
            || $apellido === ''
            || $correo === ''
            || $contrasena === ''
        ) {
            return [
                'ok' => false,
                'mensaje' => 'Todos los campos obligatorios deben completarse.'
            ];
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return [
                'ok' => false,
                'mensaje' => 'El correo electrónico no es válido.'
            ];
        }

        if (strlen($contrasena) < 8) {
            return [
                'ok' => false,
                'mensaje' => 'La contraseña debe tener al menos 8 caracteres.'
            ];
        }

        if ($this->usuarioRepository->existeCorreo($correo)) {
            return [
                'ok' => false,
                'mensaje' => 'El correo electrónico ya está registrado.'
            ];
        }

        $rol = $this->rolRepository->buscarPorId($idRol);

        if ($rol === null || !$rol->getEstado()) {
            return [
                'ok' => false,
                'mensaje' => 'El rol seleccionado no es válido.'
            ];
        }

        $area = $this->areaRepository->buscarPorId($idArea);

        if ($area === null || !$area->getEstado()) {
            return [
                'ok' => false,
                'mensaje' => 'El área seleccionada no es válida.'
            ];
        }

        $contrasenaHash = password_hash(
            $contrasena,
            PASSWORD_DEFAULT
        );

        $usuario = new Usuario(
            null,
            $nombre,
            $apellido,
            $correo,
            $contrasenaHash,
            true,
            $idRol,
            $idArea
        );

        $idUsuario = $this->usuarioRepository->crear(
            $usuario
        );

        return [
            'ok' => true,
            'id_usuario' => $idUsuario
        ];
    }

    public function actualizarUsuario(
        int $idUsuario,
        array $datos
    ): array {
        $usuario = $this->usuarioRepository->buscarPorId(
            $idUsuario
        );

        if ($usuario === null) {
            return [
                'ok' => false,
                'mensaje' => 'El usuario no existe.'
            ];
        }

        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $apellido = trim((string) ($datos['apellido'] ?? ''));
        $correo = trim((string) ($datos['correo'] ?? ''));
        $contrasena = (string) ($datos['contrasena'] ?? '');

        $idRol = (int) ($datos['id_rol'] ?? 0);
        $idArea = (int) ($datos['id_area'] ?? 0);

        if (
            $nombre === ''
            || $apellido === ''
            || $correo === ''
        ) {
            return [
                'ok' => false,
                'mensaje' => 'Nombre, apellido y correo son obligatorios.'
            ];
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return [
                'ok' => false,
                'mensaje' => 'El correo electrónico no es válido.'
            ];
        }

        if (
            $this->usuarioRepository->existeCorreoEnOtroUsuario(
                $correo,
                $idUsuario
            )
        ) {
            return [
                'ok' => false,
                'mensaje' => 'El correo electrónico ya pertenece a otro usuario.'
            ];
        }

        $rol = $this->rolRepository->buscarPorId($idRol);

        if ($rol === null || !$rol->getEstado()) {
            return [
                'ok' => false,
                'mensaje' => 'El rol seleccionado no es válido.'
            ];
        }

        $area = $this->areaRepository->buscarPorId($idArea);

        if ($area === null || !$area->getEstado()) {
            return [
                'ok' => false,
                'mensaje' => 'El área seleccionada no es válida.'
            ];
        }

        if ($contrasena !== '') {

            if (strlen($contrasena) < 8) {
                return [
                    'ok' => false,
                    'mensaje' => 'La nueva contraseña debe tener al menos 8 caracteres.'
                ];
            }

            $usuario->setContrasena(
                password_hash(
                    $contrasena,
                    PASSWORD_DEFAULT
                )
            );
        }

        $usuario->setNombre($nombre);
        $usuario->setApellido($apellido);
        $usuario->setCorreo($correo);
        $usuario->setIdRol($idRol);
        $usuario->setIdArea($idArea);

        $this->usuarioRepository->actualizar($usuario);

        return [
            'ok' => true
        ];
    }

    public function cambiarEstado(
        int $idUsuario,
        int $idUsuarioSesion
    ): array {
        $usuario = $this->usuarioRepository->buscarPorId(
            $idUsuario
        );

        if ($usuario === null) {
            return [
                'ok' => false,
                'mensaje' => 'El usuario no existe.'
            ];
        }

        if ($idUsuario === $idUsuarioSesion) {
            return [
                'ok' => false,
                'mensaje' => 'No puede desactivar su propio usuario.'
            ];
        }

        $nuevoEstado = !$usuario->getEstado();

        $this->usuarioRepository->cambiarEstado(
            $idUsuario,
            $nuevoEstado
        );

        return [
            'ok' => true,
            'estado' => $nuevoEstado
        ];
    }
}