<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Metas de producción | Sistema de Indicadores
    </title>

    <style>
    /* WoodBoard · Diseño ejecutivo moderno */
    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;
        --verde: #28786a;
        --verde-suave: #eaf5f1;
        --rojo: #b85555;
        --rojo-suave: #fff0f0;
        --fondo: #f4f6f8;
        --blanco: #fff;
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

    /* Encabezado consistente con los dashboards */
    header {
        min-height: 76px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 40px;
        background: var(--blanco);
        border-top: 4px solid var(--azul-oscuro);
        border-bottom: 1px solid var(--borde);
        position: sticky;
        top: 0;
        z-index: 50;
    }
    .header-titulo { display: flex; flex-direction: column; gap: 3px; }
    .header-titulo strong {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: -0.2px;
        color: var(--azul-oscuro);
    }
    .header-titulo span { font-size: 12px; color: var(--texto-secundario); }
    .volver-panel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        color: var(--azul-oscuro);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: color .18s, background .18s, border-color .18s;
    }
    .volver-panel:hover {
        color: white;
        background: var(--azul-oscuro);
        border-color: var(--azul-oscuro);
    }

    /* Área principal y encabezado de página */
    main { max-width: 1320px; width: 100%; margin: 0 auto; padding: 38px 32px 60px; }
    .encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }
    .titulo-pagina h1 {
        margin: 0 0 7px;
        color: var(--azul-oscuro);
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -.5px;
    }
    .titulo-pagina p { margin: 0; color: var(--texto-secundario); font-size: 13px; line-height: 1.6; }

    /* Botón de alta */
    .boton-nuevo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 10px 17px;
        background: var(--azul-oscuro);
        color: #fff;
        border: 1px solid var(--azul-oscuro);
        border-radius: 8px;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 650;
        white-space: nowrap;
        transition: background .18s, transform .18s;
    }
    .boton-nuevo:hover { background: var(--azul); transform: translateY(-1px); }

    /* Retroalimentación */
    .mensaje, .error {
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.5;
    }
    .mensaje { background: var(--verde-suave); border-color: #c9e8dd; color: #226451; }
    .error { background: var(--rojo-suave); border-color: #f0cccc; color: #a33131; }

    /* Contenedor y tabla de metas */
    .contenedor {
        background: var(--blanco);
        border: 1px solid var(--borde);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .035);
    }
    .tabla-scroll { max-width: 100%; overflow-x: auto; }
    table { width: 100%; min-width: 950px; border-collapse: collapse; }
    th, td {
        text-align: left;
        vertical-align: middle;
        padding: 16px 15px;
        border-bottom: 1px solid #edf1f5;
        font-size: 12.5px;
    }
    th {
        padding-top: 16px;
        padding-bottom: 16px;
        background: #f8fafc;
        color: #506076;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }
    td { color: #344054; line-height: 1.55; }
    td:first-child { width: 66px; color: #7f8b9b; font-variant-numeric: tabular-nums; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover { background: #fafcff; }
    td:nth-child(3), td:nth-child(4), td:nth-child(5) { font-variant-numeric: tabular-nums; }

    /* Estado de meta */
    .activo, .inactivo {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .activo { color: #23705c; background: var(--verde-suave); }
    .inactivo { color: #667488; background: #edf1f5; }

    /* Acciones; ancho y altura consistentes */
    .acciones { white-space: nowrap; }
    .acciones form { display: inline-block; margin: 0 0 0 6px; vertical-align: middle; }
    .boton-editar, .boton-estado {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        min-height: 34px;
        padding: 7px 12px;
        font: 600 11.5px "Segoe UI", Arial, sans-serif;
        border-radius: 7px;
        text-decoration: none;
        cursor: pointer;
        transition: background .18s, border-color .18s, color .18s;
    }
    .boton-editar {
        background: white;
        color: #354962;
        border: 1px solid #d5dfea;
    }
    .boton-editar:hover { background: var(--azul-suave); border-color: #b6cbdf; }
    .boton-estado {
        width: 98px;
        border: 1px solid var(--azul-oscuro);
        background: var(--azul-oscuro);
        color: white;
    }
    .boton-estado:hover { background: var(--azul); border-color: var(--azul); }
    .sin-registros {
        padding: 34px 16px !important;
        color: var(--texto-secundario);
        text-align: center !important;
    }

    .boton-nuevo:focus-visible, .volver-panel:focus-visible,
    .boton-editar:focus-visible, .boton-estado:focus-visible {
        outline: 3px solid #a6cae9;
        outline-offset: 2px;
    }

    @media (max-width: 900px) {
        header { padding: 0 24px; }
        main { padding: 30px 22px 50px; }
    }
    @media (max-width: 700px) {
        header { min-height: 68px; padding: 0 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 10.5px; }
        .volver-panel { padding: 7px 10px; font-size: 10.5px; }
        main { padding: 24px 14px 40px; }
        .encabezado { flex-direction: column; align-items: stretch; gap: 16px; }
        .titulo-pagina h1 { font-size: 23px; }
        .boton-nuevo { width: 100%; }
        .contenedor { border-radius: 9px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .boton-nuevo, .volver-panel, .boton-editar, .boton-estado { transition: none; }
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
            Metas de producción
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


    <!-- =========================================================
         ENCABEZADO
         ========================================================= -->

    <div class="encabezado">


        <div class="titulo-pagina">

            <h1>
                Metas de producción
            </h1>

            <p>
                Administración y seguimiento de las metas registradas.
            </p>

        </div>


        <a
            class="boton-nuevo"
            href="meta_crear.php"
        >
            Registrar nueva meta
        </a>


    </div>



    <!-- =========================================================
         MENSAJES
         ========================================================= -->

    <?php if (isset($_GET['creada'])): ?>

        <div class="mensaje">
            Meta registrada correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['editada'])): ?>

        <div class="mensaje">
            Meta actualizada correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['estado'])): ?>

        <div class="mensaje">
            Estado de la meta actualizado correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['error'])): ?>

        <div class="error">

            <?= htmlspecialchars(
                (string) $_GET['error'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    <?php endif; ?>



    <!-- =========================================================
         TABLA
         ========================================================= -->

    <div class="contenedor">

        <div class="tabla-scroll">


            <table>


                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Cantidad objetivo
                        </th>

                        <th>
                            Fecha inicio
                        </th>

                        <th>
                            Fecha fin
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Opciones
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (count($metas) === 0): ?>


                    <tr>

                        <td
                            colspan="7"
                            class="sin-registros"
                        >
                            No hay metas registradas.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $metas
                        as $meta
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $meta->getIdMeta()
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $meta->getDescripcion(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= number_format(
                                    $meta
                                        ->getCantidadObjetivo()
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $meta
                                                ->getFechaInicio()
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $meta
                                                ->getFechaFin()
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (
                                    $meta->getEstado()
                                ): ?>


                                    <span class="activo">
                                        Activa
                                    </span>


                                <?php else: ?>


                                    <span class="inactivo">
                                        Inactiva
                                    </span>


                                <?php endif; ?>


                            </td>



                            <td class="acciones">


                                <a
                                    class="boton-editar"
                                    href="meta_editar.php?id=<?= (int) $meta->getIdMeta() ?>"
                                >
                                    Editar
                                </a>



                                <form
                                    method="POST"
                                    action="meta_estado.php"
                                >

                                    <input
                                        type="hidden"
                                        name="id_meta"
                                        value="<?= (int) $meta->getIdMeta() ?>"
                                    >


                                    <button
                                        class="boton-estado"
                                        type="submit"
                                    >

                                        <?= $meta->getEstado()
                                            ? 'Desactivar'
                                            : 'Activar'
                                        ?>

                                    </button>

                                </form>


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