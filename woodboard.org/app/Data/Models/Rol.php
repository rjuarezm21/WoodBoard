<?php

declare(strict_types=1);

namespace App\Data\Models;

class Rol
{
    private ?int $idRol;
    private string $nombreRol;
    private ?string $descripcion;
    private bool $estado;

    public function __construct(
        ?int $idRol,
        string $nombreRol,
        ?string $descripcion,
        bool $estado
    ) {
        $this->idRol = $idRol;
        $this->nombreRol = $nombreRol;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    public function getIdRol(): ?int
    {
        return $this->idRol;
    }

    public function getNombreRol(): string
    {
        return $this->nombreRol;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setNombreRol(string $nombreRol): void
    {
        $this->nombreRol = $nombreRol;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}