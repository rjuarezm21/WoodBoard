<?php

declare(strict_types=1);

namespace App\Data\Models;

class Area
{
    private ?int $idArea;
    private string $nombreArea;
    private ?string $descripcion;
    private bool $estado;

    public function __construct(
        ?int $idArea,
        string $nombreArea,
        ?string $descripcion,
        bool $estado
    ) {
        $this->idArea = $idArea;
        $this->nombreArea = $nombreArea;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    public function getIdArea(): ?int
    {
        return $this->idArea;
    }

    public function getNombreArea(): string
    {
        return $this->nombreArea;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setNombreArea(string $nombreArea): void
    {
        $this->nombreArea = $nombreArea;
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