<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Services\AutorizacionService;
use App\Data\Repositories\PermisoRepository;


/*
|--------------------------------------------------------------------------
| SESIÓN
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


/*
|--------------------------------------------------------------------------
| PERMISOS
|--------------------------------------------------------------------------
*/

$puedeVerDashboard =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_dashboard'
    );


$puedeGestionarUsuarios =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_usuarios'
    );


$puedeGestionarRoles =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_roles'
    );


$puedeGestionarPermisos =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_permisos'
    );


$puedeGestionarAreas =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_areas'
    );


$puedeGestionarEmpleados =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_empleados'
    );


$puedeGestionarMetas =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_metas_produccion'
    );


$puedeRegistrarProduccion =
    $autorizacionService->tienePermiso(
        $idRol,
        'registrar_produccion'
    );


$puedeVerProduccion =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_produccion'
    );


$puedeGestionarInventario =
    $autorizacionService->tienePermiso(
        $idRol,
        'gestionar_inventario'
    );


$puedeVerInventario =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_inventario'
    );


$puedeRegistrarMovimientos =
    $autorizacionService->tienePermiso(
        $idRol,
        'registrar_movimientos_inventario'
    );


$puedeVerMovimientos =
    $autorizacionService->tienePermiso(
        $idRol,
        'ver_movimientos_inventario'
    );


$puedeRegistrarVentas =
    $autorizacionService->tienePermiso(
        $idRol,
        'registrar_ventas'
    );


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


/*
|--------------------------------------------------------------------------
| ACCESO A REPORTES
|--------------------------------------------------------------------------
*/

$puedeVerReportes =
    $puedeVerIndicadores
    && (
        $puedeVerVentas
        || $puedeVerProduccion
        || $puedeVerInventario
    );


/*
|--------------------------------------------------------------------------
| VIEW
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/panel.php';