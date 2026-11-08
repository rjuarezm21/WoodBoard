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

$empleadoRepository =
    new EmpleadoRepository($pdo);

$areaRepository =
    new AreaRepository($pdo);

$empleadoService =
    new EmpleadoService(
        $empleadoRepository,
        $areaRepository
    );

$empleadoController =
    new EmpleadoController(
        $empleadoService
    );

$datosFormulario =
    $empleadoController
        ->datosFormularioCrear();

$areas = $datosFormulario['areas'];

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $empleadoController->crear(
            $_POST
        );

    if ($resultado['ok']) {
        header(
            'Location: empleados.php?creado=1'
        );
        exit;
    }

    $error = $resultado['mensaje'];
}

require __DIR__
    . '/../app/Presentation/Views/empleados/crear.php';