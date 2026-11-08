<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Roles y permisos | Sistema de Indicadores
    </title>

    <style>

        /* WoodBoard | diseño ejecutivo unificado con Registrar área */
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
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
            -webkit-font-smoothing: antialiased;
        }
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
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
        .header-titulo { display: flex; flex-direction: column; align-items: flex-start; gap: 3px; text-align: left; min-width: 0; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .volver-panel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            color: var(--azul-oscuro);
            background: var(--blanco);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: background .18s, color .18s, border-color .18s;
        }
        .volver-panel:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
        main { width: 100%; max-width: 1200px; margin: 0 auto; padding: 38px 30px 60px; }
        .titulo-pagina { margin-bottom: 23px; }
        .titulo-pagina h1 {
            margin: 0 0 7px;
            color: var(--azul-oscuro);
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.5px;
        }
        .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .rol {
            background: var(--blanco);
            margin-bottom: 18px;
            padding: 27px 30px;
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
        }
        .rol-encabezado { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 18px; }
        .rol-titulo { min-width: 0; }
        .rol-titulo h2 { margin: 0 0 7px; color: var(--azul-oscuro); font-size: 19px; font-weight: 700; letter-spacing: -.25px; }
        .rol-descripcion { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .estado {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            min-width: 74px;
            padding: 6px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
        }
        .estado-activo { background: #eaf7ef; color: #207248; border: 1px solid #cee9d8; }
        .estado-inactivo { background: #f1f3f6; color: #718096; border: 1px solid #e2e6eb; }
        .permisos { padding-top: 20px; border-top: 1px solid #edf2f7; }
        .permisos h3 { margin: 0 0 14px; color: #334155; font-size: 14px; font-weight: 700; }
        .sin-permisos { margin: 0; color: var(--secundario); font-size: 13px; }
        .lista-permisos { margin: 0; padding-left: 20px; }
        .lista-permisos li { margin-bottom: 9px; color: #526175; font-size: 13px; line-height: 1.6; }
        .lista-permisos li:last-child { margin-bottom: 0; }
        .lista-permisos strong { color: #334155; font-weight: 600; }
        .acciones { margin-top: 23px; padding-top: 20px; border-top: 1px solid #edf2f7; }
        .boton-editar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 10px 19px;
            background: var(--azul-oscuro);
            border: 1px solid var(--azul-oscuro);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            transition: background .18s, border-color .18s;
        }
        .boton-editar:hover { background: #29415e; border-color: #29415e; }
        .sin-roles {
            background: var(--blanco);
            padding: 35px;
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
            text-align: center;
            color: var(--secundario);
            font-size: 13px;
        }
        .volver-panel:focus-visible, .boton-editar:focus-visible { outline: 3px solid #9fc0df; outline-offset: 3px; }
        @media (max-width: 700px) {
            header { min-height: 68px; padding: 0 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-panel { padding: 7px 10px; font-size: 11px; }
            main { padding: 24px 14px 40px; }
            .titulo-pagina h1 { font-size: 23px; }
            .rol { padding: 22px 18px; }
            .rol-encabezado { flex-direction: column; gap: 12px; }
            .estado { align-self: flex-start; }
            .boton-editar { width: 100%; text-align: center; }
        }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition: none !important; } }
    </style>

</head>


<body>


<header>

    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Roles y permisos
        </span>

    </div>


    <a
        class="volver-panel"
        href="panel.php"
    >
        Volver al panel
    </a>

</header>



<main>


    <!-- ENCABEZADO -->

    <div class="titulo-pagina">

        <h1>
            Roles del sistema
        </h1>

        <p>
            Consulta y administración de los roles y permisos asignados.
        </p>

    </div>



    <!-- ROLES -->

    <?php if (count($roles) === 0): ?>


        <div class="sin-roles">
            No hay roles registrados.
        </div>


    <?php else: ?>


        <?php foreach ($roles as $item): ?>


            <?php

                $rol = $item['rol'];

                $permisos = $item['permisos'];

            ?>


            <div class="rol">


                <!-- INFORMACIÓN DEL ROL -->

                <div class="rol-encabezado">


                    <div class="rol-titulo">

                        <h2>

                            <?= htmlspecialchars(
                                $rol->getNombreRol(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </h2>


                        <p class="rol-descripcion">

                            <?= htmlspecialchars(
                                $rol->getDescripcion()
                                ?? 'Sin descripción',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </p>

                    </div>



                    <?php if ($rol->getEstado()): ?>


                        <span class="estado estado-activo">
                            Activo
                        </span>


                    <?php else: ?>


                        <span class="estado estado-inactivo">
                            Inactivo
                        </span>


                    <?php endif; ?>


                </div>



                <!-- PERMISOS -->

                <div class="permisos">


                    <h3>
                        Permisos asignados
                    </h3>


                    <?php if (count($permisos) === 0): ?>


                        <p class="sin-permisos">
                            Este rol no tiene permisos asignados.
                        </p>


                    <?php else: ?>


                        <ul class="lista-permisos">


                            <?php foreach (
                                $permisos
                                as $permiso
                            ): ?>


                                <li>


                                    <strong>

                                        <?= htmlspecialchars(
                                            $permiso
                                                ->getNombrePermiso(),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </strong>


                                    <?php if (
                                        $permiso
                                            ->getDescripcion()
                                        !== null
                                    ): ?>

                                        —

                                        <?= htmlspecialchars(
                                            $permiso
                                                ->getDescripcion(),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    <?php endif; ?>


                                </li>


                            <?php endforeach; ?>


                        </ul>


                    <?php endif; ?>


                </div>



                <!-- ACCIONES -->

                <div class="acciones">

                    <a
                        class="boton-editar"
                        href="rol_editar.php?id=<?= (int) $rol->getIdRol() ?>"
                    >
                        Editar rol y permisos
                    </a>

                </div>


            </div>


        <?php endforeach; ?>


    <?php endif; ?>


</main>


</body>

</html>