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

$idInventario =
    (int) ($_GET['id'] ?? 0);

if ($idInventario <= 0) {
    header('Location: inventario.php');
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

$articulo =
    $inventarioController->obtener(
        $idInventario
    );

if ($articulo === null) {
    http_response_code(404);

    echo 'Artículo no encontrado.';
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $inventarioController->editar(
            $idInventario,
            $_POST
        );

    if ($resultado['ok']) {

        header(
            'Location: inventario.php?editado=1'
        );

        exit;
    }

    $error =
        $resultado['mensaje'];
}

require __DIR__
    . '/../app/Presentation/Views/inventario/editar.php';