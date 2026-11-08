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


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: usuarios.php');
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
        'gestionar_usuarios'
    )
) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


$usuarioRepository =
    new UsuarioRepository($pdo);

$rolRepository =
    new RolRepository($pdo);

$areaRepository =
    new AreaRepository($pdo);


$usuarioService =
    new UsuarioService(
        $usuarioRepository,
        $rolRepository,
        $areaRepository
    );


$usuarioController =
    new UsuarioController(
        $usuarioService
    );


$idUsuario =
    (int) ($_POST['id_usuario'] ?? 0);

$idUsuarioSesion =
    (int) ($_SESSION['usuario_id'] ?? 0);


$resultado =
    $usuarioController->cambiarEstado(
        $idUsuario,
        $idUsuarioSesion
    );


if (!$resultado['ok']) {

    $mensaje = urlencode(
        $resultado['mensaje']
    );

    header(
        'Location: usuarios.php?error='
        . $mensaje
    );

    exit;
}


header(
    'Location: usuarios.php?estado=1'
);

exit;