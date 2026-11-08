<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\MetaProduccionController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\MetaProduccionService;
use App\Data\Repositories\MetaProduccionRepository;
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
        'gestionar_metas_produccion'
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

$metaRepository =
    new MetaProduccionRepository($pdo);


/*
|--------------------------------------------------------------------------
| 5. Service
|--------------------------------------------------------------------------
*/

$metaService =
    new MetaProduccionService(
        $metaRepository
    );


/*
|--------------------------------------------------------------------------
| 6. Controller
|--------------------------------------------------------------------------
*/

$metaController =
    new MetaProduccionController(
        $metaService
    );


/*
|--------------------------------------------------------------------------
| 7. Obtener metas
|--------------------------------------------------------------------------
*/

$metas =
    $metaController->listar();


/*
|--------------------------------------------------------------------------
| 8. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/metas/index.php';