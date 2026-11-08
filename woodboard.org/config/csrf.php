<?php

declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| PROTECCIÓN CSRF GLOBAL
|--------------------------------------------------------------------------
|
| Este archivo:
|
| 1. Crea un token aleatorio por sesión.
| 2. Agrega automáticamente el token a todos los formularios POST.
| 3. Verifica el token antes de procesar cualquier POST.
| 4. Rechaza solicitudes sin token o con token incorrecto.
|
*/


/*
|--------------------------------------------------------------------------
| La sesión debe existir
|--------------------------------------------------------------------------
*/

if (
    session_status()
    !== PHP_SESSION_ACTIVE
) {
    throw new RuntimeException(
        'La sesión debe estar iniciada antes de cargar la protección CSRF.'
    );
}


/*
|--------------------------------------------------------------------------
| Generar token
|--------------------------------------------------------------------------
*/

if (
    !isset(
        $_SESSION[
            'csrf_token'
        ]
    )
    || !is_string(
        $_SESSION[
            'csrf_token'
        ]
    )
    || strlen(
        $_SESSION[
            'csrf_token'
        ]
    ) < 64
) {
    $_SESSION[
        'csrf_token'
    ] =
        bin2hex(
            random_bytes(32)
        );
}


$csrfToken =
    $_SESSION[
        'csrf_token'
    ];


/*
|--------------------------------------------------------------------------
| Método HTTP actual
|--------------------------------------------------------------------------
*/

$metodo =
    strtoupper(
        (string) (
            $_SERVER[
                'REQUEST_METHOD'
            ]
            ?? 'GET'
        )
    );


/*
|--------------------------------------------------------------------------
| Endpoints que SOLO deben modificar estado mediante POST
|--------------------------------------------------------------------------
|
| Evitamos que alguien pueda activar/inactivar registros escribiendo
| directamente una URL en el navegador.
|
*/

$archivoActual =
    basename(
        (string) (
            $_SERVER[
                'SCRIPT_NAME'
            ]
            ?? ''
        )
    );


$endpointsSoloPost = [
    'usuario_estado.php',
    'area_estado.php',
    'empleado_estado.php',
    'meta_estado.php',
    'inventario_estado.php'
];


if (
    in_array(
        $archivoActual,
        $endpointsSoloPost,
        true
    )
    && $metodo !== 'POST'
) {
    http_response_code(405);

    header(
        'Allow: POST'
    );

    header(
        'Content-Type: text/html; charset=UTF-8'
    );

    echo '<!DOCTYPE html>';

    echo '<html lang="es">';

    echo '<head>';

    echo '<meta charset="UTF-8">';

    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

    echo '<title>Método no permitido</title>';

    echo '</head>';

    echo '<body style="
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        padding: 40px;
        color: #222;
    ">';

    echo '<div style="
        max-width: 650px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
    ">';

    echo '<h1 style="margin-top:0;">
        Método no permitido
    </h1>';

    echo '<p>
        Esta operación solamente puede realizarse mediante una solicitud segura.
    </p>';

    echo '<p>
        <a href="javascript:history.back()">
            Volver
        </a>
    </p>';

    echo '</div>';

    echo '</body>';

    echo '</html>';

    exit;
}


/*
|--------------------------------------------------------------------------
| Métodos que requieren CSRF
|--------------------------------------------------------------------------
*/

$metodosProtegidos = [
    'POST',
    'PUT',
    'PATCH',
    'DELETE'
];


/*
|--------------------------------------------------------------------------
| Validar token recibido
|--------------------------------------------------------------------------
*/

