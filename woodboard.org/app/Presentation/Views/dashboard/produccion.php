<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard de Producción
    </title>


    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    <style>
:root {
    --azul-oscuro:#18253a; --azul:#315b88; --azul-suave:#eaf0f6;
    --verde:#28786a; --naranja:#bd8040; --rojo:#c65b5b;
    --fondo:#f4f6f8; --blanco:#fff; --texto:#1e293b;
    --texto-secundario:#64748b; --borde:#e2e8f0; --radio:10px;
}
* { box-sizing:border-box; }
body { margin:0; font-family:"Segoe UI",Arial,Helvetica,sans-serif; background:var(--fondo); color:var(--texto); -webkit-font-smoothing:antialiased; }

/* Encabezado coherente con Dashboard general */
header { min-height:76px; padding:0 40px; display:flex; align-items:center; justify-content:space-between; gap:20px; background:#fff; border-top:4px solid var(--azul-oscuro); border-bottom:1px solid var(--borde); position:sticky; top:0; z-index:100; }
.header-titulo { display:flex; flex-direction:column; gap:3px; }
.header-titulo strong { color:var(--azul-oscuro); font-size:18px; font-weight:700; letter-spacing:-.2px; }
.header-titulo span { color:var(--texto-secundario); font-size:12px; }
.header-enlaces { display:flex; align-items:center; gap:10px; }
.header-enlaces a { display:inline-flex; align-items:center; justify-content:center; padding:9px 15px; text-decoration:none; white-space:nowrap; color:var(--azul-oscuro); border:1px solid #cbd5e1; border-radius:7px; font-size:12px; font-weight:600; transition:background .18s,color .18s,border-color .18s; }
.header-enlaces a:hover { color:#fff; background:var(--azul-oscuro); border-color:var(--azul-oscuro); }
.header-enlaces a:focus-visible, .filtros button:focus-visible, .campo input:focus-visible { outline:3px solid #9fc0df; outline-offset:2px; }
main { width:100%; max-width:1320px; margin:0 auto; padding:38px 32px 60px; }
.titulo { margin-bottom:27px; }
.titulo h1 { margin:0 0 7px; color:var(--azul-oscuro); font-size:27px; font-weight:700; letter-spacing:-.5px; }
.titulo p { margin:0; color:var(--texto-secundario); font-size:13px; line-height:1.6; }

/* Filtros */
.filtros { background:#fff; padding:22px; border:1px solid var(--borde); border-radius:var(--radio); margin-bottom:24px; box-shadow:0 1px 2px rgba(15,23,42,.03); }
.filtros form { display:flex; align-items:end; gap:15px; flex-wrap:wrap; }
.campo { flex:1; min-width:180px; }
.campo label { display:block; margin-bottom:8px; color:#344054; font-size:12px; font-weight:650; }
.campo input { width:100%; height:42px; padding:0 12px; color:var(--texto); background:#fff; border:1px solid #cbd5e1; border-radius:7px; font-family:inherit; font-size:13px; outline:none; }
.campo input:focus { border-color:var(--azul); box-shadow:0 0 0 3px rgba(49,91,136,.1); }
.filtros button { height:42px; padding:0 20px; background:var(--azul-oscuro); color:#fff; border:0; border-radius:7px; font-family:inherit; font-size:12px; font-weight:650; cursor:pointer; transition:background .18s; }
.filtros button:hover { background:var(--azul); }
.sin-filtros { margin-bottom:24px; padding:15px 17px; color:var(--texto-secundario); background:#fff; border:1px solid var(--borde); border-left:3px solid var(--azul); border-radius:8px; font-size:13px; }
.error { margin-bottom:20px; padding:14px 16px; background:#fdeeee; color:#a33131; border:1px solid #f0cccc; border-radius:8px; font-size:13px; }

/* Indicadores */
.indicadores { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:17px; margin-bottom:28px; }
.tarjeta { position:relative; min-width:0; background:#fff; border:1px solid var(--borde); border-radius:var(--radio); padding:21px; min-height:119px; overflow:hidden; box-shadow:0 1px 2px rgba(15,23,42,.03); transition:transform .18s,border-color .18s,box-shadow .18s; }
.tarjeta::before { content:""; position:absolute; left:0; top:0; height:3px; width:100%; background:var(--azul); }
.tarjeta:nth-child(3n+2)::before { background:var(--verde); }
.tarjeta:nth-child(3n+3)::before { background:var(--naranja); }
.tarjeta:hover { transform:translateY(-2px); border-color:#cbd5e1; box-shadow:0 7px 18px rgba(15,23,42,.06); }
.tarjeta span { display:block; margin-bottom:13px; color:var(--texto-secundario); font-size:12px; font-weight:500; line-height:1.4; }
.tarjeta strong { display:block; color:var(--azul-oscuro); font-size:clamp(21px,2.3vw,29px); font-weight:700; letter-spacing:-.6px; font-variant-numeric:tabular-nums; overflow-wrap:anywhere; }
.comparacion { margin-top:8px; color:var(--texto-secundario); font-size:11px; line-height:1.5; }

/* Secciones, gráficas y metas */
.seccion { margin-bottom:26px; padding:25px; background:#fff; border:1px solid var(--borde); border-radius:var(--radio); box-shadow:0 1px 2px rgba(15,23,42,.03); }
.seccion h2 { margin:0 0 21px; color:var(--azul-oscuro); font-size:18px; font-weight:700; letter-spacing:-.2px; }
.canvas { position:relative; height:340px; width:100%; min-width:0; }
.canvas canvas { max-width:100%; }
.metas-indicadores { grid-template-columns:repeat(auto-fit,minmax(175px,1fr)); margin-bottom:24px; }
.grafica-metas { width:100%; max-width:465px; margin:0 auto; }
.canvas-metas { height:335px; }
.meta { padding:19px 0; border-bottom:1px solid #edf0f4; }
.meta:last-child { border-bottom:0; padding-bottom:0; }
.meta-superior { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:11px; }
.meta-superior strong { color:#2f394b; font-size:13.5px; font-weight:600; }
.meta-superior span { padding:5px 10px; color:var(--azul); background:var(--azul-suave); border-radius:6px; font-size:12px; font-weight:700; white-space:nowrap; }
.barra { width:100%; height:9px; background:#e9eef3; border-radius:20px; overflow:hidden; }
.progreso { height:100%; background:var(--azul); border-radius:20px; transition:width .3s; }
.meta-detalle { margin-top:10px; color:var(--texto-secundario); font-size:12px; line-height:1.5; }
.sin-datos { text-align:center; font-size:13px; color:var(--texto-secundario); padding:25px 10px; }

@media(max-width:900px) { header{padding:0 24px} main{padding:30px 22px 50px} }
@media(max-width:700px) {
 header{min-height:68px;padding:10px 16px;gap:12px} .header-titulo strong{font-size:15px} .header-titulo span{font-size:10.5px}
 .header-enlaces{gap:6px;flex-wrap:wrap;justify-content:flex-end} .header-enlaces a{padding:7px 9px;font-size:10.5px}
 main{padding:24px 14px 40px} .titulo h1{font-size:23px} .filtros{padding:18px} .filtros form{flex-direction:column;align-items:stretch}
 .campo{width:100%;min-width:0;flex:auto} .filtros button{width:100%}
 .indicadores{grid-template-columns:repeat(2,minmax(0,1fr));gap:11px} .tarjeta{min-height:105px;padding:16px} .tarjeta strong{font-size:21px}
 .seccion{padding:19px 16px} .seccion h2{font-size:16px} .canvas{height:290px} .canvas-metas{height:310px}
 .meta-superior{flex-direction:column;align-items:flex-start;gap:7px}
}
@media(max-width:400px) { .indicadores{grid-template-columns:1fr} .canvas{height:260px} .canvas-metas{height:300px} }
@media(prefers-reduced-motion:reduce) { .tarjeta,.header-enlaces a,.progreso,.filtros button { transition:none; } }
</style>

</head>


<body>


<header>


    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Dashboard de producción
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
            Indicadores de producción
        </h1>

        <p>

            Período:

            <?= htmlspecialchars(
                date(
                    'd/m/Y',
                    strtotime($fechaInicio)
                ),
                ENT_QUOTES,
                'UTF-8'
            ) ?>

            al

            <?= htmlspecialchars(
                date(
                    'd/m/Y',
                    strtotime($fechaFin)
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
                Producción total
            </span>

            <strong>

                <?= number_format(
                    $resumen['total_producido']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Registros de producción
            </span>

            <strong>

                <?= number_format(
                    $resumen['total_registros']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Metas trabajadas
            </span>

            <strong>

                <?= number_format(
                    $resumen['metas_trabajadas']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Promedio diario
            </span>

            <strong>

                <?= number_format(
                    $resumen['promedio_diario'],
                    2
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Período anterior
            </span>

            <strong>

                <?= number_format(
                    $resumen['produccion_anterior']
                ) ?>

            </strong>


            <div class="comparacion">

                <?= htmlspecialchars(
                    date(
                        'd/m/Y',
                        strtotime(
                            $periodoAnterior['fecha_inicio']
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
                            $periodoAnterior['fecha_fin']
                        )
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>

        </div>



        <div class="tarjeta">

            <span>
                Variación
            </span>

            <strong>

                <?= $resumen['variacion'] > 0
                    ? '+'
                    : '' ?>

                <?= number_format(
                    $resumen['variacion'],
                    1
                ) ?>%

            </strong>


            <div class="comparacion">
                Respecto al período anterior
            </div>

        </div>


    </section>



    <!-- =========================================================
         RESUMEN Y GRÁFICA DE METAS
         ========================================================= -->

    <section class="seccion">

        <h2>Resumen de metas</h2>

        <div class="indicadores metas-indicadores">

            <div class="tarjeta">
                <span>Total de metas</span>
                <strong><?= number_format((int) $resumenMetas['total']) ?></strong>
            </div>

            <div class="tarjeta">
                <span>Metas cumplidas</span>
                <strong><?= number_format((int) $resumenMetas['cumplidas']) ?></strong>
            </div>

            <div class="tarjeta">
                <span>En progreso</span>
                <strong><?= number_format((int) $resumenMetas['en_progreso']) ?></strong>
            </div>

            <div class="tarjeta">
                <span>Metas vencidas</span>
                <strong><?= number_format((int) $resumenMetas['vencidas']) ?></strong>
            </div>

            <div class="tarjeta">
                <span>Cumplimiento general</span>
                <strong><?= number_format((float) $resumenMetas['porcentaje_cumplimiento'], 1) ?>%</strong>
            </div>

        </div>

        <?php if ((int) $resumenMetas['total'] > 0): ?>
            <div class="grafica-metas">
                <div class="canvas canvas-metas">
                    <canvas id="graficaMetas"></canvas>
                </div>
            </div>
        <?php else: ?>
            <p class="sin-datos">No hay metas para mostrar en el período seleccionado.</p>
        <?php endif; ?>

    </section>


    <!-- =========================================================
         GRÁFICA
         ========================================================= -->

    <section class="seccion">

        <h2>
            Producción por día
        </h2>


        <div class="canvas">

            <canvas
                id="graficaProduccion"
            ></canvas>

        </div>

    </section>



    <!-- =========================================================
         METAS
         ========================================================= -->

    <section class="seccion">

        <h2>
            Cumplimiento de metas
        </h2>


        <?php if (count($metas) === 0): ?>


            <p>
                No existen metas activas.
            </p>


        <?php else: ?>


            <?php foreach ($metas as $meta): ?>


                <div class="meta">


                    <div class="meta-superior">


                        <strong>

                            <?= htmlspecialchars(
                                $meta['descripcion'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </strong>


                        <span>

                            <?= number_format(
                                $meta['porcentaje'],
                                1
                            ) ?>%

                        </span>


                    </div>



                    <div class="barra">

                        <div
                            class="progreso"
                            style="width: <?= (float) $meta['porcentaje_barra'] ?>%;"
                        ></div>

                    </div>



                    <div class="meta-detalle">

                        <?= number_format(
                            $meta['producido']
                        ) ?>

                        de

                        <?= number_format(
                            $meta['objetivo']
                        ) ?>

                        unidades

                        · Fecha límite:

                        <?= htmlspecialchars(
                            date(
                                'd/m/Y',
                                strtotime(
                                    $meta['fecha_fin']
                                )
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </div>


                </div>


            <?php endforeach; ?>


        <?php endif; ?>


    </section>


</main>



<script>
    // Se conservan los datos suministrados por el servidor y el período filtrado.
    const etiquetas = <?= json_encode($grafica['etiquetas'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const valores = <?= json_encode($grafica['valores'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const resumenMetas = <?= json_encode([
        'cumplidas' => (int) $resumenMetas['cumplidas'],
        'en_progreso' => (int) $resumenMetas['en_progreso'],
        'vencidas' => (int) $resumenMetas['vencidas'],
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    if (typeof Chart !== 'undefined') {
        const paleta = {
            azul: '#315b88', verde: '#28786a', rojo: '#c65b5b',
            tinta: '#18253a', texto: '#64748b', cuadricula: '#edf2f7'
        };
        const formatoEntero = (valor) => Number(valor || 0).toLocaleString('es-GT', { maximumFractionDigits: 0 });
        const tooltipBase = {
            backgroundColor: '#ffffff', titleColor: paleta.tinta,
            bodyColor: '#475569', borderColor: '#e2e8f0', borderWidth: 1,
            cornerRadius: 9, padding: 12, displayColors: true,
            titleFont: { family: 'Segoe UI', size: 12, weight: 'bold' },
            bodyFont: { family: 'Segoe UI', size: 12 }
        };

        const produccionCanvas = document.getElementById('graficaProduccion');
        if (produccionCanvas) {
            new Chart(produccionCanvas, {
                type: 'bar',
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: 'Cantidad producida', data: valores,
                        backgroundColor(context) {
                            const { chart } = context;
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return paleta.verde;
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, '#4a9b84');
                            gradient.addColorStop(1, paleta.verde);
                            return gradient;
                        },
                        hoverBackgroundColor: '#246653', borderRadius: 10,
                        borderSkipped: false, maxBarThickness: 43,
                        categoryPercentage: .72, barPercentage: .82
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    animation: { duration: 700, easing: 'easeOutQuart' },
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: { ...tooltipBase, callbacks: {
                            label(context) { return ' Producción: ' + Number(context.parsed.y || 0).toLocaleString('es-GT'); }
                        }}
                    },
                    scales: {
                        x: {
                            grid: { display: false }, border: { display: false },
                            ticks: { color: paleta.texto, maxRotation: 45, autoSkip: true, font: { size: 11, family: 'Segoe UI' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: paleta.cuadricula }, border: { display: false, dash: [4,4] },
                            ticks: { color: paleta.texto, precision: 0, padding: 8,
                                callback(value) { return formatoEntero(value); }, font: { size: 11, family: 'Segoe UI' } }
                        }
                    }
                }
            });
        }

        const donutCenterLabel = {
            id: 'woodboardProductionDonutCenter',
            afterDatasetsDraw(chart) {
                if (chart.config.type !== 'doughnut' || !chart.getDatasetMeta(0).data.length) return;
                const arc = chart.getDatasetMeta(0).data[0];
                const total = chart.data.datasets[0].data.reduce((sum, value) => sum + Number(value || 0), 0);
                const { ctx } = chart;
                ctx.save();
                ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
                ctx.fillStyle = paleta.tinta;
                ctx.font = '700 25px Segoe UI, Arial, sans-serif';
                ctx.fillText(formatoEntero(total), arc.x, arc.y - 9);
                ctx.fillStyle = paleta.texto;
                ctx.font = '12px Segoe UI, Arial, sans-serif';
                ctx.fillText('Metas', arc.x, arc.y + 16);
                ctx.restore();
            }
        };
        const metasCanvas = document.getElementById('graficaMetas');
        if (metasCanvas) {
            new Chart(metasCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Cumplidas', 'En progreso', 'Vencidas'],
                    datasets: [{
                        data: [resumenMetas.cumplidas, resumenMetas.en_progreso, resumenMetas.vencidas],
                        backgroundColor: [paleta.verde, paleta.azul, paleta.rojo],
                        hoverBackgroundColor: ['#246653', '#274d74', '#ae4d4d'],
                        borderColor: '#ffffff', borderWidth: 3, spacing: 2, hoverOffset: 6
                    }]
                },
                plugins: [donutCenterLabel],
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '72%',
                    animation: { duration: 800 },
                    plugins: {
                        legend: { position: 'bottom', labels: {
                            color: paleta.texto, usePointStyle: true, pointStyle: 'circle',
                            boxWidth: 9, padding: 16, font: { size: 11, family: 'Segoe UI' }
                        }},
                        tooltip: { ...tooltipBase, callbacks: {
                            label(context) { return ' ' + context.label + ': ' + formatoEntero(context.raw); }
                        }}
                    }
                }
            });
        }
    }
</script>


</body>

</html>