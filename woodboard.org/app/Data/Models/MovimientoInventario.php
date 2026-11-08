<?php

declare(strict_types=1);

namespace App\Data\Models;

class MovimientoInventario
{
    private ?int $idMovimiento;
    private string $tipoMovimiento;
    private int $cantidad;
    private string $fechaMovimiento;
    private ?string $observacion;
    private int $idInventario;
    private int $idUsuario;

    public function __construct(
        ?int $idMovimiento,
        string $tipoMovimiento,
        int $cantidad,
        string $fechaMovimiento,
        ?string $observacion,
        int $idInventario,
        int $idUsuario
    ) {
        $this->idMovimiento = $idMovimiento;
        $this->tipoMovimiento = $tipoMovimiento;
        $this->cantidad = $cantidad;
        $this->fechaMovimiento = $fechaMovimiento;
        $this->observacion = $observacion;
        $this->idInventario = $idInventario;
        $this->idUsuario = $idUsuario;
    }

    public function getIdMovimiento(): ?int
    {
        return $this->idMovimiento;
    }

    public function getTipoMovimiento(): string
    {
        return $this->tipoMovimiento;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getFechaMovimiento(): string
    {
        return $this->fechaMovimiento;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function getIdInventario(): int
    {
        return $this->idInventario;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }
}