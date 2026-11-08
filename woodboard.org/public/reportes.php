<?php

declare(strict_types=1);

require_once __DIR__
    . '/../vendor/autoload.php';

require_once __DIR__
    . '/../config/session.php';


use App\Business\Controllers\ReporteController;
use App\Business\Services\AutorizacionService;
use App\Business\Services\ReporteService;
use App\Data\Repositories\PermisoRepository;
use App\Data\Repositories\ReporteRepository;


/*
|--------------------------------------------------------------------------
| SESIÓN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| CONEXIÓN
|--------------------------------------------------------------------------
*/

$crearConexion =
    require __DIR__
    . '/../config/database.php';

$pdo =
    $crearConexion();


/*
|--------------------------------------------------------------------------
| PERMISOS
|--------------------------------------------------------------------------
*/

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


$puedeVerIndicadores =
    $autorizacionService
        ->tienePermiso(
            $idRol,
            'ver_indicadores'
        );


$puedeVerVentas =
    $autorizacionService
        ->tienePermiso(
            $idRol,
            'ver_ventas'
        );


$puedeVerProduccion =
    $autorizacionService
        ->tienePermiso(
            $idRol,
            'ver_produccion'
        );


$puedeVerInventario =
    $autorizacionService
        ->tienePermiso(
            $idRol,
            'ver_inventario'
        );


$puedeAplicarFiltros =
    $autorizacionService
        ->tienePermiso(
            $idRol,
            'aplicar_filtros'
        );


if (!$puedeVerIndicadores) {
    http_response_code(403);

    echo 'Acceso denegado.';
    exit;
}


/*
|--------------------------------------------------------------------------
| TIPOS DE REPORTE PERMITIDOS
|--------------------------------------------------------------------------
*/

$tiposPermitidos = [];


if ($puedeVerVentas) {
    $tiposPermitidos[
        'ventas'
    ] =
        'Ventas';
}


if ($puedeVerProduccion) {
    $tiposPermitidos[
        'produccion'
    ] =
        'Producción';
}


if ($puedeVerInventario) {
    $tiposPermitidos[
        'inventario'
    ] =
        'Inventario';
}


if (count($tiposPermitidos) === 0) {
    http_response_code(403);

    echo 'No tiene acceso a ningún tipo de reporte.';
    exit;
}


/*
|--------------------------------------------------------------------------
| TIPO SOLICITADO
|--------------------------------------------------------------------------
*/

$tipoSolicitado =
    strtolower(
        trim(
            (string) (
                $_GET['tipo']
                ?? ''
            )
        )
    );


if (
    !isset(
        $tiposPermitidos[
            $tipoSolicitado
        ]
    )
) {
    $tipoSolicitado =
        array_key_first(
            $tiposPermitidos
        );
}


/*
|--------------------------------------------------------------------------
| CAPAS
|--------------------------------------------------------------------------
*/

$reporteRepository =
    new ReporteRepository(
        $pdo
    );

$reporteService =
    new ReporteService(
        $reporteRepository
    );

$reporteController =
    new ReporteController(
        $reporteService
    );


/*
|--------------------------------------------------------------------------
| FILTROS
|--------------------------------------------------------------------------
*/

$filtros = [
    'tipo' =>
        $tipoSolicitado
];


if ($puedeAplicarFiltros) {

    if (
        isset(
            $_GET['fecha_inicio']
        )
    ) {
        $filtros[
            'fecha_inicio'
        ] =
            $_GET[
                'fecha_inicio'
            ];
    }


    if (
        isset(
            $_GET['fecha_fin']
        )
    ) {
        $filtros[
            'fecha_fin'
        ] =
            $_GET[
                'fecha_fin'
            ];
    }
}


/*
|--------------------------------------------------------------------------
| GENERAR REPORTE
|--------------------------------------------------------------------------
*/

$resultado =
    $reporteController
        ->generar(
            $filtros
        );

$error = null;


/*
|--------------------------------------------------------------------------
| SI EL FILTRO ES INCORRECTO
|--------------------------------------------------------------------------
*/

if (!$resultado['ok']) {

    $error =
        $resultado[
            'mensaje'
        ];

    $resultado =
        $reporteController
            ->generar([
                'tipo' =>
                    $tipoSolicitado
            ]);
}


/*
|--------------------------------------------------------------------------
| DATOS PARA LA VIEW
|--------------------------------------------------------------------------
*/

$tipo =
    $resultado['tipo'];

$titulo =
    $resultado['titulo'];

$fechaInicio =
    $resultado[
        'fecha_inicio'
    ];

$fechaFin =
    $resultado[
        'fecha_fin'
    ];

$resumen =
    $resultado[
        'resumen'
    ];

$registros =
    $resultado[
        'registros'
    ];


/*
|--------------------------------------------------------------------------
| VIEW
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/reportes/index.php';