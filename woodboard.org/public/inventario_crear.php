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

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $inventarioController->crear(
            $_POST
        );

    if ($resultado['ok']) {

        header(
            'Location: inventario.php?creado=1'
        );

        exit;
    }

    $error =
        $resultado['mensaje'];
}

require __DIR__
    . '/../app/Presentation/Views/inventario/crear.php';