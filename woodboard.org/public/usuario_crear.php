<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\UsuarioController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\UsuarioService;
use App\Data\Repositories\AreaRepository;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\RolRepository;
use App\Data\Repositories\UsuarioRepository;


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

$crearConexion = require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| 3. Comprobar autorización
|--------------------------------------------------------------------------
*/

$permisoRepository = new PermisoRepository($pdo);

$autorizacionService = new AutorizacionService(
    $permisoRepository
);

$idRolSesion = (int) ($_SESSION['id_rol'] ?? 0);

if (
    !$autorizacionService->tienePermiso(
        $idRolSesion,
        'gestionar_usuarios'
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

$usuarioRepository = new UsuarioRepository($pdo);

$rolRepository = new RolRepository($pdo);

$areaRepository = new AreaRepository($pdo);


/*
|--------------------------------------------------------------------------
| 5. Crear Service
|--------------------------------------------------------------------------
*/

$usuarioService = new UsuarioService(
    $usuarioRepository,
    $rolRepository,
    $areaRepository
);


/*
|--------------------------------------------------------------------------
| 6. Crear Controller
|--------------------------------------------------------------------------
*/

$usuarioController = new UsuarioController(
    $usuarioService
);


/*
|--------------------------------------------------------------------------
| 7. Obtener datos necesarios para el formulario
|--------------------------------------------------------------------------
*/

$datosFormulario =
    $usuarioController->datosFormularioCrear();

$roles = $datosFormulario['roles'];

$areas = $datosFormulario['areas'];

$error = null;


/*
|--------------------------------------------------------------------------
| 8. Procesar formulario
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado = $usuarioController->crear($_POST);

    if ($resultado['ok']) {

        header('Location: usuarios.php?creado=1');
        exit;
    }

    $error = $resultado['mensaje'];
}


/*
|--------------------------------------------------------------------------
| 9. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/usuarios/crear.php';