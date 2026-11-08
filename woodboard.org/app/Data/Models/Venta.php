<?php

declare(strict_types=1);

namespace App\Data\Models;

class Venta
{
    private ?int $idVenta;
    private string $fechaVenta;
    private string $descripcion;
    private int $cantidad;
    private float $montoTotal;
    private int $idUsuario;

    public function __construct(
        ?int $idVenta,
        string $fechaVenta,
        string $descripcion,
        int $cantidad,
        float $montoTotal,
        int $idUsuario
    ) {
        $this->idVenta = $idVenta;
        $this->fechaVenta = $fechaVenta;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->montoTotal = $montoTotal;
        $this->idUsuario = $idUsuario;
    }

    public function getIdVenta(): ?int
    {
        return $this->idVenta;
    }

    public function getFechaVenta(): string
    {
        return $this->fechaVenta;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getMontoTotal(): float
    {
        return $this->montoTotal;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }
}