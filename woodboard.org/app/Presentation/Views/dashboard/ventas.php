<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard de Ventas
    </title>


    <script
        src="https://cdn.jsdelivr.net/npm/chart.js"
    ></script>


    <style>
:root {
  --azul-oscuro:#18253a; --azul:#315b88; --azul-suave:#eaf0f6;
  --verde:#28786a; --ambar:#bd8040; --fondo:#f4f6f8;
  --blanco:#fff; --texto:#1e293b; --secundario:#64748b;
  --borde:#e2e8f0; --radio:10px;
}
* {box-sizing:border-box}
body {margin:0;font-family:"Segoe UI",Arial,Helvetica,sans-serif;background:var(--fondo);color:var(--texto);-webkit-font-smoothing:antialiased}
header {min-height:76px;padding:0 40px;display:flex;align-items:center;justify-content:space-between;gap:20px;background:#fff;border-top:4px solid var(--azul-oscuro);border-bottom:1px solid var(--borde);position:sticky;top:0;z-index:100}
.header-titulo {display:flex;flex-direction:column;gap:3px}
.header-titulo strong {font-size:18px;font-weight:700;color:var(--azul-oscuro);letter-spacing:-.2px}
.header-titulo span {font-size:12px;color:var(--secundario)}
.header-enlaces {display:flex;align-items:center;gap:10px}
.header-enlaces a {padding:9px 15px;color:var(--azul-oscuro);background:white;text-decoration:none;border:1px solid #cbd5e1;border-radius:7px;font-size:12px;font-weight:600;white-space:nowrap;transition:background .18s,color .18s,border-color .18s}
.header-enlaces a:hover {background:var(--azul-oscuro);border-color:var(--azul-oscuro);color:#fff}
.header-enlaces a:focus-visible,.filtros button:focus-visible,.campo input:focus-visible {outline:3px solid #9fc0df;outline-offset:2px}
main {width:100%;max-width:1320px;margin:0 auto;padding:38px 32px 60px}
.titulo {margin-bottom:28px}
.titulo h1 {margin:0 0 7px;color:var(--azul-oscuro);font-size:27px;font-weight:700;letter-spacing:-.5px}
.titulo p {margin:0;color:var(--secundario);font-size:13px;line-height:1.6}
/* Filtros y mensajes */
.filtros {background:white;padding:22px;border:1px solid var(--borde);border-radius:var(--radio);margin-bottom:26px;box-shadow:0 1px 2px rgba(15,23,42,.03)}
.filtros form {display:flex;gap:15px;align-items:end;flex-wrap:wrap}
.campo {flex:1;min-width:180px}
.campo label {display:block;margin-bottom:8px;color:#344054;font-size:12px;font-weight:650}
.campo input {width:100%;height:42px;padding:0 12px;border:1px solid #d5dce6;border-radius:7px;background:white;color:var(--texto);font:inherit;font-size:13px;outline:none}
.campo input:focus {border-color:var(--azul);box-shadow:0 0 0 3px rgba(49,91,136,.09)}
.filtros button {height:42px;padding:0 20px;background:var(--azul-oscuro);color:white;border:0;border-radius:7px;cursor:pointer;font-size:12px;font-weight:650;transition:background .18s}
.filtros button:hover {background:var(--azul)}
.sin-filtros,.error {padding:13px 16px;border:1px solid var(--borde);border-radius:8px;margin-bottom:22px;font-size:13px;line-height:1.5;background:white;color:var(--secundario)}
.error {background:#fff0f0;color:#a33131;border-color:#f0cccc}
/* Resumen de indicadores */
.indicadores {display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:17px;margin-bottom:32px}
.tarjeta {position:relative;min-width:0;min-height:125px;padding:21px 22px;background:white;border:1px solid var(--borde);border-radius:var(--radio);box-shadow:0 1px 2px rgba(15,23,42,.03);overflow:hidden;transition:transform .18s,box-shadow .18s,border-color .18s}
.tarjeta:hover {transform:translateY(-2px);border-color:#cbd5e1;box-shadow:0 6px 16px rgba(15,23,42,.055)}
.tarjeta::before {content:"";position:absolute;top:0;left:0;width:100%;height:3px;background:var(--azul)}
.tarjeta:nth-child(3n + 2)::before {background:var(--verde)}
.tarjeta:nth-child(3n + 3)::before {background:var(--ambar)}
.tarjeta span {display:block;margin-bottom:14px;color:var(--secundario);font-size:12px;font-weight:500;line-height:1.4}
.tarjeta strong {display:block;color:var(--azul-oscuro);font-size:clamp(22px,2.3vw,29px);font-weight:700;letter-spacing:-.6px;overflow-wrap:anywhere;font-variant-numeric:tabular-nums}
.comparacion {margin-top:10px;color:var(--secundario);font-size:11px;line-height:1.45}
/* Gráficas */
.graficas {display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:19px;margin-bottom:32px}
.grafica,.seccion {min-width:0;background:white;padding:24px;border:1px solid var(--borde);border-radius:var(--radio);box-shadow:0 1px 2px rgba(15,23,42,.03)}
.grafica h2,.seccion h2 {margin:0 0 22px;color:var(--azul-oscuro);font-size:17px;font-weight:650;letter-spacing:-.2px}
.canvas {position:relative;width:100%;height:320px;min-width:0}
.canvas canvas {max-width:100%}
/* Tabla de productos */
.seccion {margin-bottom:24px;overflow-x:auto}
.tabla-contenedor {overflow-x:auto;border:1px solid var(--borde);border-radius:8px}
table {width:100%;min-width:650px;border-collapse:collapse}
th,td {padding:13px 15px;text-align:left;border-bottom:1px solid #edf0f4;vertical-align:middle;font-size:12.5px}
th {background:#f8fafc;color:#475569;font-size:11.5px;font-weight:700;white-space:nowrap}
td {color:#394457}
tbody tr:last-child td {border-bottom:0}
tbody tr:hover {background:#f8fafc}
.sin-datos {padding:25px!important;color:var(--secundario);text-align:center}
@media(max-width:900px) {header{padding:0 24px}main{padding:30px 22px 50px}.graficas{grid-template-columns:1fr}.canvas{height:300px}}
@media(max-width:700px) {header{min-height:68px;padding:10px 16px}.header-titulo strong{font-size:15px}.header-titulo span{font-size:10.5px}.header-enlaces{gap:6px}.header-enlaces a{padding:7px 9px;font-size:10.5px}main{padding:24px 14px 40px}.titulo h1{font-size:23px}.filtros{padding:18px}.filtros form{flex-direction:column;align-items:stretch}.campo{width:100%}.filtros button{width:100%}.indicadores{grid-template-columns:repeat(2,minmax(0,1fr));gap:11px}.tarjeta{min-height:108px;padding:17px}.tarjeta strong{font-size:21px}.grafica,.seccion{padding:19px 16px}.grafica h2,.seccion h2{font-size:15px}.canvas{height:270px}}
@media(max-width:400px) {.indicadores{grid-template-columns:1fr}header{flex-wrap:wrap}.header-enlaces{width:100%}}
@media(prefers-reduced-motion:reduce){.tarjeta,.header-enlaces a,.filtros button{transition:none}}
</style>

</head>


<body>


<header>


    <div class="header-titulo">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Dashboard de ventas
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
            Indicadores de ventas
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



    <!-- ERROR -->

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
                Monto vendido
            </span>

            <strong>

                Q<?= number_format(
                    $resumen['monto_total'],
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
                    $resumen['unidades_vendidas']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Ventas registradas
            </span>

            <strong>

                <?= number_format(
                    $resumen['total_ventas']
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Promedio por venta
            </span>

            <strong>

                Q<?= number_format(
                    $resumen['promedio_venta'],
                    2
                ) ?>

            </strong>

        </div>



        <div class="tarjeta">

            <span>
                Ventas período anterior
            </span>

            <strong>

                Q<?= number_format(
                    $resumen['monto_anterior'],
                    2
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
         GRÁFICAS
         ========================================================= -->

    <section class="graficas">


        <div class="grafica">

            <h2>
                Monto vendido por día
            </h2>


            <div class="canvas">

                <canvas
                    id="graficaMonto"
                ></canvas>

            </div>

        </div>



        <div class="grafica">

            <h2>
                Unidades vendidas por día
            </h2>


            <div class="canvas">

                <canvas
                    id="graficaUnidades"
                ></canvas>

            </div>

        </div>


    </section>



    <!-- =========================================================
         PRODUCTOS MÁS VENDIDOS
         ========================================================= -->

    <section class="seccion">

        <h2>
            Productos más vendidos
        </h2>


        <div class="tabla-contenedor">

            <table>


                <thead>

                    <tr>

                        <th>
                            Producto / descripción
                        </th>

                        <th>
                            Unidades vendidas
                        </th>

                        <th>
                            Monto vendido
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    count($productos) === 0
                ): ?>


                    <tr>

                        <td
                            colspan="3"
                            class="sin-datos"
                        >
                            No existen ventas
                            en el período seleccionado.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $productos
                        as $producto
                    ): ?>


                        <tr>


                            <td>

                                <?= htmlspecialchars(
                                    $producto[
                                        'descripcion'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= number_format(
                                    (int)
                                    $producto[
                                        'cantidad_vendida'
                                    ]
                                ) ?>

                            </td>


                            <td>

                                Q<?= number_format(
                                    (float)
                                    $producto[
                                        'monto_vendido'
                                    ],
                                    2
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
/* Datos originales del DashboardService: no se modifican. */
const etiquetas = <?= json_encode($grafica['etiquetas'], JSON_UNESCAPED_UNICODE) ?>;
const montos = <?= json_encode($grafica['montos']) ?>;
const unidades = <?= json_encode($grafica['unidades']) ?>;

const estiloTooltip = {
  backgroundColor:'#fff',titleColor:'#18253a',bodyColor:'#475569',
  borderColor:'#e2e8f0',borderWidth:1,cornerRadius:9,padding:12,
  titleFont:{family:'Segoe UI',size:12,weight:'bold'},
  bodyFont:{family:'Segoe UI',size:12},displayColors:true,boxPadding:5
};
const fuenteEjes = {family:'Segoe UI',size:11};
const formatoEntero = n => Number(n).toLocaleString('es-GT',{maximumFractionDigits:0});
const formatoMoneda = n => 'Q' + Number(n).toLocaleString('es-GT',{minimumFractionDigits:2,maximumFractionDigits:2});
const movimientoReducido = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const baseScales = () => ({
  x:{grid:{display:false},border:{display:false},ticks:{color:'#64748b',font:fuenteEjes,maxRotation:45,autoSkip:true}},
  y:{beginAtZero:true,grid:{color:'#edf2f7'},border:{display:false},ticks:{color:'#64748b',font:fuenteEjes,padding:8}}
});

/* Monto vendido por día: curva azul con sombreado suave. */
const canvasMonto=document.getElementById('graficaMonto');
if(canvasMonto && typeof Chart!=='undefined') {
  const ctx=canvasMonto.getContext('2d');
  const gradiente=ctx.createLinearGradient(0,0,0,320);
  gradiente.addColorStop(0,'rgba(49,91,136,.23)');
  gradiente.addColorStop(1,'rgba(49,91,136,.01)');
  const escalas=baseScales();
  escalas.y.ticks.callback=v=>'Q'+Number(v).toLocaleString('es-GT',{notation:'compact',maximumFractionDigits:1});
  new Chart(canvasMonto,{
    type:'line',
    data:{labels:etiquetas,datasets:[{
      label:'Ventas (Q)',data:montos,borderColor:'#315b88',backgroundColor:gradiente,
      borderWidth:3,tension:.38,cubicInterpolationMode:'default',fill:true,
      pointRadius:etiquetas.length>18?0:2.5,pointHoverRadius:6,
      pointBackgroundColor:'#fff',pointBorderColor:'#315b88',pointBorderWidth:2,
      pointHoverBackgroundColor:'#315b88',pointHoverBorderColor:'#fff',pointHoverBorderWidth:2
    }]},
    options:{responsive:true,maintainAspectRatio:false,
      animation:movimientoReducido?false:{duration:700,easing:'easeOutQuart'},
      interaction:{mode:'index',intersect:false},
      plugins:{legend:{display:false},tooltip:{...estiloTooltip,callbacks:{label:c=>' Ventas: '+formatoMoneda(c.parsed.y)}}},
      scales:escalas
    }
  });
}

/* Unidades vendidas por día: barras redondeadas verde petróleo. */
const canvasUnidades=document.getElementById('graficaUnidades');
if(canvasUnidades && typeof Chart!=='undefined') {
  const ctx=canvasUnidades.getContext('2d');
  const gradiente=ctx.createLinearGradient(0,0,0,320);
  gradiente.addColorStop(0,'#4c9b84');
  gradiente.addColorStop(1,'#28786a');
  const escalas=baseScales();
  escalas.y.ticks.precision=0;
  new Chart(canvasUnidades,{
    type:'bar',
    data:{labels:etiquetas,datasets:[{
      label:'Unidades vendidas',data:unidades,
      backgroundColor:gradiente,hoverBackgroundColor:'#216557',
      borderRadius:8,borderSkipped:false,maxBarThickness:38,
      categoryPercentage:.72,barPercentage:.85
    }]},
    options:{responsive:true,maintainAspectRatio:false,
      animation:movimientoReducido?false:{duration:700,easing:'easeOutQuart'},
      interaction:{mode:'index',intersect:false},
      plugins:{legend:{display:false},tooltip:{...estiloTooltip,callbacks:{label:c=>' Unidades: '+formatoEntero(c.parsed.y)}}},
      scales:escalas
    }
  });
}
</script>


</body>

</html>