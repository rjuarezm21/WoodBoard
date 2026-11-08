<?php

declare(strict_types=1);

namespace App\Data\Models;

class Produccion
{
    private ?int $idProduccion;
    private string $fecha;
    private string $descripcion;
    private int $cantidadProducida;
    private int $idMeta;
    private int $idUsuario;

    public function __construct(
        ?int $idProduccion,
        string $fecha,
        string $descripcion,
        int $cantidadProducida,
        int $idMeta,
        int $idUsuario
    ) {
        $this->idProduccion = $idProduccion;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cantidadProducida = $cantidadProducida;
        $this->idMeta = $idMeta;
        $this->idUsuario = $idUsuario;
    }

    public function getIdProduccion(): ?int
    {
        return $this->idProduccion;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getCantidadProducida(): int
    {
        return $this->cantidadProducida;
    }

    public function getIdMeta(): int
    {
        return $this->idMeta;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setCantidadProducida(int $cantidadProducida): void
    {
        $this->cantidadProducida = $cantidadProducida;
    }

    public function setIdMeta(int $idMeta): void
    {
        $this->idMeta = $idMeta;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }
}