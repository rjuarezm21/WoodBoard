<?php

declare(strict_types=1);

require_once __DIR__
    . '/../vendor/autoload.php';

require_once __DIR__
    . '/../config/session.php';


use App\Business\Controllers\VentaController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\CsrfService;
use App\Business\Services\VentaService;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\VentaRepository;


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
            'registrar_ventas'
        )
) {
    http_response_code(403);

    echo 'Acceso denegado.';

    exit;
}


$ventaRepository =
    new VentaRepository(
        $pdo
    );

$ventaService =
    new VentaService(
        $ventaRepository
    );

$ventaController =
    new VentaController(
        $ventaService
    );


$csrfService =
    new CsrfService();

$csrfToken =
    $csrfService
        ->generarToken();


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
            $ventaController
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
                'Location: ventas.php?creado=1'
            );

            exit;
        }


        $error =
            $resultado[
                'mensaje'
            ]
            ?? 'No fue posible registrar la venta.';
    }
}


require __DIR__
    . '/../app/Presentation/Views/ventas/crear.php';