<?php

declare(strict_types=1);

require_once __DIR__
    . '/../vendor/autoload.php';

require_once __DIR__
    . '/../config/session.php';


use App\Business\Controllers\MovimientoInventarioController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\CsrfService;
use App\Business\Services\MovimientoInventarioService;
use App\Data\Repositories\InventarioRepository;
use App\Data\Repositories\MovimientoInventarioRepository;
use App\Data\Repositories\PermisoRepository;


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


$crearConexion =
    require __DIR__
    . '/../config/database.php';

$pdo =
    $crearConexion();


$permisoRepository =
    new PermisoRepository(
        $pdo
    );

$autorizacionService =
    new AutorizacionService(
        $permisoRepository
    );

$idRol =
    (int) (
        $_SESSION['id_rol']
        ?? 0
    );


if (
    !$autorizacionService
        ->tienePermiso(
            $idRol,
            'registrar_movimientos_inventario'
        )
) {
    http_response_code(403);

    echo 'Acceso denegado.';

    exit;
}


$movimientoRepository =
    new MovimientoInventarioRepository(
        $pdo
    );

$inventarioRepository =
    new InventarioRepository(
        $pdo
    );

$movimientoService =
    new MovimientoInventarioService(
        $movimientoRepository,
        $inventarioRepository
    );

$movimientoController =
    new MovimientoInventarioController(
        $movimientoService
    );


$csrfService =
    new CsrfService();

$csrfToken =
    $csrfService
        ->generarToken();


$datosFormulario =
    $movimientoController
        ->datosFormularioCrear();

$articulos =
    $datosFormulario[
        'articulos'
    ]
    ?? [];


$error = null;


/*
|--------------------------------------------------------------------------
| REGISTRO
|--------------------------------------------------------------------------
*/

if (
    $_SERVER[
        'REQUEST_METHOD'
    ] === 'POST'
) {
    $tokenRecibido =
        isset(
            $_POST[
                'csrf_token'
            ]
        )
            ? (string)
                $_POST[
                    'csrf_token'
                ]
            : null;


    if (
        !$csrfService
            ->validarToken(
                $tokenRecibido
            )
    ) {
        http_response_code(419);

        $error =
            'La solicitud de seguridad no es válida. Recargue la página e intente nuevamente.';
    } else {
        $idUsuario =
            (int)
            $_SESSION[
                'usuario_id'
            ];


        $resultado =
            $movimientoController
                ->crear(
                    $_POST,
                    $idUsuario
                );


        if (
            $resultado[
                'ok'
            ]
        ) {
            $csrfService
                ->regenerarToken();

            header(
                'Location: movimientos.php?creado=1'
            );

            exit;
        }


        $error =
            $resultado[
                'mensaje'
            ]
            ?? 'No fue posible registrar el movimiento.';
    }
}


require __DIR__
    . '/../app/Presentation/Views/movimientos/crear.php';