<?php

declare(strict_types=1);

namespace App\Business\Services\Strategies;

use DateTimeImmutable;

final class ProduccionDiariaStrategy implements IndicadorDiarioStrategy
{
    public function preparar(array $datos): array
    {
        $etiquetas = [];
        $valores = [];

        foreach ($datos as $fila) {
            $fecha = new DateTimeImmutable($fila['fecha']);
            $etiquetas[] = $fecha->format('d/m/Y');
            $valores[] = (int) $fila['total'];
        }

        return ['etiquetas' => $etiquetas, 'valores' => $valores];
    }
}
