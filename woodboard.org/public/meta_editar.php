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

$idMeta =
    (int) ($_GET['id'] ?? 0);

if ($idMeta <= 0) {
    header('Location: metas.php');
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

$meta =
    $metaController->obtener(
        $idMeta
    );

if ($meta === null) {
    http_response_code(404);

    echo 'Meta no encontrada.';
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $metaController->editar(
            $idMeta,
            $_POST
        );

    if ($resultado['ok']) {
        header(
            'Location: metas.php?editada=1'
        );
        exit;
    }

    $error = $resultado['mensaje'];
}

require __DIR__
    . '/../app/Presentation/Views/metas/editar.php';