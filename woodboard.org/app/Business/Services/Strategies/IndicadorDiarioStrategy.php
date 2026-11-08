<?php

declare(strict_types=1);

namespace App\Business\Services\Strategies;

interface IndicadorDiarioStrategy
{
    public function preparar(array $datos): array;
}
