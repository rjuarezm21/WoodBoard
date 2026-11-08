<?php

declare(strict_types=1);

namespace App\Data\Models;

class Usuario
{
    private ?int $idUsuario;
    private string $nombre;
    private string $apellido;
    private string $correo;
    private string $contrasena;
    private bool $estado;
    private int $idRol;
    private int $idArea;

    public function __construct(
        ?int $idUsuario,
        string $nombre,
        string $apellido,
        string $correo,
        string $contrasena,
        bool $estado,
        int $idRol,
        int $idArea
    ) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->estado = $estado;
        $this->idRol = $idRol;
        $this->idArea = $idArea;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function getIdRol(): int
    {
        return $this->idRol;
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

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }

    public function setIdRol(int $idRol): void
    {
        $this->idRol = $idRol;
    }

    public function setIdArea(int $idArea): void
    {
        $this->idArea = $idArea;
    }
}