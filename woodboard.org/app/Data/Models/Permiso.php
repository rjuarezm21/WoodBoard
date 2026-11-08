<?php

declare(strict_types=1);

namespace App\Data\Models;

class Permiso
{
    private ?int $idPermiso;
    private string $nombrePermiso;
    private ?string $descripcion;

    public function __construct(
        ?int $idPermiso,
        string $nombrePermiso,
        ?string $descripcion
    ) {
        $this->idPermiso = $idPermiso;
        $this->nombrePermiso = $nombrePermiso;
        $this->descripcion = $descripcion;
    }

    public function getIdPermiso(): ?int
    {
        return $this->idPermiso;
    }

    public function getNombrePermiso(): string
    {
        return $this->nombrePermiso;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setNombrePermiso(string $nombrePermiso): void
    {
        $this->nombrePermiso = $nombrePermiso;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }
}