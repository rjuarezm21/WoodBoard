<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard General
    </title>


    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


<style>

    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;

        --verde: #28786a;
        --verde-suave: #eaf5f1;

        --naranja: #bd8040;
        --naranja-suave: #fff4e8;

        --fondo: #f4f6f8;
        --blanco: #ffffff;

        --texto: #1e293b;
        --texto-secundario: #64748b;

        --borde: #e2e8f0;
        --radio: 10px;
    }


    * {
        box-sizing: border-box;
    }


    body {
        margin: 0;

        font-family:
            "Segoe UI",
            Arial,
            Helvetica,
            sans-serif;

        background: var(--fondo);
        color: var(--texto);

        -webkit-font-smoothing: antialiased;
    }


    /* =========================================================
       HEADER
       ========================================================= */

    header {
        min-height: 76px;

        padding: 0 40px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        background: var(--blanco);

        color: var(--azul-oscuro);

        border-top: 4px solid var(--azul-oscuro);
        border-bottom: 1px solid var(--borde);

        position: sticky;
        top: 0;

        z-index: 100;
    }


    .header-titulo {
        display: flex;
        flex-direction: column;

        gap: 3px;
    }


    .header-titulo strong {
        color: var(--azul-oscuro);

        font-size: 18px;
        font-weight: 700;

        letter-spacing: -0.2px;
    }


    .header-titulo span {
        color: var(--texto-secundario);

        font-size: 12px;
    }


    .volver-panel {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 9px 15px;

        color: var(--azul-oscuro);

        background: var(--blanco);

        border: 1px solid #cbd5e1;
        border-radius: 7px;

        font-size: 12px;
        font-weight: 600;

        text-decoration: none;

        white-space: nowrap;

        transition:
            background 0.18s ease,
            color 0.18s ease,
            border-color 0.18s ease;
    }


    .volver-panel:hover {
        background: var(--azul-oscuro);
        color: white;
        border-color: var(--azul-oscuro);
    }


    /* =========================================================
       CONTENIDO PRINCIPAL
       ========================================================= */

    main {
        width: 100%;
        max-width: 1320px;

        margin: 0 auto;

        padding: 38px 32px 60px;
    }


    /* =========================================================
       TÍTULO
       ========================================================= */

    .titulo {
        margin-bottom: 28px;
    }


    .titulo h1 {
        margin: 0 0 7px;

        color: var(--azul-oscuro);

        font-size: 27px;
        font-weight: 700;

        letter-spacing: -0.5px;
    }


    .titulo p {
        margin: 0;

        color: var(--texto-secundario);

        font-size: 13px;
        line-height: 1.6;
    }


    /* =========================================================
       INDICADORES GENERALES
       ========================================================= */

    .indicadores {
        display: grid;

        grid-template-columns:
            repeat(
                auto-fit,
                minmax(190px, 1fr)
            );

        gap: 17px;

        margin-bottom: 32px;
    }


    .tarjeta {
        position: relative;

        min-height: 125px;

        padding: 22px;

        background: var(--blanco);

        border: 1px solid var(--borde);
        border-radius: var(--radio);

        box-shadow:
            0 1px 2px
            rgba(15, 23, 42, 0.03);

        overflow: hidden;

        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease,
            border-color 0.18s ease;
    }


    .tarjeta:hover {
        transform: translateY(-2px);

        border-color: #cbd5e1;

        box-shadow:
            0 6px 16px
            rgba(15, 23, 42, 0.055);
    }


    /* Detalle de color superior */

    .tarjeta::before {
        content: "";

        position: absolute;

        top: 0;
        left: 0;

        width: 100%;
        height: 3px;

        background: var(--azul);
    }


    /* Colores alternados, discretos */

    .tarjeta:nth-child(3n + 2)::before {
        background: var(--verde);
    }


    .tarjeta:nth-child(3n + 3)::before {
        background: var(--naranja);
    }


    .tarjeta span {
        display: block;

        margin-bottom: 14px;

        color: var(--texto-secundario);

        font-size: 12px;
        font-weight: 500;

        line-height: 1.4;
    }


    .tarjeta strong {
        display: block;

        color: var(--azul-oscuro);

        font-size: clamp(22px, 2.3vw, 29px);
        font-weight: 700;

        letter-spacing: -0.6px;

        overflow-wrap: anywhere;
        font-variant-numeric: tabular-nums;
    }


    /* =========================================================
       GRÁFICAS
       ========================================================= */

    .graficas {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 19px;

        margin-bottom: 32px;
    }


    .grafica {
        min-width: 0;

        padding: 24px;

        background: var(--blanco);

        border: 1px solid var(--borde);
        border-radius: var(--radio);

        box-shadow:
            0 1px 2px
            rgba(15, 23, 42, 0.03);
    }


    .grafica h2 {
        margin: 0 0 6px;

        color: var(--azul-oscuro);

        font-size: 17px;
        font-weight: 650;

        letter-spacing: -0.2px;
    }


    .grafica-descripcion {
        margin: 0 0 23px;

        color: var(--texto-secundario);

        font-size: 12px;

        line-height: 1.5;
    }


    .contenedor-canvas {
        position: relative;

        width: 100%;
        height: 310px;

        min-width: 0;
    }


    .contenedor-canvas canvas {
        max-width: 100%;
    }


    /* =========================================================
       METAS DE PRODUCCIÓN
       ========================================================= */

    .metas {
        padding: 26px;

        background: var(--blanco);

        border: 1px solid var(--borde);
        border-radius: var(--radio);

        box-shadow:
            0 1px 2px
            rgba(15, 23, 42, 0.03);
    }


    .metas-cabecera {
        margin-bottom: 12px;

        padding-bottom: 17px;

        border-bottom: 1px solid var(--borde);
    }


    .metas-cabecera h2 {
        margin: 0 0 6px;

        color: var(--azul-oscuro);

        font-size: 18px;
        font-weight: 700;

        letter-spacing: -0.2px;
    }


    .metas-cabecera p {
        margin: 0;

        color: var(--texto-secundario);

        font-size: 12.5px;

        line-height: 1.5;
    }


    /* =========================================================
       CADA META
       ========================================================= */

    .meta {
        padding: 20px 0;

        border-bottom: 1px solid #edf0f4;
    }


    .meta:last-child {
        border-bottom: 0;

        padding-bottom: 0;
    }


    .meta-superior {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 12px;
    }


    .meta-superior strong {
        color: var(--texto);

        font-size: 13.5px;
        font-weight: 600;

        line-height: 1.5;
    }


    .meta-superior span {
        display: inline-block;

        padding: 5px 10px;

        color: var(--azul);

        background: var(--azul-suave);

        border-radius: 6px;

        font-size: 12px;
        font-weight: 700;

        white-space: nowrap;

        font-variant-numeric: tabular-nums;
    }


    /* =========================================================
       BARRAS DE PROGRESO
       ========================================================= */

    .barra {
        width: 100%;
        height: 9px;

        overflow: hidden;

        background: #e9eef3;

        border-radius: 20px;
    }


    .progreso {
        height: 100%;

        background: var(--azul);

        border-radius: 20px;

        transition: width 0.3s ease;
    }


    .detalle-meta {
        margin-top: 10px;

        color: var(--texto-secundario);

        font-size: 12px;

        line-height: 1.5;
    }


    /* =========================================================
       MENSAJES SIN DATOS
       ========================================================= */

    .sin-datos {
        margin: 12px 0;

        padding: 15px 17px;

        color: var(--texto-secundario);

        background: #f8fafc;

        border: 1px dashed #dbe3eb;
        border-radius: 8px;

        font-size: 13px;

        line-height: 1.6;
    }


    /* =========================================================
       ACCESIBILIDAD
       ========================================================= */

    .volver-panel:focus-visible {
        outline: 3px solid #8fb4dc;
        outline-offset: 3px;
    }


    @media (prefers-reduced-motion: reduce) {

        .tarjeta,
        .volver-panel,
        .progreso {
            transition: none;
        }

    }


    /* =========================================================
       RESPONSIVE: TABLET
       ========================================================= */

    @media (max-width: 900px) {

        header {
            padding: 0 24px;
        }


        main {
            padding: 30px 22px 50px;
        }


        .graficas {
            grid-template-columns: 1fr;
        }


        .contenedor-canvas {
            height: 320px;
        }

    }


    /* =========================================================
       RESPONSIVE: MÓVIL
       ========================================================= */

    @media (max-width: 600px) {

        header {
            min-height: 68px;

            padding: 0 16px;

            gap: 12px;
        }


        .header-titulo strong {
            font-size: 15px;
        }


        .header-titulo span {
            font-size: 10.5px;
        }


        .volver-panel {
            padding: 7px 10px;

            font-size: 10.5px;
        }


        main {
            padding: 24px 14px 40px;
        }


        .titulo {
            margin-bottom: 23px;
        }


        .titulo h1 {
            font-size: 23px;
        }


        .titulo p {
            font-size: 12px;
        }


        .indicadores {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 11px;

            margin-bottom: 25px;
        }


        .tarjeta {
            min-height: 110px;

            padding: 17px;
        }


        .tarjeta span {
            font-size: 11px;

            margin-bottom: 12px;
        }


        .tarjeta strong {
            font-size: 21px;
        }


        .graficas {
            gap: 14px;

            margin-bottom: 25px;
        }


        .grafica {
            padding: 19px 16px;
        }


        .grafica h2 {
            font-size: 15px;
        }


        .grafica-descripcion {
            font-size: 11.5px;

            margin-bottom: 19px;
        }


        .contenedor-canvas {
            height: 265px;
        }


        .metas {
            padding: 20px 17px;
        }


        .metas-cabecera h2 {
            font-size: 16px;
        }


        .meta {
            padding: 18px 0;
        }


        .meta-superior {
            align-items: flex-start;

            flex-direction: column;

            gap: 7px;
        }


        .meta-superior strong {
            font-size: 12.5px;
        }


        .detalle-meta {
            font-size: 11.5px;
        }

    }


    /* =========================================================
       PANTALLAS PEQUEÑAS
       ========================================================= */

    @media (max-width: 390px) {

        .indicadores {
            grid-template-columns: 1fr;
        }


        .tarjeta {
            min-height: 95px;
        }


        .tarjeta strong {
            font-size: 25px;
        }


        .contenedor-canvas {
            height: 245px;
        }

    }