if (
    in_array(
        $metodo,
        $metodosProtegidos,
        true
    )
) {
    $tokenRecibido = '';


    /*
    |--------------------------------------------------------------------------
    | Formularios tradicionales
    |--------------------------------------------------------------------------
    */

    if (
        isset(
            $_POST[
                'csrf_token'
            ]
        )
        && is_string(
            $_POST[
                'csrf_token'
            ]
        )
    ) {
        $tokenRecibido =
            $_POST[
                'csrf_token'
            ];
    }


    /*
    |--------------------------------------------------------------------------
    | Peticiones AJAX futuras
    |--------------------------------------------------------------------------
    */

    elseif (
        isset(
            $_SERVER[
                'HTTP_X_CSRF_TOKEN'
            ]
        )
        && is_string(
            $_SERVER[
                'HTTP_X_CSRF_TOKEN'
            ]
        )
    ) {
        $tokenRecibido =
            $_SERVER[
                'HTTP_X_CSRF_TOKEN'
            ];
    }


    /*
    |--------------------------------------------------------------------------
    | Comparación segura
    |--------------------------------------------------------------------------
    */

    if (
        $tokenRecibido === ''
        || !hash_equals(
            $csrfToken,
            $tokenRecibido
        )
    ) {
        http_response_code(419);

        header(
            'Content-Type: text/html; charset=UTF-8'
        );


        echo '<!DOCTYPE html>';

        echo '<html lang="es">';

        echo '<head>';

        echo '<meta charset="UTF-8">';

        echo '<meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >';

        echo '<title>
            Solicitud no válida
        </title>';

        echo '</head>';

        echo '<body style="
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
            color: #222;
        ">';


        echo '<div style="
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        ">';


        echo '<h1 style="margin-top:0;">
            Solicitud no válida
        </h1>';


        echo '<p>
            El formulario no contiene un token
            de seguridad válido o la sesión cambió.
        </p>';


        echo '<p>
            Regrese a la página anterior,
            recárguela e intente nuevamente.
        </p>';


        echo '<p>
            <a href="javascript:history.back()">
                Volver
            </a>
        </p>';


        echo '</div>';

        echo '</body>';

        echo '</html>';


        exit;
    }
}


/*
|--------------------------------------------------------------------------
| INSERTAR TOKEN AUTOMÁTICAMENTE EN TODOS LOS FORMULARIOS POST
|--------------------------------------------------------------------------
|
| El sistema examina el HTML antes de enviarlo al navegador.
|
| Cuando encuentra:
|
| <form method="POST">
|
| agrega:
|
| <input
|     type="hidden"
|     name="csrf_token"
|     value="TOKEN"
| >
|
| Si el formulario ya tiene csrf_token, no lo duplica.
|
*/

if (
    !defined(
        'WOODBOARD_CSRF_OUTPUT_FILTER'
    )
) {
    define(
        'WOODBOARD_CSRF_OUTPUT_FILTER',
        true
    );


    ob_start(

        static function (
            string $buffer
        ) use (
            $csrfToken
        ): string {

            /*
            |--------------------------------------------------------------------------
            | Si no existen formularios, no hacer nada
            |--------------------------------------------------------------------------
            */

            if (
                stripos(
                    $buffer,
                    '<form'
                ) === false
            ) {
                return $buffer;
            }


            /*
            |--------------------------------------------------------------------------
            | Token escapado para HTML
            |--------------------------------------------------------------------------
            */

            $tokenEscapado =
                htmlspecialchars(
                    $csrfToken,
                    ENT_QUOTES
                    | ENT_SUBSTITUTE,
                    'UTF-8'
                );


            /*
            |--------------------------------------------------------------------------
            | Buscar formularios POST completos
            |--------------------------------------------------------------------------
            */

            $patron =
                '~'
                . '(<form\b'
                . '(?=[^>]*\bmethod\s*=\s*'
                . '(?:"post"|\'post\'|post))'
                . '[^>]*>)'
                . '(.*?)'
                . '(</form>)'
                . '~is';


            $resultado =
                preg_replace_callback(

                    $patron,

                    static function (
                        array $coincidencia
                    ) use (
                        $tokenEscapado
                    ): string {

                        $apertura =
                            $coincidencia[1];

                        $contenido =
                            $coincidencia[2];

                        $cierre =
                            $coincidencia[3];


                        /*
                        |--------------------------------------------------------------------------
                        | Verificar si ya existe csrf_token
                        |--------------------------------------------------------------------------
                        */

                        $yaTieneToken =
                            preg_match(
                                '~'
                                . '\bname\s*=\s*'
                                . '(?:"csrf_token"'
                                . '|\'csrf_token\''
                                . '|csrf_token)'
                                . '(?:\s|/?>)'
                                . '~i',
                                $contenido
                            ) === 1;


                        /*
                        |--------------------------------------------------------------------------
                        | Si ya existe, no duplicarlo
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $yaTieneToken
                        ) {
                            return
                                $apertura
                                . $contenido
                                . $cierre;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Campo oculto
                        |--------------------------------------------------------------------------
                        */

                        $campo =
                            "\n"
                            . '<input'
                            . ' type="hidden"'
                            . ' name="csrf_token"'
                            . ' value="'
                            . $tokenEscapado
                            . '">'
                            . "\n";


                        return
                            $apertura
                            . $campo
                            . $contenido
                            . $cierre;
                    },

                    $buffer
                );


            return
                is_string(
                    $resultado
                )
                    ? $resultado
                    : $buffer;
        }
    );
}