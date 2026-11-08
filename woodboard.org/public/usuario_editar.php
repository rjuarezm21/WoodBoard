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


$idUsuario =
    (int) ($_GET['id'] ?? 0);


if ($idUsuario <= 0) {
    header('Location: usuarios.php');
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


$datosFormulario =
    $usuarioController
        ->datosFormularioEditar(
            $idUsuario
        );


$usuario = $datosFormulario['usuario'];

$roles = $datosFormulario['roles'];

$areas = $datosFormulario['areas'];


if ($usuario === null) {
    http_response_code(404);

    echo 'Usuario no encontrado.';
    exit;
}


$error = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultado =
        $usuarioController->editar(
            $idUsuario,
            $_POST
        );

    if ($resultado['ok']) {

        header(
            'Location: usuarios.php?editado=1'
        );

        exit;
    }

    $error = $resultado['mensaje'];
}


require __DIR__
    . '/../app/Presentation/Views/usuarios/editar.php';