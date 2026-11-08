<?php

declare(strict_types=1);

namespace App\Data\Models;

class Empleado
{
    private ?int $idEmpleado;
    private string $nombre;
    private string $apellido;
    private string $puesto;
    private string $fechaIngreso;
    private bool $estado;
    private int $idArea;

    public function __construct(
        ?int $idEmpleado,
        string $nombre,
        string $apellido,
        string $puesto,
        string $fechaIngreso,
        bool $estado,
        int $idArea
    ) {
        $this->idEmpleado = $idEmpleado;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->puesto = $puesto;
        $this->fechaIngreso = $fechaIngreso;
        $this->estado = $estado;
        $this->idArea = $idArea;
    }

    public function getIdEmpleado(): ?int
    {
        return $this->idEmpleado;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getPuesto(): string
    {
        return $this->puesto;
    }

    public function getFechaIngreso(): string
    {
        return $this->fechaIngreso;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function getIdArea(): int
    {
        return $this->idArea;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function setPuesto(string $puesto): void
    {
        $this->puesto = $puesto;
    }

    public function setFechaIngreso(string $fechaIngreso): void
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }

    public function setIdArea(int $idArea): void
    {
        $this->idArea = $idArea;
    }
}