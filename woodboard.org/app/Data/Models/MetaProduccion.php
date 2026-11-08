<?php

declare(strict_types=1);

namespace App\Data\Models;

class MetaProduccion
{
    private ?int $idMeta;
    private string $descripcion;
    private int $cantidadObjetivo;
    private string $fechaInicio;
    private string $fechaFin;
    private bool $estado;

    public function __construct(
        ?int $idMeta,
        string $descripcion,
        int $cantidadObjetivo,
        string $fechaInicio,
        string $fechaFin,
        bool $estado
    ) {
        $this->idMeta = $idMeta;
        $this->descripcion = $descripcion;
        $this->cantidadObjetivo = $cantidadObjetivo;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->estado = $estado;
    }

    public function getIdMeta(): ?int
    {
        return $this->idMeta;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getCantidadObjetivo(): int
    {
        return $this->cantidadObjetivo;
    }

    public function getFechaInicio(): string
    {
        return $this->fechaInicio;
    }

    public function getFechaFin(): string
    {
        return $this->fechaFin;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setCantidadObjetivo(int $cantidadObjetivo): void
    {
        $this->cantidadObjetivo = $cantidadObjetivo;
    }

    public function setFechaInicio(string $fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin(string $fechaFin): void
    {
        $this->fechaFin = $fechaFin;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}