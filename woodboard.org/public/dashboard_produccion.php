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
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| CONEXIÓN
|--------------------------------------------------------------------------
*/

$crearConexion =
    require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| AUTORIZACIÓN
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


$puedeVerProduccion =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_produccion'
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


/*
|--------------------------------------------------------------------------
| VALIDACIÓN DE PERMISOS
|--------------------------------------------------------------------------
*/

if (
    !$puedeVerProduccion
    || !$puedeVerIndicadores
) {

    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| ARQUITECTURA EN CAPAS
|--------------------------------------------------------------------------
|
| Repositorio:
| Acceso a la base de datos.
|
| Servicio:
| Procesamiento de indicadores y metas.
|
| Controlador:
| Coordina la solicitud y respuesta.
|
| Vista:
| Presenta indicadores y gráficas.
|
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
| FILTROS
|--------------------------------------------------------------------------
|
| Los usuarios con permiso pueden modificar
| las fechas de consulta.
|
| Los demás consultan el período predeterminado.
|
*/

$filtros =
    $puedeAplicarFiltros
        ? $_GET
        : [];


/*
|--------------------------------------------------------------------------
| OBTENER DASHBOARD DE PRODUCCIÓN
|--------------------------------------------------------------------------
*/

$resultado =
    $dashboardController->produccion(
        $filtros
    );

$error = null;


/*
|--------------------------------------------------------------------------
| VALIDAR RESULTADO
|--------------------------------------------------------------------------
*/

if (!$resultado['ok']) {

    $error =
        $resultado['mensaje'];

    $resultado =
        $dashboardController->produccion();

}


/*
|--------------------------------------------------------------------------
| INDICADORES DE PRODUCCIÓN
|--------------------------------------------------------------------------
*/

$resumen =
    $resultado['resumen'];

$grafica =
    $resultado['grafica'];


/*
|--------------------------------------------------------------------------
| CUMPLIMIENTO INDIVIDUAL DE METAS
|--------------------------------------------------------------------------
*/

$metas =
    $resultado['metas'];


/*
|--------------------------------------------------------------------------
| NUEVO: RESUMEN GENERAL DE METAS
|--------------------------------------------------------------------------
|
| Total de metas.
| Metas cumplidas.
| Metas en progreso.
| Metas vencidas.
| Porcentaje general de cumplimiento.
|
*/

$resumenMetas =
    $resultado['resumen_metas'] ?? [

        'total' => 0,

        'cumplidas' => 0,

        'en_progreso' => 0,

        'vencidas' => 0,

        'porcentaje_cumplimiento' => 0

    ];


/*
|--------------------------------------------------------------------------
| PERÍODO DE CONSULTA
|--------------------------------------------------------------------------
*/

$fechaInicio =
    $resultado['fecha_inicio'];

$fechaFin =
    $resultado['fecha_fin'];

$periodoAnterior =
    $resultado['periodo_anterior'];


/*
|--------------------------------------------------------------------------
| CAPA DE PRESENTACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/dashboard/produccion.php';
