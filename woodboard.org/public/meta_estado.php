<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\MetaProduccionController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\MetaProduccionService;
use App\Data\Repositories\MetaProduccionRepository;
use App\Data\Repositories\PermisoRepository;

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: metas.php');
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
        'gestionar_metas_produccion'
    )
) {
    http_response_code(403);
    echo 'Acceso denegado.';
    exit;
}

$metaRepository =
    new MetaProduccionRepository($pdo);

$metaService =
    new MetaProduccionService(
        $metaRepository
    );

$metaController =
    new MetaProduccionController(
        $metaService
    );

$idMeta =
    (int) ($_POST['id_meta'] ?? 0);

$resultado =
    $metaController->cambiarEstado(
        $idMeta
    );

if (!$resultado['ok']) {

    $mensaje = urlencode(
        $resultado['mensaje']
    );

    header(
        'Location: metas.php?error='
        . $mensaje
    );

    exit;
}

header(
    'Location: metas.php?estado=1'
);

exit;