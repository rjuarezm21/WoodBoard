<?php

declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\Models\Inventario;
use PDO;

class InventarioRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /*
    |--------------------------------------------------------------------------
    | Buscar artículo por ID
    |--------------------------------------------------------------------------
    */
    public function buscarPorId(
        int $idInventario
    ): ?Inventario {
        $sql = "
            SELECT
                id_inventario,
                nombre_item,
                descripcion,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado
            FROM inventario
            WHERE id_inventario = :id_inventario
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id_inventario' => $idInventario
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->crearModelo($fila);
    }


    /*
    |--------------------------------------------------------------------------
    | Listar todos los artículos
    |--------------------------------------------------------------------------
    */
    public function listarTodos(): array
    {
        $sql = "
            SELECT
                id_inventario,
                nombre_item,
                descripcion,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado
            FROM inventario
            ORDER BY nombre_item
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $articulos = [];

        foreach ($stmt->fetchAll() as $fila) {
            $articulos[] =
                $this->crearModelo($fila);
        }

        return $articulos;
    }


    /*
    |--------------------------------------------------------------------------
    | Listar únicamente artículos activos
    |--------------------------------------------------------------------------
    |
    | Este método se utiliza en el formulario de movimientos.
    | Así no se pueden registrar entradas o salidas para artículos inactivos.
    |
    */
    public function listarActivos(): array
    {
        $sql = "
            SELECT
                id_inventario,
                nombre_item,
                descripcion,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado
            FROM inventario
            WHERE estado = 1
            ORDER BY nombre_item
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $articulos = [];

        foreach ($stmt->fetchAll() as $fila) {
            $articulos[] =
                $this->crearModelo($fila);
        }

        return $articulos;
    }


    /*
    |--------------------------------------------------------------------------
    | Crear artículo
    |--------------------------------------------------------------------------
    */
    public function crear(
        Inventario $inventario
    ): int {
        $sql = "
            INSERT INTO inventario (
                nombre_item,
                descripcion,
                categoria,
                cantidad_disponible,
                unidad_medida,
                estado
            )
            VALUES (
                :nombre_item,
                :descripcion,
                :categoria,
                :cantidad_disponible,
                :unidad_medida,
                :estado
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nombre_item' =>
                $inventario->getNombreItem(),

            'descripcion' =>
                $inventario->getDescripcion(),

            'categoria' =>
                $inventario->getCategoria(),

            'cantidad_disponible' =>
                $inventario->getCantidadDisponible(),

            'unidad_medida' =>
                $inventario->getUnidadMedida(),

            'estado' =>
                $inventario->getEstado()
                    ? 1
                    : 0
        ]);

        return (int)
            $this->pdo->lastInsertId();
    }


    /*
    |--------------------------------------------------------------------------
    | Actualizar artículo
    |--------------------------------------------------------------------------
    |
    | IMPORTANTE:
    | cantidad_disponible NO se actualiza desde aquí.
    |
    | La existencia únicamente debe cambiar mediante
    | entradas y salidas del módulo de movimientos.
    |
    */
    public function actualizar(
        Inventario $inventario
    ): bool {
        $sql = "
            UPDATE inventario
            SET
                nombre_item = :nombre_item,
                descripcion = :descripcion,
                categoria = :categoria,
                unidad_medida = :unidad_medida,
                estado = :estado
            WHERE id_inventario = :id_inventario
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nombre_item' =>
                $inventario->getNombreItem(),

            'descripcion' =>
                $inventario->getDescripcion(),

            'categoria' =>
                $inventario->getCategoria(),

            'unidad_medida' =>
                $inventario->getUnidadMedida(),

            'estado' =>
                $inventario->getEstado()
                    ? 1
                    : 0,

            'id_inventario' =>
                $inventario->getIdInventario()
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Cambiar estado
    |--------------------------------------------------------------------------
    */
    public function cambiarEstado(
        int $idInventario,
        bool $estado
    ): bool {
        $sql = "
            UPDATE inventario
            SET estado = :estado
            WHERE id_inventario = :id_inventario
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'estado' =>
                $estado ? 1 : 0,

            'id_inventario' =>
                $idInventario
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Convertir fila de BD en objeto Inventario
    |--------------------------------------------------------------------------
    */
    private function crearModelo(
        array $fila
    ): Inventario {
        return new Inventario(
            (int) $fila['id_inventario'],
            $fila['nombre_item'],
            $fila['descripcion'],
            $fila['categoria'],
            (int) $fila['cantidad_disponible'],
            $fila['unidad_medida'],
            (bool) $fila['estado']
        );
    }
}