<?php

declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| ZONA HORARIA
|--------------------------------------------------------------------------
*/

date_default_timezone_set(
    'America/Guatemala'
);


/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN SEGURA DE SESIÓN
|--------------------------------------------------------------------------
*/

if (
    session_status()
    !== PHP_SESSION_ACTIVE
) {
    $httpsActivo = false;


    /*
    |--------------------------------------------------------------------------
    | Detectar HTTPS
    |--------------------------------------------------------------------------
    */

    if (
        isset($_SERVER['HTTPS'])
        && $_SERVER['HTTPS'] !== ''
        && strtolower(
            (string) $_SERVER['HTTPS']
        ) !== 'off'
    ) {
        $httpsActivo = true;
    }


    if (
        (int) (
            $_SERVER['SERVER_PORT']
            ?? 0
        ) === 443
    ) {
        $httpsActivo = true;
    }


    if (
        isset(
            $_SERVER[
                'HTTP_X_FORWARDED_PROTO'
            ]
        )
        && strtolower(
            (string)
            $_SERVER[
                'HTTP_X_FORWARDED_PROTO'
            ]
        ) === 'https'
    ) {
        $httpsActivo = true;
    }


    /*
    |--------------------------------------------------------------------------
    | Configuración de seguridad
    |--------------------------------------------------------------------------
    */

    ini_set(
        'session.use_strict_mode',
        '1'
    );

    ini_set(
        'session.use_only_cookies',
        '1'
    );


    session_set_cookie_params([
        'lifetime' => 0,

        'path' => '/',

        'secure' =>
            $httpsActivo,

        'httponly' =>
            true,

        'samesite' =>
            'Lax'
    ]);


    session_start();
}


/*
|--------------------------------------------------------------------------
| PROTECCIÓN CSRF GLOBAL
|--------------------------------------------------------------------------
*/

require_once __DIR__
    . '/csrf.php';