<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\VentaController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\VentaService;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\VentaRepository;

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$crearConexion =
    require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();

$permisoRepository =
    new PermisoRepository($pdo);

$autorizacionService =
    new AutorizacionService(
        $permisoRepository
    );

$idRolSesion =
    (int) ($_SESSION['id_rol'] ?? 0);

if (
    !$autorizacionService->tienePermiso(
        $idRolSesion,
        'ver_ventas'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}

$puedeRegistrar =
    $autorizacionService->tienePermiso(
        $idRolSesion,
        'registrar_ventas'
    );

$ventaRepository =
    new VentaRepository($pdo);

$ventaService =
    new VentaService(
        $ventaRepository
    );

$ventaController =
    new VentaController(
        $ventaService
    );

$ventas =
    $ventaController->listar();

require __DIR__
    . '/../app/Presentation/Views/ventas/index.php';