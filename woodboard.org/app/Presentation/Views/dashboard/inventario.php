<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard de Inventario
    </title>


    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    <style>
    :root {
        --azul-oscuro:#18253a; --azul:#315b88; --azul-suave:#eaf0f6;
        --verde:#28786a; --rojo:#b85b5b; --fondo:#f4f6f8;
        --blanco:#fff; --texto:#1e293b; --texto-secundario:#64748b;
        --borde:#e2e8f0; --radio:10px;
    }
    * { box-sizing:border-box; }
    body { margin:0; font-family:"Segoe UI",Arial,Helvetica,sans-serif; background:var(--fondo); color:var(--texto); -webkit-font-smoothing:antialiased; }
    header { min-height:76px; padding:0 40px; display:flex; align-items:center; justify-content:space-between; gap:20px; background:#fff; border-top:4px solid var(--azul-oscuro); border-bottom:1px solid var(--borde); position:sticky; top:0; z-index:100; }
    .header-titulo { display:flex; flex-direction:column; gap:3px; }
    .header-titulo strong { color:var(--azul-oscuro); font-size:18px; font-weight:700; letter-spacing:-.2px; }
    .header-titulo span { font-size:12px; color:var(--texto-secundario); }
    .header-enlaces { display:flex; align-items:center; gap:10px; }
    .header-enlaces a { display:inline-flex; align-items:center; justify-content:center; color:var(--azul-oscuro); background:#fff; padding:9px 15px; border:1px solid #cbd5e1; border-radius:7px; text-decoration:none; font-size:12px; font-weight:600; transition:background .18s,color .18s,border-color .18s; }
    .header-enlaces a:hover { background:var(--azul-oscuro); color:#fff; border-color:var(--azul-oscuro); }
    .header-enlaces a:focus-visible, .filtros button:focus-visible, .campo input:focus-visible { outline:3px solid #8fb4dc; outline-offset:2px; }
    main { width:100%; max-width:1320px; margin:auto; padding:38px 32px 60px; }
    .titulo { margin-bottom:28px; }
    .titulo h1 { margin:0 0 7px; font-size:27px; font-weight:700; color:var(--azul-oscuro); letter-spacing:-.5px; }
    .titulo p { margin:0; color:var(--texto-secundario); font-size:13px; line-height:1.6; }
    .filtros { background:#fff; padding:22px; border:1px solid var(--borde); border-radius:var(--radio); margin-bottom:25px; box-shadow:0 1px 2px rgba(15,23,42,.03); }
    .filtros form { display:flex; gap:15px; align-items:end; flex-wrap:wrap; }
    .campo { flex:1; min-width:180px; }
    .campo label { display:block; margin-bottom:8px; color:#344054; font-size:12px; font-weight:650; }
    .campo input { width:100%; height:42px; padding:0 12px; border:1px solid #cbd5e1; border-radius:7px; background:#fff; color:var(--texto); font:13px "Segoe UI",Arial,sans-serif; }
    .campo input:focus { border-color:var(--azul); outline:none; box-shadow:0 0 0 3px rgba(49,91,136,.1); }
    .filtros button { height:42px; padding:0 19px; background:var(--azul-oscuro); border:0; border-radius:7px; color:#fff; font-size:12px; font-weight:600; cursor:pointer; transition:background .18s; }
    .filtros button:hover { background:var(--azul); }
    .sin-filtros,.error { padding:14px 17px; border-radius:8px; margin-bottom:22px; font-size:13px; line-height:1.5; }
    .sin-filtros { background:#fff; color:#5f6b7a; border:1px solid var(--borde); }
    .error { background:#fdeeee; color:#a33131; border:1px solid #f0cccc; }
    .indicadores { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:17px; margin-bottom:30px; }
    .tarjeta { position:relative; overflow:hidden; background:#fff; border:1px solid var(--borde); border-radius:var(--radio); padding:21px; min-height:122px; box-shadow:0 1px 2px rgba(15,23,42,.03); transition:transform .18s,box-shadow .18s,border-color .18s; }
    .tarjeta::before { content:""; position:absolute; top:0; left:0; width:100%; height:3px; background:var(--azul); }
    .tarjeta:nth-child(3n+2)::before { background:var(--verde); }
    .tarjeta:nth-child(3n+3)::before { background:#bd8040; }
    .tarjeta:hover { transform:translateY(-2px); border-color:#cbd5e1; box-shadow:0 6px 16px rgba(15,23,42,.055); }
    .tarjeta span { display:block; color:var(--texto-secundario); font-size:12px; font-weight:500; margin-bottom:13px; line-height:1.4; }
    .tarjeta strong { display:block; color:var(--azul-oscuro); font-size:clamp(22px,2.3vw,29px); font-weight:700; letter-spacing:-.5px; font-variant-numeric:tabular-nums; overflow-wrap:anywhere; }
    .comparacion { margin-top:9px; color:#7a8494; font-size:11px; line-height:1.5; }
    .seccion { min-width:0; background:#fff; border:1px solid var(--borde); border-radius:var(--radio); padding:25px; margin-bottom:28px; box-shadow:0 1px 2px rgba(15,23,42,.03); }
    .seccion h2 { margin:0 0 21px; color:var(--azul-oscuro); font-size:18px; font-weight:700; letter-spacing:-.2px; }
    .canvas { position:relative; width:100%; height:340px; min-width:0; }
    .canvas canvas { max-width:100%; }
    .tabla-contenedor { width:100%; overflow-x:auto; border:1px solid var(--borde); border-radius:8px; }
    table { width:100%; min-width:700px; border-collapse:collapse; }
    th,td { padding:13px 15px; text-align:left; border-bottom:1px solid #edf0f4; vertical-align:middle; font-size:12.5px; }
    th { background:#f8fafc; color:#4b5565; font-size:11.5px; font-weight:700; white-space:nowrap; }
    td { color:#394457; }
    tbody tr:last-child td { border-bottom:0; }
    tbody tr:hover { background:#fafbfd; }
    .sin-datos { padding:25px!important; color:#7a8494; text-align:center; }
    .entrada,.salida { display:inline-block; padding:5px 9px; border-radius:5px; font-size:10.5px; font-weight:700; letter-spacing:.2px; }
    .entrada { color:#28786a; background:#eaf5f1; }
    .salida { color:#a44d4d; background:#fbefef; }
    @media(max-width:900px) { header{padding:0 24px;} main{padding:30px 22px 50px;} }
    @media(max-width:700px) {
        header{min-height:68px;padding:10px 16px;gap:12px;}
        .header-titulo strong{font-size:15px;} .header-titulo span{font-size:10.5px;}
        .header-enlaces{gap:6px;} .header-enlaces a{padding:7px 9px;font-size:10.5px;}
        main{padding:24px 14px 40px;} .titulo h1{font-size:23px;}
        .filtros{padding:18px;} .filtros form{flex-direction:column;align-items:stretch;}
        .campo{width:100%;} .filtros button{width:100%;}
        .indicadores{grid-template-columns:repeat(2,minmax(0,1fr));gap:11px;margin-bottom:25px;}
        .tarjeta{min-height:105px;padding:16px;} .tarjeta strong{font-size:21px;}
        .seccion{padding:18px;margin-bottom:22px;} .seccion h2{font-size:16px;}
        .canvas{height:280px;}
    }
    @media(max-width:400px) { .indicadores{grid-template-columns:1fr;} }
    @media(prefers-reduced-motion:reduce) { .tarjeta,.header-enlaces a{transition:none;} }
</style>

</head>


<body>


<header>


    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Dashboard de inventario
        </span>

    </div>


    <div class="header-enlaces">

        <a href="dashboard.php">
            Dashboard general
        </a>

        <a href="panel.php">
            Panel
        </a>

    </div>


</header>



<main>


    <!-- =========================================================
         TÍTULO
         ========================================================= -->

    <div class="titulo">

        <h1>
            Indicadores de inventario
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

    </div>



    <!-- =========================================================
         ERROR
         ========================================================= -->

    <?php if ($error !== null): ?>

        <div class="error">

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

    <?php if ($puedeAplicarFiltros): ?>


        <section class="filtros">


            <form method="GET">


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



                <button type="submit">
                    Aplicar filtro
                </button>


            </form>


        </section>


    <?php else: ?>


        <div class="sin-filtros">

            Su rol permite consultar indicadores,
            pero no modificar el período de consulta.

        </div>


    <?php endif; ?>



    <!-- =========================================================
         INDICADORES
         ========================================================= -->

    <section class="indicadores">


        <div class="tarjeta">

            <span>
                Artículos activos
            </span>

            <strong>

                <?= number_format(
                    $resumen[
                        'articulos_activos'
                    ]
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Movimientos del período
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
                        'articulos_con_movimiento'
                    ]
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Movimientos período anterior
            </span>

            <strong>

                <?= number_format(
                    $resumen[
                        'movimientos_anterior'
                    ]
                ) ?>

            </strong>


            <div class="comparacion">

                <?= htmlspecialchars(
                    date(
                        'd/m/Y',
                        strtotime(
                            $periodoAnterior[
                                'fecha_inicio'
                            ]
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
                            $periodoAnterior[
                                'fecha_fin'
                            ]
                        )
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>

        </div>



        <div class="tarjeta">

            <span>
                Variación de movimientos
            </span>

            <strong>

                <?= $resumen[
                    'variacion'
                ] > 0
                    ? '+'
                    : '' ?>

                <?= number_format(
                    $resumen[
                        'variacion'
                    ],
                    1
                ) ?>%

            </strong>


            <div class="comparacion">
                Respecto al período anterior
            </div>

        </div>


    </section>



    <!-- =========================================================
         GRÁFICA
         ========================================================= -->

    <section class="seccion">

        <h2>
            Movimientos por día
        </h2>


        <div class="canvas">

            <canvas
                id="graficaMovimientos"
            ></canvas>

        </div>

    </section>



    <!-- =========================================================
         EXISTENCIAS
         ========================================================= -->

    <section class="seccion">

        <h2>
            Existencias actuales
        </h2>


        <div class="tabla-contenedor">


            <table>


                <thead>

                    <tr>

                        <th>
                            Artículo
                        </th>

                        <th>
                            Categoría
                        </th>

                        <th>
                            Existencia
                        </th>

                        <th>
                            Unidad
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    count(
                        $existencias
                    ) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="4"
                            class="sin-datos"
                        >
                            No existen artículos activos.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $existencias
                        as $articulo
                    ): ?>


                        <tr>


                            <td>

                                <?= htmlspecialchars(
                                    $articulo[
                                        'nombre_item'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $articulo[
                                        'categoria'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= number_format(
                                    (int)
                                    $articulo[
                                        'cantidad_disponible'
                                    ]
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $articulo[
                                        'unidad_medida'
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


    </section>



    <!-- =========================================================
         ÚLTIMOS MOVIMIENTOS
         ========================================================= -->

    <section class="seccion">

        <h2>
            Últimos movimientos del período
        </h2>


        <div class="tabla-contenedor">


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
                        $ultimosMovimientos
                    ) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="6"
                            class="sin-datos"
                        >
                            No existen movimientos
                            en este período.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $ultimosMovimientos
                        as $movimiento
                    ): ?>


                        <tr>


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


                                <?php if (
                                    $movimiento[
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
                                    $movimiento[
                                        'cantidad'
                                    ]
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


    </section>


</main>



<script>
    // Los datos y sus consultas PHP se conservan sin modificaciones.
    const etiquetas = <?= json_encode($grafica['etiquetas'], JSON_UNESCAPED_UNICODE) ?>;
    const entradas = <?= json_encode($grafica['entradas']) ?>;
    const salidas = <?= json_encode($grafica['salidas']) ?>;

    const lienzoMovimientos = document.getElementById('graficaMovimientos');
    if (lienzoMovimientos && typeof Chart !== 'undefined') {
        const contexto = lienzoMovimientos.getContext('2d');
        const gradienteEntradas = contexto.createLinearGradient(0, 0, 0, 350);
        gradienteEntradas.addColorStop(0, '#45a18a');
        gradienteEntradas.addColorStop(1, '#28786a');
        const gradienteSalidas = contexto.createLinearGradient(0, 0, 0, 350);
        gradienteSalidas.addColorStop(0, '#d88989');
        gradienteSalidas.addColorStop(1, '#b85b5b');

        new Chart(lienzoMovimientos, {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [
                    {
                        label: 'Entradas', data: entradas,
                        backgroundColor: gradienteEntradas,
                        hoverBackgroundColor: '#206b5c',
                        borderRadius: 8, borderSkipped: false,
                        maxBarThickness: 30, categoryPercentage: 0.72, barPercentage: 0.84
                    },
                    {
                        label: 'Salidas', data: salidas,
                        backgroundColor: gradienteSalidas,
                        hoverBackgroundColor: '#a44d4d',
                        borderRadius: 8, borderSkipped: false,
                        maxBarThickness: 30, categoryPercentage: 0.72, barPercentage: 0.84
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                animation: { duration: 800, easing: 'easeOutQuart' },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#64748b', usePointStyle: true, pointStyle: 'circle', boxWidth: 9, padding: 20, font: { family: 'Segoe UI', size: 11 } }
                    },
                    tooltip: {
                        backgroundColor: '#ffffff', titleColor: '#18253a', bodyColor: '#475569',
                        borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 9,
                        padding: 12, displayColors: true, boxPadding: 4,
                        titleFont: { family: 'Segoe UI', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Segoe UI', size: 12 },
                        callbacks: {
                            label(context) {
                                return ' ' + context.dataset.label + ': ' + Number(context.parsed.y ?? 0).toLocaleString('es-GT');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }, border: { display: false },
                        ticks: { color: '#64748b', maxRotation: 45, autoSkip: true, font: { family: 'Segoe UI', size: 11 } }
                    },
                    y: {
                        beginAtZero: true, grid: { color: '#edf2f7' }, border: { display: false, dash: [3, 4] },
                        ticks: { precision: 0, color: '#64748b', padding: 8, font: { family: 'Segoe UI', size: 11 } }
                    }
                }
            }
        });
    }
</script>


</body>

</html>