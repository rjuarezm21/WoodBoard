<?php

declare(strict_types=1);

namespace App\Business\Services;

use App\Data\Models\Inventario;
use App\Data\Repositories\InventarioRepository;

class InventarioService
{
    private InventarioRepository $inventarioRepository;

    public function __construct(
        InventarioRepository $inventarioRepository
    ) {
        $this->inventarioRepository =
            $inventarioRepository;
    }

    public function listarInventario(): array
    {
        return $this->inventarioRepository
            ->listarTodos();
    }

    public function obtenerArticulo(
        int $idInventario
    ): ?Inventario {
        if ($idInventario <= 0) {
            return null;
        }

        return $this->inventarioRepository
            ->buscarPorId($idInventario);
    }

    public function registrarArticulo(
        array $datos
    ): array {
        $nombre = trim(
            (string) ($datos['nombre_item'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $categoria = trim(
            (string) ($datos['categoria'] ?? '')
        );

        $unidadMedida = trim(
            (string) ($datos['unidad_medida'] ?? '')
        );

        if (
            $nombre === ''
            || $categoria === ''
            || $unidadMedida === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Nombre, categoría y unidad de medida son obligatorios.'
            ];
        }

        /*
         * Todo artículo nuevo inicia en cero.
         * Las existencias se modificarán por movimientos.
         */
        $inventario = new Inventario(
            null,
            $nombre,
            $descripcion !== ''
                ? $descripcion
                : null,
            $categoria,
            0,
            $unidadMedida,
            true
        );

        $idInventario =
            $this->inventarioRepository
                ->crear($inventario);

        return [
            'ok' => true,
            'id_inventario' => $idInventario
        ];
    }

    public function actualizarArticulo(
        int $idInventario,
        array $datos
    ): array {
        $articulo =
            $this->inventarioRepository
                ->buscarPorId(
                    $idInventario
                );

        if ($articulo === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El artículo no existe.'
            ];
        }

        $nombre = trim(
            (string) ($datos['nombre_item'] ?? '')
        );

        $descripcion = trim(
            (string) ($datos['descripcion'] ?? '')
        );

        $categoria = trim(
            (string) ($datos['categoria'] ?? '')
        );

        $unidadMedida = trim(
            (string) ($datos['unidad_medida'] ?? '')
        );

        if (
            $nombre === ''
            || $categoria === ''
            || $unidadMedida === ''
        ) {
            return [
                'ok' => false,
                'mensaje' =>
                    'Nombre, categoría y unidad de medida son obligatorios.'
            ];
        }

        $articulo->setNombreItem(
            $nombre
        );

        $articulo->setDescripcion(
            $descripcion !== ''
                ? $descripcion
                : null
        );

        $articulo->setCategoria(
            $categoria
        );

        $articulo->setUnidadMedida(
            $unidadMedida
        );

        $this->inventarioRepository
            ->actualizar($articulo);

        return [
            'ok' => true
        ];
    }

    public function cambiarEstado(
        int $idInventario
    ): array {
        $articulo =
            $this->inventarioRepository
                ->buscarPorId(
                    $idInventario
                );

        if ($articulo === null) {
            return [
                'ok' => false,
                'mensaje' =>
                    'El artículo no existe.'
            ];
        }

        $nuevoEstado =
            !$articulo->getEstado();

        $this->inventarioRepository
            ->cambiarEstado(
                $idInventario,
                $nuevoEstado
            );

        return [
            'ok' => true,
            'estado' => $nuevoEstado
        ];
    }
}