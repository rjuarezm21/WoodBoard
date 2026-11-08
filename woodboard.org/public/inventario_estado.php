<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\InventarioController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\InventarioService;
use App\Data\Repositories\InventarioRepository;
use App\Data\Repositories\PermisoRepository;

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: inventario.php');
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
        'gestionar_inventario'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}

$inventarioRepository =
    new InventarioRepository($pdo);

$inventarioService =
    new InventarioService(
        $inventarioRepository
    );

$inventarioController =
    new InventarioController(
        $inventarioService
    );

$idInventario =
    (int) ($_POST['id_inventario'] ?? 0);

$resultado =
    $inventarioController
        ->cambiarEstado(
            $idInventario
        );

if (!$resultado['ok']) {

    $mensaje = urlencode(
        $resultado['mensaje']
    );

    header(
        'Location: inventario.php?error='
        . $mensaje
    );

    exit;
}

header(
    'Location: inventario.php?estado=1'
);

exit;