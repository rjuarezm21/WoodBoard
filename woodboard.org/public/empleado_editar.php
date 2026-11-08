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
| 1. Comprobar que el usuario haya iniciado sesión
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
| 4. Obtener ID del empleado
|--------------------------------------------------------------------------
*/

$idEmpleado =
    (int) ($_GET['id'] ?? 0);

if ($idEmpleado <= 0) {
    header('Location: empleados.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| 5. Crear Repositories
|--------------------------------------------------------------------------
*/

$empleadoRepository =
    new EmpleadoRepository($pdo);

$areaRepository =
    new AreaRepository($pdo);


/*
|--------------------------------------------------------------------------
| 6. Crear Service
|--------------------------------------------------------------------------
*/

$empleadoService =
    new EmpleadoService(
        $empleadoRepository,
        $areaRepository
    );


/*
|--------------------------------------------------------------------------
| 7. Crear Controller
|--------------------------------------------------------------------------
*/

$empleadoController =
    new EmpleadoController(
        $empleadoService
    );


/*
|--------------------------------------------------------------------------
| 8. Obtener datos para el formulario
|--------------------------------------------------------------------------
*/

$datosFormulario =
    $empleadoController
        ->datosFormularioEditar(
            $idEmpleado
        );

$empleado =
    $datosFormulario['empleado'];

$areas =
    $datosFormulario['areas'];


/*
|--------------------------------------------------------------------------
| 9. Verificar que el empleado exista
|--------------------------------------------------------------------------
*/

if ($empleado === null) {
    http_response_code(404);

    echo 'Empleado no encontrado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| 10. Preparar variable de error
|--------------------------------------------------------------------------
*/

$error = null;


/*
|--------------------------------------------------------------------------
| 11. Procesar formulario
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $empleadoController->editar(
            $idEmpleado,
            $_POST
        );

    if ($resultado['ok']) {

        header(
            'Location: empleados.php?editado=1'
        );

        exit;
    }

    $error =
        $resultado['mensaje'];
}


/*
|--------------------------------------------------------------------------
| 12. Mostrar View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/empleados/editar.php';