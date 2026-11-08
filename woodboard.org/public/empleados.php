<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\EmpleadoController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\EmpleadoService;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\EmpleadoRepository;
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
| 2. Crear conexión PDO
|--------------------------------------------------------------------------
*/

$crearConexion =
    require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| 3. Comprobar autorización
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
        'gestionar_empleados'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| 4. Crear Repositories
|--------------------------------------------------------------------------
*/

$empleadoRepository =
    new EmpleadoRepository($pdo);

$areaRepository =
    new AreaRepository($pdo);


/*
|--------------------------------------------------------------------------
| 5. Crear Service
|--------------------------------------------------------------------------
*/

$empleadoService =
    new EmpleadoService(
        $empleadoRepository,
        $areaRepository
    );


/*
|--------------------------------------------------------------------------
| 6. Crear Controller
|--------------------------------------------------------------------------
*/

$empleadoController =
    new EmpleadoController(
        $empleadoService
    );


/*
|--------------------------------------------------------------------------
| 7. Obtener empleados
|--------------------------------------------------------------------------
*/

$empleados =
    $empleadoController->listar();


/*
|--------------------------------------------------------------------------
| 8. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/empleados/index.php';