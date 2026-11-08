<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\ProduccionController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\ProduccionService;
use App\Data\Repositories\MetaProduccionRepository;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\ProduccionRepository;

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
        'ver_produccion'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}

$produccionRepository =
    new ProduccionRepository($pdo);

$metaRepository =
    new MetaProduccionRepository($pdo);

$produccionService =
    new ProduccionService(
        $produccionRepository,
        $metaRepository
    );

$produccionController =
    new ProduccionController(
        $produccionService
    );

$producciones =
    $produccionController->listar();

require __DIR__
    . '/../app/Presentation/Views/produccion/index.php';