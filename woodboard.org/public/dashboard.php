<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\DashboardController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\DashboardService;
use App\Data\Repositories\DashboardRepository;
use App\Data\Repositories\PermisoRepository;

if (!isset($_SESSION['usuario_id'])) {

    header('Location: login.php');

    exit;
}

$crearConexion =
    require __DIR__
    . '/../config/database.php';

$pdo = $crearConexion();

$permisoRepository =
    new PermisoRepository($pdo);

$autorizacionService =
    new AutorizacionService(
        $permisoRepository
    );

$idRol =
    (int) ($_SESSION['id_rol'] ?? 0);

if (
    !$autorizacionService->tienePermiso(
        $idRol,
        'ver_dashboard'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';

    exit;
}

$dashboardRepository =
    new DashboardRepository(
        $pdo
    );

$dashboardService =
    new DashboardService(
        $dashboardRepository
    );

$dashboardController =
    new DashboardController(
        $dashboardService
    );

$dashboard =
    $dashboardController
        ->general();

$resumen =
    $dashboard['resumen'];

$ventasGrafica =
    $dashboard['ventas'];

$produccionGrafica =
    $dashboard['produccion'];

$metas =
    $dashboard['metas'];

$mesActual =
    $dashboard['mes_actual'];

require __DIR__
    . '/../app/Presentation/Views/dashboard/general.php';