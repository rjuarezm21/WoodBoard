<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\DashboardController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\DashboardService;
use App\Data\Repositories\DashboardRepository;
use App\Data\Repositories\PermisoRepository;


/*
|--------------------------------------------------------------------------
| Sesión
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Conexión
|--------------------------------------------------------------------------
*/

$crearConexion =
    require __DIR__
    . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| Permisos
|--------------------------------------------------------------------------
*/

$permisoRepository =
    new PermisoRepository($pdo);

$autorizacionService =
    new AutorizacionService(
        $permisoRepository
    );

$idRol =
    (int) ($_SESSION['id_rol'] ?? 0);


$puedeVerInventario =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_inventario'
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
    !$puedeVerInventario
    || !$puedeVerIndicadores
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| Capas
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Filtros
|--------------------------------------------------------------------------
*/

$filtros =
    $puedeAplicarFiltros
        ? $_GET
        : [];


$resultado =
    $dashboardController
        ->inventario(
            $filtros
        );

$error = null;


if (!$resultado['ok']) {
    $error =
        $resultado['mensaje'];

    $resultado =
        $dashboardController
            ->inventario();
}


/*
|--------------------------------------------------------------------------
| Datos para la View
|--------------------------------------------------------------------------
*/

$resumen =
    $resultado['resumen'];

$grafica =
    $resultado['grafica'];

$existencias =
    $resultado['existencias'];

$ultimosMovimientos =
    $resultado['ultimos_movimientos'];

$fechaInicio =
    $resultado['fecha_inicio'];

$fechaFin =
    $resultado['fecha_fin'];

$periodoAnterior =
    $resultado['periodo_anterior'];


/*
|--------------------------------------------------------------------------
| View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/dashboard/inventario.php';