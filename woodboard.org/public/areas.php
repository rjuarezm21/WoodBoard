<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\AreaController;
use App\Business\Services\AreaService;
use App\Business\Services\AutorizacionService;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\PermisoRepository;


/*
|--------------------------------------------------------------------------
| 1. Comprobar autenticación
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| 2. Crear conexión
|--------------------------------------------------------------------------
*/

$crearConexion =
    require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| 3. Comprobar permiso
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| 4. Repository
|--------------------------------------------------------------------------
*/

$areaRepository =
    new AreaRepository($pdo);


/*
|--------------------------------------------------------------------------
| 5. Service
|--------------------------------------------------------------------------
*/

$areaService =
    new AreaService(
        $areaRepository
    );


/*
|--------------------------------------------------------------------------
| 6. Controller
|--------------------------------------------------------------------------
*/

$areaController =
    new AreaController(
        $areaService
    );


/*
|--------------------------------------------------------------------------
| 7. Obtener áreas
|--------------------------------------------------------------------------
*/

$areas =
    $areaController->listar();


/*
|--------------------------------------------------------------------------
| 8. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/areas/index.php';