<?php

declare(strict_types=1);

namespace App\Data\Models;

class Inventario
{
    private ?int $idInventario;
    private string $nombreItem;
    private ?string $descripcion;
    private string $categoria;
    private int $cantidadDisponible;
    private string $unidadMedida;
    private bool $estado;

    public function __construct(
        ?int $idInventario,
        string $nombreItem,
        ?string $descripcion,
        string $categoria,
        int $cantidadDisponible,
        string $unidadMedida,
        bool $estado
    ) {
        $this->idInventario = $idInventario;
        $this->nombreItem = $nombreItem;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->cantidadDisponible = $cantidadDisponible;
        $this->unidadMedida = $unidadMedida;
        $this->estado = $estado;
    }

    public function getIdInventario(): ?int
    {
        return $this->idInventario;
    }

    public function getNombreItem(): string
    {
        return $this->nombreItem;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getCantidadDisponible(): int
    {
        return $this->cantidadDisponible;
    }

    public function getUnidadMedida(): string
    {
        return $this->unidadMedida;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setNombreItem(string $nombreItem): void
    {
        $this->nombreItem = $nombreItem;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function setCantidadDisponible(int $cantidadDisponible): void
    {
        $this->cantidadDisponible = $cantidadDisponible;
    }

    public function setUnidadMedida(string $unidadMedida): void
    {
        $this->unidadMedida = $unidadMedida;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}