<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Registrar usuario | Sistema de Indicadores
    </title>

    <style>
        /* WOODBOARD — Estilo visual unificado con Registrar área */
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
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
            -webkit-font-smoothing: antialiased;
        }
        header {
            min-height: 76px;
            padding: 0 40px;
            background: var(--blanco);
            border-top: 4px solid var(--azul-oscuro);
            border-bottom: 1px solid var(--borde);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .header-titulo { display: flex; flex-direction: column; gap: 3px; min-width: 0; text-align: left; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .volver-header {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            padding: 9px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            color: var(--azul-oscuro);
            background: var(--blanco);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background .18s, color .18s, border-color .18s;
        }
        .volver-header:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
        main { max-width: 760px; margin: 0 auto; padding: 38px 25px 60px; }
        .titulo-pagina { margin-bottom: 23px; }
        .titulo-pagina h1 {
            margin: 0 0 7px;
            color: var(--azul-oscuro);
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.5px;
        }
        .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .contenedor {
            padding: 30px;
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
        }
        .campo { margin-bottom: 23px; }
        label { display: block; margin-bottom: 9px; color: #334155; font-size: 13px; font-weight: 600; }
        input:not([type="hidden"]), select {
            display: block;
            width: 100%;
            height: 45px;
            padding: 11px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: var(--texto);
            background: white;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        input:not([type="hidden"]):hover, select:hover { border-color: #aab9cb; }
        input:not([type="hidden"]):focus, select:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(49,91,136,.10); }
        .ayuda { display: block; margin-top: 7px; color: var(--secundario); font-size: 11px; line-height: 1.5; }
        .password-contenedor { position: relative; }
        .password-contenedor input { padding-right: 53px; }
        .ver-password {
            position: absolute;
            top: 50%;
            right: 7px;
            transform: translateY(-50%);
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: var(--secundario);
            cursor: pointer;
            transition: background .18s, color .18s;
        }
        .ver-password:hover { background: #f1f5f9; color: var(--azul-oscuro); }
        .ver-password svg { width: 19px; height: 19px; pointer-events: none; }
        .error {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #f0cccc;
            border-radius: 8px;
            background: #fff1f1;
            color: #a33131;
            font-size: 13px;
            line-height: 1.5;
        }
        .acciones {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-top: 27px;
            padding-top: 21px;
            border-top: 1px solid #edf2f7;
        }
        .acciones button, .cancelar {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 19px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background .18s, border-color .18s, color .18s;
        }
        .acciones button { border: 1px solid var(--azul-oscuro); background: var(--azul-oscuro); color: white; }
        .acciones button:hover { background: #29415e; border-color: #29415e; }
        .cancelar { border: 1px solid #cbd5e1; background: white; color: #475569; }
        .cancelar:hover { background: #f1f5f9; }
        .acciones button:focus-visible, .cancelar:focus-visible, .volver-header:focus-visible, .ver-password:focus-visible { outline: 3px solid #9fc0df; outline-offset: 3px; }
        @media (max-width: 600px) {
            header { min-height: 68px; padding: 0 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-header { padding: 7px 10px; font-size: 11px; }
            main { padding: 24px 14px 40px; }
            .titulo-pagina h1 { font-size: 23px; }
            .contenedor { padding: 22px 18px; }
            .acciones { flex-direction: column; align-items: stretch; }
            .acciones button, .cancelar { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; }
        }
    </style>

</head>


<body>


<header>

    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Gestión de usuarios
        </span>

    </div>


    <a
        class="volver-header"
        href="usuarios.php"
    >
        Volver
    </a>

</header>



<main>


    <div class="titulo-pagina">

        <h1>
            Registrar usuario
        </h1>

        <p>
            Ingrese la información del nuevo usuario y asigne su rol y área.
        </p>

    </div>



    <div class="contenedor">


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
                 NOMBRE
                 ===================================================== -->

            <div class="campo">

                <label for="nombre">
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['nombre']
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- =====================================================
                 APELLIDO
                 ===================================================== -->

            <div class="campo">

                <label for="apellido">
                    Apellido
                </label>

                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['apellido']
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- =====================================================
                 CORREO
                 ===================================================== -->

            <div class="campo">

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
                >

            </div>



            <!-- =====================================================
                 CONTRASEÑA
                 ===================================================== -->

            <div class="campo">

                <label for="contrasena">
                    Contraseña
                </label>


                <div class="password-contenedor">

                    <input
                        type="password"
                        id="contrasena"
                        name="contrasena"
                        minlength="8"
                        required
                    >


                    <button
                        type="button"
                        class="ver-password"
                        id="verPassword"
                        aria-label="Mostrar contraseña"
                        title="Mostrar contraseña"
                    >

                        <!-- OJO NORMAL -->

                        <svg
                            id="iconoMostrar"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
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
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
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


                <span class="ayuda">
                    La contraseña debe contener al menos 8 caracteres.
                </span>

            </div>



            <!-- =====================================================
                 ROL
                 ===================================================== -->

            <div class="campo">

                <label for="id_rol">
                    Rol
                </label>


                <select
                    id="id_rol"
                    name="id_rol"
                    required
                >

                    <option value="">
                        Seleccione un rol
                    </option>


                    <?php foreach (
                        $roles
                        as $rol
                    ): ?>


                        <?php

                        $idRol =
                            (int)
                            $rol->getIdRol();


                        $rolSeleccionado =
                            (string) (
                                $_POST['id_rol']
                                ?? ''
                            )
                            ===
                            (string) $idRol;

                        ?>


                        <option
                            value="<?= $idRol ?>"
                            <?= $rolSeleccionado
                                ? 'selected'
                                : ''
                            ?>
                        >

                            <?= htmlspecialchars(
                                $rol->getNombreRol(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </option>


                    <?php endforeach; ?>


                </select>

            </div>



            <!-- =====================================================
                 ÁREA
                 ===================================================== -->

            <div class="campo">

                <label for="id_area">
                    Área
                </label>


                <select
                    id="id_area"
                    name="id_area"
                    required
                >

                    <option value="">
                        Seleccione un área
                    </option>


                    <?php foreach (
                        $areas
                        as $area
                    ): ?>


                        <?php

                        $idArea =
                            (int)
                            $area->getIdArea();


                        $areaSeleccionada =
                            (string) (
                                $_POST['id_area']
                                ?? ''
                            )
                            ===
                            (string) $idArea;

                        ?>


                        <option
                            value="<?= $idArea ?>"
                            <?= $areaSeleccionada
                                ? 'selected'
                                : ''
                            ?>
                        >

                            <?= htmlspecialchars(
                                $area->getNombreArea(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </option>


                    <?php endforeach; ?>


                </select>

            </div>



            <!-- =====================================================
                 ACCIONES
                 ===================================================== -->

            <div class="acciones">


                <button type="submit">
                    Registrar usuario
                </button>


                <a
                    class="cancelar"
                    href="usuarios.php"
                >
                    Cancelar
                </a>


            </div>


        </form>


    </div>


</main>



<!-- =============================================================
     MOSTRAR / OCULTAR CONTRASEÑA
     ============================================================= -->

<script>

    const inputPassword =
        document.getElementById(
            'contrasena'
        );


    const botonPassword =
        document.getElementById(
            'verPassword'
        );


    const iconoMostrar =
        document.getElementById(
            'iconoMostrar'
        );


    const iconoOcultar =
        document.getElementById(
            'iconoOcultar'
        );


    botonPassword.addEventListener(
        'click',
        function () {


            const estaOculta =
                inputPassword.type
                === 'password';


            if (estaOculta) {

                inputPassword.type =
                    'text';


                iconoMostrar.style.display =
                    'none';


                iconoOcultar.style.display =
                    'block';


                botonPassword.setAttribute(
                    'aria-label',
                    'Ocultar contraseña'
                );


                botonPassword.setAttribute(
                    'title',
                    'Ocultar contraseña'
                );

            } else {

                inputPassword.type =
                    'password';


                iconoMostrar.style.display =
                    'block';


                iconoOcultar.style.display =
                    'none';


                botonPassword.setAttribute(
                    'aria-label',
                    'Mostrar contraseña'
                );


                botonPassword.setAttribute(
                    'title',
                    'Mostrar contraseña'
                );

            }


        }
    );

</script>


</body>

</html>