<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Movimientos de Inventario | Sistema de Indicadores
    </title>

    <style>

        /* WoodBoard | Identidad visual unificada con Registrar área */
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
        .header-titulo { display: flex; flex-direction: column; gap: 3px; min-width: 0; text-align: left; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .header-enlaces { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin-left: auto; }
        .header-enlaces a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 38px;
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
        .header-enlaces a:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
        main { width: 100%; max-width: 1400px; margin: 0 auto; padding: 38px 30px 60px; }
        .encabezado { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 23px; }
        .titulo-pagina h1 { margin: 0 0 7px; color: var(--azul-oscuro); font-size: 27px; font-weight: 700; letter-spacing: -.5px; }
        .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .boton {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 43px;
            padding: 10px 19px;
            border: 1px solid var(--azul-oscuro);
            border-radius: 8px;
            background: var(--azul-oscuro);
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: background .18s, border-color .18s;
        }
        .boton:hover { background: #29415e; border-color: #29415e; }
        .mensaje { margin-bottom: 22px; padding: 13px 15px; border: 1px solid #cce7d2; border-radius: 8px; background: #edf8f0; color: #276738; font-size: 13px; line-height: 1.5; }
        .contenedor { background: var(--blanco); border: 1px solid var(--borde); border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(15,23,42,.035); }
        .tabla-scroll { width: 100%; overflow-x: auto; }
        table { width: 100%; min-width: 1050px; border-collapse: collapse; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #edf2f7; vertical-align: middle; font-size: 13px; }
        th { background: #f8fafc; color: #475569; font-size: 12px; font-weight: 700; white-space: nowrap; }
        td { color: #334155; }
        td:first-child { width: 65px; color: #64748b; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: 0; }
        .entrada, .salida { display: inline-flex; align-items: center; justify-content: center; padding: 5px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
        .entrada { color: #166534; background: #eaf7ee; border: 1px solid #caead7; }
        .salida { color: #a53c3c; background: #fff0f0; border: 1px solid #f1d2d2; }
        .sin-registros { padding: 35px 15px !important; text-align: center !important; color: var(--secundario); }
        a:focus-visible { outline: 3px solid #9fc0df; outline-offset: 3px; }
        @media (max-width: 700px) {
            header { min-height: 68px; padding: 10px 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .header-enlaces { gap: 6px; justify-content: flex-end; }
            .header-enlaces a { padding: 7px 10px; font-size: 11px; min-height: 34px; }
            main { padding: 24px 14px 40px; }
            .encabezado { flex-direction: column; align-items: stretch; gap: 15px; }
            .titulo-pagina h1 { font-size: 23px; }
            .boton { width: 100%; }
            .contenedor { border-radius: 10px; }
        }
        @media (max-width: 390px) {
            header { align-items: flex-start; }
            .header-enlaces { flex-direction: column; align-items: stretch; }
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
            Movimientos de inventario
        </span>

    </div>


    <div class="header-enlaces">

        <a href="inventario.php">
            Inventario
        </a>

        <a href="panel.php">
            Volver al panel
        </a>

    </div>

</header>



<main>


    <!-- ENCABEZADO -->

    <div class="encabezado">


        <div class="titulo-pagina">

            <h1>
                Historial de movimientos
            </h1>

            <p>
                Consulta de entradas y salidas registradas en el inventario.
            </p>

        </div>



        <?php if ($puedeRegistrar): ?>

            <a
                class="boton"
                href="movimiento_crear.php"
            >
                Registrar movimiento
            </a>

        <?php endif; ?>


    </div>



    <!-- MENSAJE -->

    <?php if (isset($_GET['creado'])): ?>

        <div class="mensaje">
            Movimiento registrado correctamente.
        </div>

    <?php endif; ?>



    <!-- TABLA -->

    <div class="contenedor">


        <div class="tabla-scroll">


            <table>


                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Artículo
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Observación
                        </th>

                        <th>
                            Registrado por
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (count($movimientos) === 0): ?>


                    <tr>

                        <td
                            colspan="7"
                            class="sin-registros"
                        >
                            No hay movimientos registrados.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $movimientos
                        as $movimiento
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $movimiento['id_movimiento']
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $movimiento[
                                                'fecha_movimiento'
                                            ]
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $movimiento[
                                        'nombre_item'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (strtoupper(trim((string) ($movimiento['tipo_movimiento'] ?? ''))) === 'ENTRADA'): ?>


                                    <span class="entrada">
                                        ENTRADA
                                    </span>


                                <?php else: ?>


                                    <span class="salida">
                                        SALIDA
                                    </span>


                                <?php endif; ?>


                            </td>



                            <td>

                                <?= number_format(
                                    (int)
                                    $movimiento['cantidad']
                                ) ?>

                                <?= htmlspecialchars(
                                    $movimiento[
                                        'unidad_medida'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $movimiento[
                                        'observacion'
                                    ]
                                    ?? 'Sin observación',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $movimiento[
                                        'usuario_nombre'
                                    ]
                                    . ' '
                                    . $movimiento[
                                        'usuario_apellido'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                        </tr>


                    <?php endforeach; ?>


                <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>


</main>


</body>

</html>