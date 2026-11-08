<?php

declare(strict_types=1);

require_once __DIR__
    . '/../vendor/autoload.php';

require_once __DIR__
    . '/../config/session.php';


use App\Business\Controllers\ProduccionController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\CsrfService;
use App\Business\Services\ProduccionService;
use App\Data\Repositories\MetaProduccionRepository;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\ProduccionRepository;


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
            'registrar_produccion'
        )
) {
    http_response_code(403);

    echo 'Acceso denegado.';

    exit;
}


$produccionRepository =
    new ProduccionRepository(
        $pdo
    );

$metaProduccionRepository =
    new MetaProduccionRepository(
        $pdo
    );

$produccionService =
    new ProduccionService(
        $produccionRepository,
        $metaProduccionRepository
    );

$produccionController =
    new ProduccionController(
        $produccionService
    );


$csrfService =
    new CsrfService();

$csrfToken =
    $csrfService
        ->generarToken();


$datosFormulario =
    $produccionController
        ->datosFormularioCrear();

$metas =
    $datosFormulario[
        'metas'
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
        isset($_POST['csrf_token'])
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
            $produccionController
                ->crear(
                    $_POST,
                    $idUsuario
                );


        if (
            $resultado['ok']
        ) {
            $csrfService
                ->regenerarToken();

            header(
                'Location: produccion.php?creado=1'
            );

            exit;
        }


        $error =
            $resultado[
                'mensaje'
            ]
            ?? 'No fue posible registrar la producción.';
    }
}


require __DIR__
    . '/../app/Presentation/Views/produccion/crear.php';