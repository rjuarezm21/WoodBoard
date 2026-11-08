<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Iniciar sesión | Sistema de Indicadores
    </title>

    <style>

        /* WoodBoard | Identidad visual unificada */
        :root {
            --azul-oscuro: #18253a;
            --azul: #315b88;
            --fondo: #f4f6f8;
            --blanco: #ffffff;
            --texto: #1e293b;
            --secundario: #64748b;
            --borde: #e2e8f0;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 32px 18px;
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
            -webkit-font-smoothing: antialiased;
        }
        .login-container {
            width: 100%;
            max-width: 430px;
            padding: 37px 36px 35px;
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-top: 4px solid var(--azul-oscuro);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        }
        .login-container h1 {
            margin: 0 0 7px;
            text-align: center;
            color: var(--azul-oscuro);
            font-size: 22px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -.35px;
        }
        .subtitulo {
            margin: 0 0 30px;
            color: var(--secundario);
            font-size: 13px;
            line-height: 1.6;
            text-align: center;
        }
        .grupo { margin-bottom: 21px; }
        label {
            display: block;
            margin-bottom: 9px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }
        input {
            display: block;
            width: 100%;
            height: 45px;
            padding: 0 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            color: var(--texto);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        input:hover { border-color: #aab9cb; }
        input:focus {
            border-color: var(--azul);
            box-shadow: 0 0 0 3px rgba(49, 91, 136, .10);
        }
        .password-box { position: relative; }
        .password-box input { padding-right: 52px; }
        .mostrar-password {
            position: absolute;
            top: 50%;
            right: 7px;
            transform: translateY(-50%);
            display: flex;
            justify-content: center;
            align-items: center;
            width: 35px;
            height: 35px;
            padding: 0;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: var(--secundario);
            cursor: pointer;
            transition: background .18s, color .18s;
        }
        .mostrar-password:hover { background: #f1f5f9; color: var(--azul-oscuro); }
        .mostrar-password svg {
            width: 19px;
            height: 19px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none;
        }
        .btn-login {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 45px;
            margin-top: 29px;
            padding: 11px 18px;
            border: 1px solid var(--azul-oscuro);
            border-radius: 8px;
            background: var(--azul-oscuro);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s, border-color .18s;
        }
        .btn-login:hover { background: #29415e; border-color: #29415e; }
        .error, .exito {
            padding: 13px 15px;
            border: 1px solid;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.6;
        }
        .error {
            margin-bottom: 22px;
            border-color: #f0cccc;
            background: #fff1f1;
            color: #a33131;
        }
        .exito {
            border-color: #cee9d8;
            background: #eaf7ef;
            color: #207248;
            text-align: center;
        }
        .btn-login:focus-visible, .mostrar-password:focus-visible {
            outline: 3px solid #9fc0df;
            outline-offset: 3px;
        }
        @media (max-width: 500px) {
            body { padding: 20px 14px; }
            .login-container { padding: 31px 22px 29px; }
            .login-container h1 { font-size: 20px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; }
        }
    </style>

</head>


<body>


<div class="login-container">


    <h1>
        Sistema de Indicadores
    </h1>


    <p class="subtitulo">
        Inicio de sesión
    </p>



    <?php if ($sesionIniciada): ?>


        <div class="exito">

            Sesión iniciada correctamente.

            <br><br>

            Bienvenido,

            <strong>

                <?= htmlspecialchars(
                    $nombreUsuario,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </strong>

        </div>


    <?php else: ?>


        <?php if ($error !== null): ?>


            <div class="error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>


        <?php endif; ?>



        <form
            method="POST"
            action=""
        >


            <!-- =====================================================
                 CORREO
                 ===================================================== -->

            <div class="grupo">

                <label for="correo">
                    Correo electrónico
                </label>


                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['correo']
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                    autocomplete="username"
                >

            </div>



            <!-- =====================================================
                 CONTRASEÑA
                 ===================================================== -->

            <div class="grupo">

                <label for="contrasena">
                    Contraseña
                </label>


                <div class="password-box">


                    <input
                        type="password"
                        id="contrasena"
                        name="contrasena"
                        required
                        autocomplete="current-password"
                    >



                    <button
                        type="button"
                        class="mostrar-password"
                        id="mostrarPassword"
                        aria-label="Mostrar contraseña"
                        title="Mostrar contraseña"
                    >


                        <!-- OJO NORMAL -->

                        <svg
                            id="iconoMostrar"
                            viewBox="0 0 24 24"
                        >

                            <path
                                d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"
                            ></path>

                            <circle
                                cx="12"
                                cy="12"
                                r="3"
                            ></circle>

                        </svg>



                        <!-- OJO TACHADO -->

                        <svg
                            id="iconoOcultar"
                            viewBox="0 0 24 24"
                            style="display:none;"
                        >

                            <path
                                d="M3 3l18 18"
                            ></path>

                            <path
                                d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
                            ></path>

                            <path
                                d="M9.9 4.2A10.7 10.7 0 0 1 12 4c6.5 0 10 8 10 8a17.7 17.7 0 0 1-2.1 3.2"
                            ></path>

                            <path
                                d="M6.6 6.6C3.7 8.5 2 12 2 12s3.5 8 10 8a9.8 9.8 0 0 0 4.2-.9"
                            ></path>

                        </svg>


                    </button>


                </div>

            </div>



            <!-- =====================================================
                 INICIAR SESIÓN
                 ===================================================== -->

            <button
                type="submit"
                class="btn-login"
            >
                Iniciar sesión
            </button>


        </form>


    <?php endif; ?>


</div>



<!-- =============================================================
     MOSTRAR / OCULTAR CONTRASEÑA
     ============================================================= -->

<script>

    const contrasena =
        document.getElementById(
            'contrasena'
        );


    const mostrarPassword =
        document.getElementById(
            'mostrarPassword'
        );


    const iconoMostrar =
        document.getElementById(
            'iconoMostrar'
        );


    const iconoOcultar =
        document.getElementById(
            'iconoOcultar'
        );


    if (
        contrasena
        && mostrarPassword
        && iconoMostrar
        && iconoOcultar
    ) {


        mostrarPassword.addEventListener(
            'click',
            function () {


                const estaOculta =
                    contrasena.type
                    === 'password';


                if (estaOculta) {


                    contrasena.type =
                        'text';


                    iconoMostrar.style.display =
                        'none';


                    iconoOcultar.style.display =
                        'block';


                    mostrarPassword.setAttribute(
                        'aria-label',
                        'Ocultar contraseña'
                    );


                    mostrarPassword.setAttribute(
                        'title',
                        'Ocultar contraseña'
                    );


                } else {


                    contrasena.type =
                        'password';


                    iconoMostrar.style.display =
                        'block';


                    iconoOcultar.style.display =
                        'none';


                    mostrarPassword.setAttribute(
                        'aria-label',
                        'Mostrar contraseña'
                    );


                    mostrarPassword.setAttribute(
                        'title',
                        'Mostrar contraseña'
                    );


                }


            }
        );


    }

</script>


</body>

</html>