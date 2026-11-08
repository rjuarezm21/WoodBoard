<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\RolController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\RolService;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\RolRepository;


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
        'gestionar_roles'
    )
    ||
    !$autorizacionService->tienePermiso(
        $idRolSesion,
        'gestionar_permisos'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


$idRol =
    (int) ($_GET['id'] ?? 0);


if ($idRol <= 0) {
    header('Location: roles.php');
    exit;
}


$rolRepository =
    new RolRepository($pdo);


$rolService =
    new RolService(
        $rolRepository,
        $permisoRepository
    );


$rolController =
    new RolController(
        $rolService
    );


$datos =
    $rolController
        ->datosEditar($idRol);


if ($datos === null) {
    http_response_code(404);

    echo 'Rol no encontrado.';
    exit;
}


$rol = $datos['rol'];

$permisos = $datos['permisos'];

$idsAsignados =
    $datos['ids_asignados'];


$error = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $rolController->editar(
            $idRol,
            $_POST
        );

    if ($resultado['ok']) {

        header(
            'Location: roles.php?editado=1'
        );

        exit;
    }

    $error = $resultado['mensaje'];
}


require __DIR__
    . '/../app/Presentation/Views/roles/editar.php';