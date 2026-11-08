<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\AreaController;
use App\Business\Services\AreaService;
use App\Business\Services\AutorizacionService;
use App\Data\Repositories\AreaRepository;
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
        'gestionar_areas'
    )
) {
    http_response_code(403);
    echo 'Acceso denegado.';
    exit;
}

$areaRepository =
    new AreaRepository($pdo);

$areaService =
    new AreaService($areaRepository);

$areaController =
    new AreaController($areaService);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $areaController->crear($_POST);

    if ($resultado['ok']) {
        header(
            'Location: areas.php?creada=1'
        );
        exit;
    }

    $error = $resultado['mensaje'];
}

require __DIR__
    . '/../app/Presentation/Views/areas/crear.php';