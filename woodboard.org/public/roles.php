<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\RolController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\RolService;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\RolRepository;


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
        'gestionar_roles'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| 4. Crear Repository de roles
|--------------------------------------------------------------------------
*/

$rolRepository =
    new RolRepository($pdo);


/*
|--------------------------------------------------------------------------
| 5. Crear Service
|--------------------------------------------------------------------------
*/

$rolService =
    new RolService(
        $rolRepository,
        $permisoRepository
    );


/*
|--------------------------------------------------------------------------
| 6. Crear Controller
|--------------------------------------------------------------------------
*/

$rolController =
    new RolController(
        $rolService
    );


/*
|--------------------------------------------------------------------------
| 7. Obtener roles y permisos
|--------------------------------------------------------------------------
*/

$roles = $rolController->listar();


/*
|--------------------------------------------------------------------------
| 8. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/roles/index.php';