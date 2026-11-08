<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\RolRepository;

class RolService
{
    private RolRepository $rolRepository;
    private PermisoRepository $permisoRepository;

    public function __construct(
        RolRepository $rolRepository,
        PermisoRepository $permisoRepository
    ) {
        $this->rolRepository = $rolRepository;
        $this->permisoRepository = $permisoRepository;
    }

    public function listarRolesConPermisos(): array
    {
        $roles = $this->rolRepository->listarTodos();

        $resultado = [];

        foreach ($roles as $rol) {
            $idRol = $rol->getIdRol();

            if ($idRol === null) {
                continue;
            }

            $resultado[] = [
                'rol' => $rol,
                'permisos' =>
                    $this->permisoRepository
                        ->obtenerPorRol($idRol)
            ];
        }

        return $resultado;
    }

    public function datosEdicion(int $idRol): ?array
    {
        if ($idRol <= 0) {
            return null;
        }

        $rol = $this->rolRepository
            ->buscarPorId($idRol);

        if ($rol === null) {
            return null;
        }

        $todosPermisos =
            $this->permisoRepository
                ->listarTodos();

        $permisosAsignados =
            $this->permisoRepository
                ->obtenerPorRol($idRol);

        $idsAsignados = [];

        foreach ($permisosAsignados as $permiso) {
            $idPermiso = $permiso->getIdPermiso();

            if ($idPermiso !== null) {
                $idsAsignados[] = $idPermiso;
            }
        }

        return [
            'rol' => $rol,
            'permisos' => $todosPermisos,
            'ids_asignados' => $idsAsignados
        ];
    }

    public function actualizarRol(
        int $idRol,
        array $datos
    ): array {
        $rol = $this->rolRepository
            ->buscarPorId($idRol);

        if ($rol === null) {
            return [
                'ok' => false,
                'mensaje' => 'El rol no existe.'
            ];
        }

        $nombreRol = trim(
            (string) ($datos['nombre_rol'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $estado = isset($datos['estado']);

        $idsPermisos =
            $datos['permisos'] ?? [];

        if ($nombreRol === '') {
            return [
                'ok' => false,
                'mensaje' =>
                    'El nombre del rol es obligatorio.'
            ];
        }

        if (!is_array($idsPermisos)) {
            $idsPermisos = [];
        }

        $rol->setNombreRol($nombreRol);

        $rol->setDescripcion(
            $descripcion !== ''
                ? $descripcion
                : null
        );

        $rol->setEstado($estado);

        $this->rolRepository->actualizar($rol);

        $this->permisoRepository
            ->reemplazarPermisosRol(
                $idRol,
                $idsPermisos
            );

        return [
            'ok' => true
        ];
    }
}