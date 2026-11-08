<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\MovimientoInventarioController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\MovimientoInventarioService;
use App\Data\Repositories\InventarioRepository;
use App\Data\Repositories\MovimientoInventarioRepository;
use App\Data\Repositories\PermisoRepository;

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
        'ver_movimientos_inventario'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}

$puedeRegistrar =
    $autorizacionService->tienePermiso(
        $idRolSesion,
        'registrar_movimientos_inventario'
    );

$movimientoRepository =
    new MovimientoInventarioRepository(
        $pdo
    );

$inventarioRepository =
    new InventarioRepository(
        $pdo
    );

$service =
    new MovimientoInventarioService(
        $movimientoRepository,
        $inventarioRepository
    );

$controller =
    new MovimientoInventarioController(
        $service
    );

$movimientos =
    $controller->listar();

require __DIR__
    . '/../app/Presentation/Views/movimientos/index.php';