<?php

declare(strict_types=1);

namespace App\Business\Services\Strategies;

use DateTimeImmutable;

final class VentasDiariasStrategy implements IndicadorDiarioStrategy
{
    public function preparar(array $datos): array
    {
        $etiquetas = [];
        $montos = [];
        $unidades = [];

        foreach ($datos as $fila) {
            $fecha = new DateTimeImmutable($fila['fecha']);
            $etiquetas[] = $fecha->format('d/m/Y');
            $montos[] = (float) $fila['monto'];
            $unidades[] = (int) $fila['unidades'];
        }

        return [
            'etiquetas' => $etiquetas,
            'montos' => $montos,
            'unidades' => $unidades
        ];
    }
}
