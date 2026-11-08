<?php

declare(strict_types=1);

namespace App\Business\Services;

class CsrfService
{
    private const SESSION_KEY =
        'csrf_token';


    /*
    |--------------------------------------------------------------------------
    | Obtener / generar token
    |--------------------------------------------------------------------------
    */

    public function generarToken(): string
    {
        if (
            !isset(
                $_SESSION[
                    self::SESSION_KEY
                ]
            )
            || !is_string(
                $_SESSION[
                    self::SESSION_KEY
                ]
            )
            || strlen(
                $_SESSION[
                    self::SESSION_KEY
                ]
            ) < 64
        ) {
            $_SESSION[
                self::SESSION_KEY
            ] =
                bin2hex(
                    random_bytes(32)
                );
        }


        return
            $_SESSION[
                self::SESSION_KEY
            ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validar token
    |--------------------------------------------------------------------------
    */

    public function validarToken(
        ?string $token
    ): bool {
        if (
            $token === null
            || $token === ''
        ) {
            return false;
        }


        $tokenSesion =
            $_SESSION[
                self::SESSION_KEY
            ]
            ?? null;


        if (
            !is_string(
                $tokenSesion
            )
            || $tokenSesion === ''
        ) {
            return false;
        }


        return hash_equals(
            $tokenSesion,
            $token
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Regenerar token
    |--------------------------------------------------------------------------
    */

    public function regenerarToken(): string
    {
        $_SESSION[
            self::SESSION_KEY
        ] =
            bin2hex(
                random_bytes(32)
            );


        return
            $_SESSION[
                self::SESSION_KEY
            ];
    }
}