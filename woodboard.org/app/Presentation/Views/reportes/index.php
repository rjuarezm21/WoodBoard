<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars(
            $titulo,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </title>


    <style>
    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;
        --verde: #28786a;
        --naranja: #bd8040;
        --fondo: #f4f6f8;
        --blanco: #ffffff;
        --texto: #1e293b;
        --texto-secundario: #64748b;
        --borde: #e2e8f0;
        --radio: 10px;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: "Segoe UI", Arial, Helvetica, sans-serif;
        background: var(--fondo);
        color: var(--texto);
        -webkit-font-smoothing: antialiased;
    }
    /* ENCABEZADO */
    header {
        min-height: 76px;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        background: var(--blanco);
        border-top: 4px solid var(--azul-oscuro);
        border-bottom: 1px solid var(--borde);
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .header-titulo { display: flex; flex-direction: column; gap: 3px; }
    .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
    .header-titulo span { font-size: 12px; color: var(--texto-secundario); }
    .header-enlaces { display: flex; align-items: center; gap: 10px; }
    .header-enlaces a {
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; white-space: nowrap;
        color: var(--azul-oscuro); background: var(--blanco);
        border: 1px solid #cbd5e1; border-radius: 7px;
        padding: 9px 15px; font-size: 12px; font-weight: 600;
        transition: color .18s, background .18s, border-color .18s;
    }
    .header-enlaces a:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
    main { width: 100%; max-width: 1320px; margin: 0 auto; padding: 38px 32px 60px; }
    /* TÍTULO DEL REPORTE */
    .encabezado-reporte { margin-bottom: 28px; }
    .encabezado-reporte h1 { margin: 0 0 7px; font-size: 27px; font-weight: 700; letter-spacing: -.5px; color: var(--azul-oscuro); }
    .encabezado-reporte p { margin: 0; color: var(--texto-secundario); font-size: 13px; line-height: 1.6; }
    /* FILTROS Y CONTROLES */
    .filtros {
        padding: 23px 24px; margin-bottom: 23px;
        border: 1px solid var(--borde); border-radius: var(--radio);
        background: white; box-shadow: 0 1px 2px rgba(15,23,42,.03);
    }
    .filtros form { display: flex; gap: 15px; align-items: end; flex-wrap: wrap; }
    .campo { flex: 1; min-width: 180px; }
    .campo label { display: block; margin-bottom: 8px; color: #344054; font-size: 12px; font-weight: 650; }
    .campo input, .campo select {
        width: 100%; height: 43px; padding: 0 12px;
        background: #fff; color: var(--texto);
        border: 1px solid #cfd8e3; border-radius: 7px;
        font-size: 13px; font-family: inherit; outline: none;
        transition: border-color .18s, box-shadow .18s;
    }
    .campo input:focus, .campo select:focus {
        border-color: var(--azul);
        box-shadow: 0 0 0 3px rgba(49,91,136,.12);
    }
    .acciones { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    button {
        height: 43px; padding: 0 18px;
        border: 1px solid transparent; border-radius: 7px;
        cursor: pointer; font-size: 12px; font-weight: 650;
        font-family: inherit; transition: background .18s, border-color .18s;
    }
    .boton-generar { color: white; background: var(--azul-oscuro); }
    .boton-generar:hover { background: #2b405b; }
    .boton-imprimir { color: var(--azul-oscuro); background: #f8fafc; border-color: #cbd5e1; }
    .boton-imprimir:hover { background: #eaf0f6; border-color: #aebdd0; }
    a:focus-visible, button:focus-visible { outline: 3px solid #a5c3e1; outline-offset: 2px; }
    .sin-filtros, .error {
        padding: 13px 16px; margin-bottom: 22px;
        border-radius: 8px; font-size: 13px; line-height: 1.55;
    }
    .sin-filtros { color: #526174; background: #fff; border: 1px solid var(--borde); }
    .error { color: #9e3030; background: #fff0f0; border: 1px solid #efc9c9; }
    /* RESUMEN */
    .resumen {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(190px,1fr));
        gap: 17px; margin-bottom: 25px;
    }
    .tarjeta {
        position: relative; min-height: 118px; padding: 22px;
        overflow: hidden; background: white;
        border: 1px solid var(--borde); border-radius: var(--radio);
        box-shadow: 0 1px 2px rgba(15,23,42,.03);
        transition: transform .18s, box-shadow .18s, border-color .18s;
    }
    .tarjeta::before {
        content: ""; position: absolute; top: 0; left: 0;
        width: 100%; height: 3px; background: var(--azul);
    }
    .tarjeta:nth-child(3n + 2)::before { background: var(--verde); }
    .tarjeta:nth-child(3n + 3)::before { background: var(--naranja); }
    .tarjeta:hover { transform: translateY(-2px); border-color: #cbd5e1; box-shadow: 0 6px 16px rgba(15,23,42,.055); }
    .tarjeta span { display: block; margin-bottom: 14px; color: var(--texto-secundario); font-size: 12px; font-weight: 500; line-height: 1.4; }
    .tarjeta strong { display: block; color: var(--azul-oscuro); font-size: clamp(22px,2.3vw,29px); font-weight: 700; letter-spacing: -.5px; overflow-wrap: anywhere; font-variant-numeric: tabular-nums; }
    /* TABLAS */
    .tabla {
        background: white; border: 1px solid var(--borde);
        border-radius: var(--radio); padding: 22px; margin-bottom: 25px;
        overflow-x: auto; box-shadow: 0 1px 2px rgba(15,23,42,.03);
    }
    table { width: 100%; min-width: 700px; border-collapse: collapse; }
    th, td { padding: 13px 15px; text-align: left; border-bottom: 1px solid #edf1f5; vertical-align: middle; font-size: 12.5px; }
    th { background: #f3f6fa; color: #415169; font-weight: 650; font-size: 11.5px; white-space: nowrap; }
    td { color: #394457; line-height: 1.5; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover { background: #f8fafc; }
    .sin-datos { padding: 25px !important; color: #718096; text-align: center; }
    .entrada, .salida { display: inline-block; font-size: 11px; font-weight: 650; padding: 4px 9px; border-radius: 5px; }
    .entrada { color: #246c50; background: #eaf5f0; }
    .salida { color: #a04444; background: #fff0f0; }
    /* RESPONSIVE */
    @media (max-width: 700px) {
        header { min-height: 68px; padding: 10px 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 11px; }
        .header-enlaces { gap: 6px; }
        .header-enlaces a { padding: 7px 9px; font-size: 11px; }
        main { padding: 24px 14px 40px; }
        .encabezado-reporte h1 { font-size: 23px; }
        .filtros { padding: 18px; }
        .filtros form { flex-direction: column; align-items: stretch; }
        .campo { width: 100%; }
        .acciones { width: 100%; flex-direction: column; }
        .acciones button { width: 100%; }
        .resumen { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 11px; }
        .tarjeta { min-height: 100px; padding: 17px; }
        .tarjeta strong { font-size: 20px; }
        .tabla { padding: 15px; }
    }
    @media (max-width: 400px) { .resumen { grid-template-columns: 1fr; } }
    @media (prefers-reduced-motion: reduce) { .tarjeta, .header-enlaces a, button { transition: none; } }
    /* IMPRESIÓN: CONSERVA TODAS LAS TABLAS Y EL RESUMEN */
    @media print {
        @page { margin: 13mm; }
        body { background: white !important; color: black; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        header, .filtros, .sin-filtros, .no-imprimir { display: none !important; }
        main { max-width: none; padding: 0; margin: 0; }
        .encabezado-reporte { margin-bottom: 20px; }
        .encabezado-reporte h1 { color: black; font-size: 22px; }
        .encabezado-reporte p { color: #333; }
        .resumen { gap: 8px; margin-bottom: 20px; }
        .tarjeta { border: 1px solid #ccc; border-radius: 0; box-shadow: none; min-height: auto; padding: 10px; break-inside: avoid; }
        .tarjeta::before { display: none; }
        .tarjeta span { color: #444; }
        .tarjeta strong { color: black; font-size: 18px; }
        .tabla { border: 0; border-radius: 0; padding: 0; box-shadow: none; overflow: visible; }
        table { min-width: 0; width: 100%; font-size: 11px; }
        th, td { padding: 7px; border-bottom: 1px solid #ccc; }
        th { background: #eee !important; color: black; }
        thead { display: table-header-group; }
        tr { break-inside: avoid; }
        tbody tr:hover { background: transparent; }
        .entrada, .salida { padding: 0; color: black; background: transparent; }
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
            Reportes
        </span>

    </div>


    <div class="header-enlaces">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="panel.php">
            Panel
        </a>

    </div>


</header>



<main>


    <!-- =========================================================
         ENCABEZADO
         ========================================================= -->

    <section class="encabezado-reporte">


        <h1>

            <?= htmlspecialchars(
                $titulo,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </h1>


        <p>

            Período:

            <?= htmlspecialchars(
                date(
                    'd/m/Y',
                    strtotime(
                        $fechaInicio
                    )
                ),
                ENT_QUOTES,
                'UTF-8'
            ) ?>

            al

            <?= htmlspecialchars(
                date(
                    'd/m/Y',
                    strtotime(
                        $fechaFin
                    )
                ),
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </p>


    </section>



    <!-- =========================================================
         ERROR
         ========================================================= -->

    <?php if ($error !== null): ?>


        <div class="error no-imprimir">

            <?= htmlspecialchars(
                $error,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>


    <?php endif; ?>



    <!-- =========================================================
         FILTROS
         ========================================================= -->

    <section class="filtros">


        <form method="GET">


            <div class="campo">

                <label for="tipo">
                    Tipo de reporte
                </label>


                <select
                    id="tipo"
                    name="tipo"
                    required
                >


                    <?php foreach (
                        $tiposPermitidos
                        as $valorTipo =>
                            $nombreTipo
                    ): ?>


                        <option
                            value="<?= htmlspecialchars(
                                $valorTipo,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            <?= $tipo === $valorTipo
                                ? 'selected'
                                : '' ?>
                        >

                            <?= htmlspecialchars(
                                $nombreTipo,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </option>


                    <?php endforeach; ?>


                </select>

            </div>



            <?php if (
                $puedeAplicarFiltros
            ): ?>


                <div class="campo">

                    <label for="fecha_inicio">
                        Fecha inicial
                    </label>


                    <input
                        type="date"
                        id="fecha_inicio"
                        name="fecha_inicio"
                        value="<?= htmlspecialchars(
                            $fechaInicio,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>



                <div class="campo">

                    <label for="fecha_fin">
                        Fecha final
                    </label>


                    <input
                        type="date"
                        id="fecha_fin"
                        name="fecha_fin"
                        value="<?= htmlspecialchars(
                            $fechaFin,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


            <?php endif; ?>



            <div class="acciones">


                <button
                    type="submit"
                    class="boton-generar"
                >
                    Generar reporte
                </button>


                <button
                    type="button"
                    class="boton-imprimir"
                    onclick="window.print()"
                >
                    Imprimir
                </button>


            </div>


        </form>


    </section>



    <?php if (
        !$puedeAplicarFiltros
    ): ?>


        <div class="sin-filtros no-imprimir">

            Su rol puede consultar reportes,
            pero no cambiar el período.
            Se muestra el período predeterminado.

        </div>


    <?php endif; ?>



    <!-- =========================================================
         REPORTE DE VENTAS
         ========================================================= -->

    <?php if (
        $tipo === 'ventas'
    ): ?>


        <section class="resumen">


            <div class="tarjeta">

                <span>
                    Ventas registradas
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'total_registros'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Unidades vendidas
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'unidades'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Monto total
                </span>

                <strong>

                    Q<?= number_format(
                        $resumen[
                            'monto'
                        ],
                        2
                    ) ?>

                </strong>

            </div>


        </section>



        <section class="tabla">


            <table>


                <thead>

                    <tr>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Monto
                        </th>

                        <th>
                            Usuario
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    count(
                        $registros
                    ) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="5"
                            class="sin-datos"
                        >
                            No existen ventas en este período.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $registros
                        as $registro
                    ): ?>


                        <tr>


                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $registro[
                                                'fecha_venta'
                                            ]
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'descripcion'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= number_format(
                                    (int)
                                    $registro[
                                        'cantidad'
                                    ]
                                ) ?>

                            </td>


                            <td>

                                Q<?= number_format(
                                    (float)
                                    $registro[
                                        'monto_total'
                                    ],
                                    2
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'usuario_nombre'
                                    ]
                                    . ' '
                                    . $registro[
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


        </section>


    <?php endif; ?>



    <!-- =========================================================
         REPORTE DE PRODUCCIÓN
         ========================================================= -->

    <?php if (
        $tipo === 'produccion'
    ): ?>


        <section class="resumen">


            <div class="tarjeta">

                <span>
                    Registros
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'total_registros'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Total producido
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'total_producido'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Metas trabajadas
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'metas_trabajadas'
                        ]
                    ) ?>

                </strong>

            </div>


        </section>



        <section class="tabla">


            <table>


                <thead>

                    <tr>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Meta
                        </th>

                        <th>
                            Usuario
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    count(
                        $registros
                    ) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="5"
                            class="sin-datos"
                        >
                            No existe producción en este período.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $registros
                        as $registro
                    ): ?>


                        <tr>


                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $registro[
                                                'fecha'
                                            ]
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'descripcion'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= number_format(
                                    (int)
                                    $registro[
                                        'cantidad_producida'
                                    ]
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'meta_descripcion'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'usuario_nombre'
                                    ]
                                    . ' '
                                    . $registro[
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


        </section>


    <?php endif; ?>



    <!-- =========================================================
         REPORTE DE INVENTARIO
         ========================================================= -->

    <?php if (
        $tipo === 'inventario'
    ): ?>


        <section class="resumen">


            <div class="tarjeta">

                <span>
                    Movimientos
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'total_movimientos'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Entradas
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'entradas'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Salidas
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'salidas'
                        ]
                    ) ?>

                </strong>

            </div>



            <div class="tarjeta">

                <span>
                    Artículos con movimiento
                </span>

                <strong>

                    <?= number_format(
                        $resumen[
                            'articulos'
                        ]
                    ) ?>

                </strong>

            </div>


        </section>



        <section class="tabla">


            <table>


                <thead>

                    <tr>

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
                            Usuario
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    count(
                        $registros
                    ) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="6"
                            class="sin-datos"
                        >
                            No existen movimientos en este período.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $registros
                        as $registro
                    ): ?>


                        <tr>


                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $registro[
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
                                    $registro[
                                        'nombre_item'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>


                                <?php if (
                                    $registro[
                                        'tipo_movimiento'
                                    ]
                                    === 'ENTRADA'
                                ): ?>


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
                                    $registro[
                                        'cantidad'
                                    ]
                                ) ?>

                                <?= htmlspecialchars(
                                    $registro[
                                        'unidad_medida'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'observacion'
                                    ]
                                    ?? 'Sin observación',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $registro[
                                        'usuario_nombre'
                                    ]
                                    . ' '
                                    . $registro[
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


        </section>


    <?php endif; ?>


</main>


</body>

</html>