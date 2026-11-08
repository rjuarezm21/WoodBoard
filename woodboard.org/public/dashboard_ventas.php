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
    require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


$permisoRepository =
    new PermisoRepository($pdo);

$autorizacionService =
    new AutorizacionService(
        $permisoRepository
    );

$idRol =
    (int) ($_SESSION['id_rol'] ?? 0);


$puedeVerVentas =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_ventas'
    );

$puedeVerIndicadores =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_indicadores'
    );

$puedeAplicarFiltros =
    $autorizacionService->tienePermiso(
        $idRol,
        'aplicar_filtros'
    );


if (
    !$puedeVerVentas
    || !$puedeVerIndicadores
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


$dashboardRepository =
    new DashboardRepository($pdo);

$dashboardService =
    new DashboardService(
        $dashboardRepository
    );

$dashboardController =
    new DashboardController(
        $dashboardService
    );


$filtros =
    $puedeAplicarFiltros
        ? $_GET
        : [];


$resultado =
    $dashboardController
        ->ventas(
            $filtros
        );

$error = null;


if (!$resultado['ok']) {
    $error =
        $resultado['mensaje'];

    $resultado =
        $dashboardController
            ->ventas();
}


$resumen =
    $resultado['resumen'];

$grafica =
    $resultado['grafica'];

$productos =
    $resultado['productos'];

$fechaInicio =
    $resultado['fecha_inicio'];

$fechaFin =
    $resultado['fecha_fin'];

$periodoAnterior =
    $resultado['periodo_anterior'];


require __DIR__
    . '/../app/Presentation/Views/dashboard/ventas.php';