</style>



</head>


<body>


<!-- =========================================================
     HEADER
     ========================================================= -->

<header>


    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Dashboard general
        </span>

    </div>


    <a
        class="volver-panel"
        href="panel.php"
    >
        Volver al panel
    </a>


</header>



<!-- =========================================================
     CONTENIDO
     ========================================================= -->

<main>


    <!-- TÍTULO -->

    <div class="titulo">

        <h1>
            Indicadores generales
        </h1>

        <p>

            Información correspondiente a

            <strong>

                <?= htmlspecialchars(
                    $mesActual,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </strong>

        </p>

    </div>



    <!-- =========================================================
         INDICADORES
         ========================================================= -->

    <section class="indicadores">


        <div class="tarjeta">

            <span>
                Ventas del mes
            </span>

            <strong>

                Q<?= number_format(
                    (float) $resumen['ventas_mes'],
                    2
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Unidades vendidas
            </span>

            <strong>

                <?= number_format(
                    (int) $resumen['unidades_vendidas']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Producción del mes
            </span>

            <strong>

                <?= number_format(
                    (int) $resumen['produccion_mes']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Artículos activos
            </span>

            <strong>

                <?= number_format(
                    (int) $resumen['articulos_activos']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Metas activas
            </span>

            <strong>

                <?= number_format(
                    (int) $resumen['metas_activas']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Metas cumplidas
            </span>

            <strong>

                <?= number_format(
                    (int) $resumen['metas_cumplidas']
                ) ?>

            </strong>

        </div>


    </section>



    <!-- =========================================================
         GRÁFICAS
         ========================================================= -->

    <section class="graficas">


        <!-- VENTAS -->

        <div class="grafica">

            <h2>
                Ventas de los últimos 6 meses
            </h2>

            <p class="grafica-descripcion">
                Comparación mensual del monto total vendido.
            </p>


            <div class="contenedor-canvas">

                <canvas
                    id="graficaVentas"
                ></canvas>

            </div>

        </div>



        <!-- PRODUCCIÓN -->

        <div class="grafica">

            <h2>
                Producción de los últimos 6 meses
            </h2>

            <p class="grafica-descripcion">
                Cantidad total producida por mes.
            </p>


            <div class="contenedor-canvas">

                <canvas
                    id="graficaProduccion"
                ></canvas>

            </div>

        </div>


    </section>



    <!-- =========================================================
         METAS
         ========================================================= -->

    <section class="metas">


        <div class="metas-cabecera">

            <h2>
                Cumplimiento de metas de producción
            </h2>

            <p>
                Avance actual de las metas registradas.
            </p>

        </div>



        <?php if (
            count($metas) === 0
        ): ?>


            <p class="sin-datos">
                No existen metas activas.
            </p>


        <?php else: ?>


            <?php foreach (
                $metas as $meta
            ): ?>


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



                    <div class="detalle-meta">

                        Producido:

                        <?= number_format(
                            $meta['producido']
                        ) ?>

                        /

                        <?= number_format(
                            $meta['objetivo']
                        ) ?>

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



<!-- =========================================================
     GRÁFICAS
     ========================================================= -->

<script>
    /* =========================================================
       WOODBOARD | GRÁFICAS EJECUTIVAS
       Solo presentación visual. Datos originales del servidor.
       ========================================================= */

    const etiquetasVentas = <?= json_encode($ventasGrafica['etiquetas'], JSON_UNESCAPED_UNICODE) ?>;
    const valoresVentas = <?= json_encode($ventasGrafica['valores']) ?>;
    const etiquetasProduccion = <?= json_encode($produccionGrafica['etiquetas'], JSON_UNESCAPED_UNICODE) ?>;
    const valoresProduccion = <?= json_encode($produccionGrafica['valores']) ?>;

    const colores = {
        azul: '#315b88',
        azulIntenso: '#244567',
        verde: '#28786a',
        texto: '#64748b',
        cuadricula: '#edf1f5',
        blanco: '#ffffff'
    };

    const formatoNumero = new Intl.NumberFormat('es-GT', {
        maximumFractionDigits: 0
    });

    const formatoQuetzales = new Intl.NumberFormat('es-GT', {
        style: 'currency',
        currency: 'GTQ',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    function opcionesEjes(formateadorY) {
        return {
            x: {
                border: { display: false },
                grid: { display: false },
                ticks: {
                    color: colores.texto,
                    padding: 12,
                    maxRotation: 0,
                    font: { family: 'Segoe UI, Arial, sans-serif', size: 11, weight: '500' }
                }
            },
            y: {
                beginAtZero: true,
                border: { display: false, dash: [4, 4] },
                grid: { color: colores.cuadricula, drawTicks: false },
                ticks: {
                    color: colores.texto,
                    padding: 12,
                    maxTicksLimit: 6,
                    font: { family: 'Segoe UI, Arial, sans-serif', size: 11 },
                    callback: formateadorY
                }
            }
        };
    }

    function opcionesBase(formateadorTooltip, formateadorEje) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            animation: { duration: 800, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#18253a',
                    titleColor: '#ffffff',
                    bodyColor: '#e5edf5',
                    padding: 13,
                    cornerRadius: 9,
                    displayColors: false,
                    titleFont: { family: 'Segoe UI, Arial, sans-serif', size: 12, weight: '600' },
                    bodyFont: { family: 'Segoe UI, Arial, sans-serif', size: 13, weight: '600' },
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formateadorTooltip(context.parsed.y);
                        }
                    }
                }
            },
            scales: opcionesEjes(formateadorEje)
        };
    }

    /* Gráfica de ventas: curva azul y degradado muy suave */
    const canvasVentas = document.getElementById('graficaVentas');
    if (canvasVentas) {
        const ctxVentas = canvasVentas.getContext('2d');
        const rellenoVentas = ctxVentas.createLinearGradient(0, 0, 0, 310);
        rellenoVentas.addColorStop(0, 'rgba(49, 91, 136, 0.22)');
        rellenoVentas.addColorStop(0.65, 'rgba(49, 91, 136, 0.06)');
        rellenoVentas.addColorStop(1, 'rgba(49, 91, 136, 0)');

        new Chart(ctxVentas, {
            type: 'line',
            data: {
                labels: etiquetasVentas,
                datasets: [{
                    label: 'Ventas',
                    data: valoresVentas,
                    borderColor: colores.azul,
                    backgroundColor: rellenoVentas,
                    borderWidth: 3,
                    tension: 0.38,
                    cubicInterpolationMode: 'default',
                    fill: 'origin',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: colores.blanco,
                    pointBorderColor: colores.azul,
                    pointBorderWidth: 2.5,
                    pointHoverBackgroundColor: colores.azul,
                    pointHoverBorderColor: colores.blanco,
                    pointHoverBorderWidth: 3
                }]
            },
            options: opcionesBase(
                value => formatoQuetzales.format(value),
                value => 'Q ' + formatoNumero.format(value)
            )
        });
    }

    /* Gráfica de producción: columnas verdes, redondeadas y espaciadas */
    const canvasProduccion = document.getElementById('graficaProduccion');
    if (canvasProduccion) {
        const ctxProduccion = canvasProduccion.getContext('2d');
        new Chart(ctxProduccion, {
            type: 'bar',
            data: {
                labels: etiquetasProduccion,
                datasets: [{
                    label: 'Unidades producidas',
                    data: valoresProduccion,
                    backgroundColor: 'rgba(40, 120, 106, 0.82)',
                    hoverBackgroundColor: colores.verde,
                    borderRadius: { topLeft: 7, topRight: 7, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped: 'bottom',
                    maxBarThickness: 42,
                    categoryPercentage: 0.68,
                    barPercentage: 0.8
                }]
            },
            options: opcionesBase(
                value => formatoNumero.format(value) + ' unidades',
                value => formatoNumero.format(value)
            )
        });
    }
</script>


</body>

</html>