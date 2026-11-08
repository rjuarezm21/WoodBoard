<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Inventario | Sistema de Indicadores
    </title>

    <style>

        /* WOODBOARD — Diseño unificado con Registrar área */
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
        .header-titulo { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .volver-panel {
            display: inline-flex;
            justify-content: center;
            align-items: center;
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
        main { max-width: 1400px; margin: 0 auto; padding: 38px 30px 60px; }
        .encabezado { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 23px; }
        .titulo-pagina h1 {
            margin: 0 0 7px;
            color: var(--azul-oscuro);
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.5px;
        }
        .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .boton-nuevo {
            min-height: 43px;
            display: inline-flex; align-items: center; justify-content: center;
            padding: 10px 19px; border: 1px solid var(--azul-oscuro);
            border-radius: 8px; background: var(--azul-oscuro); color: white;
            font-family: inherit; font-size: 13px; font-weight: 600; text-decoration: none;
            transition: background .18s, border-color .18s;
        }
        .boton-nuevo:hover { background: #29415e; border-color: #29415e; }
        .mensaje, .error { margin-bottom: 20px; padding: 13px 15px; border: 1px solid; border-radius: 8px; font-size: 13px; line-height: 1.5; }
        .mensaje { background: #edf8f0; border-color: #cce7d2; color: #276738; }
        .error { background: #fff1f1; border-color: #f0cccc; color: #a33131; }
        .contenedor {
            background: var(--blanco); border: 1px solid var(--borde);
            border-radius: 12px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
        }
        .tabla-scroll { overflow-x: auto; }
        table { width: 100%; min-width: 1000px; border-collapse: collapse; }
        th, td {
            padding: 13px 14px; text-align: left; border-bottom: 1px solid #edf2f7;
            vertical-align: middle; font-size: 13px;
        }
        th { background: #f8fafc; color: #475569; font-size: 12px; font-weight: 600; white-space: nowrap; }
        td { color: #394457; }
        td:first-child { color: #64748b; width: 65px; }
        td:nth-child(2) { font-weight: 600; color: var(--texto); }
        td:nth-child(5) { font-weight: 600; font-variant-numeric: tabular-nums; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #f8fafc; }
        .activo, .inactivo { display: inline-flex; align-items: center; justify-content: center; padding: 5px 10px; border-radius: 7px; font-size: 12px; font-weight: 600; white-space: nowrap; }
        .activo { background: #edf8f0; color: #297245; }
        .inactivo { background: #f1f5f9; color: #64748b; }
        .acciones { white-space: nowrap; }
        .acciones form { display: inline-block; margin-left: 5px; }
        .boton-editar, .boton-estado {
            display: inline-flex; align-items: center; justify-content: center;
            min-height: 35px; padding: 8px 12px; border-radius: 7px;
            font-family: inherit; font-size: 12px; font-weight: 600;
            text-align: center; vertical-align: middle; text-decoration: none;
            transition: background .18s, color .18s, border-color .18s;
        }
        .boton-editar { border: 1px solid #cbd5e1; background: white; color: #475569; }
        .boton-editar:hover { background: #f1f5f9; }
        .boton-estado { min-width: 94px; border: 1px solid var(--azul-oscuro); background: var(--azul-oscuro); color: white; cursor: pointer; }
        .boton-estado:hover { background: #29415e; border-color: #29415e; }
        .sin-registros { padding: 30px !important; text-align: center !important; color: var(--secundario); }
        a:focus-visible, button:focus-visible { outline: 3px solid #9fc0df; outline-offset: 3px; }
        @media (max-width: 700px) {
            header { min-height: 68px; padding: 0 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-panel { padding: 7px 10px; font-size: 11px; }
            main { padding: 24px 14px 40px; }
            .encabezado { flex-direction: column; align-items: stretch; gap: 15px; }
            .titulo-pagina h1 { font-size: 23px; }
            .boton-nuevo { width: 100%; }
            .contenedor { border-radius: 8px; }
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
            Inventario
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
                Artículos de inventario
            </h1>

            <p>
                Consulta y administración de los artículos registrados.
            </p>

        </div>



        <?php if ($puedeGestionar): ?>

            <a
                class="boton-nuevo"
                href="inventario_crear.php"
            >
                Registrar artículo
            </a>

        <?php endif; ?>


    </div>



    <!-- =========================================================
         MENSAJES
         ========================================================= -->

    <?php if (isset($_GET['creado'])): ?>

        <div class="mensaje">
            Artículo registrado correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['editado'])): ?>

        <div class="mensaje">
            Artículo actualizado correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['estado'])): ?>

        <div class="mensaje">
            Estado actualizado correctamente.
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
                            Artículo
                        </th>

                        <th>
                            Descripción
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

                        <th>
                            Estado
                        </th>


                        <?php if ($puedeGestionar): ?>

                            <th>
                                Opciones
                            </th>

                        <?php endif; ?>


                    </tr>

                </thead>


                <tbody>


                <?php if (count($articulos) === 0): ?>


                    <tr>

                        <td
                            colspan="<?= $puedeGestionar ? 8 : 7 ?>"
                            class="sin-registros"
                        >
                            No hay artículos registrados.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $articulos
                        as $articulo
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $articulo
                                        ->getIdInventario()
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $articulo
                                        ->getNombreItem(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $articulo
                                        ->getDescripcion()
                                    ?? 'Sin descripción',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $articulo
                                        ->getCategoria(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= number_format(
                                    $articulo
                                        ->getCantidadDisponible()
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $articulo
                                        ->getUnidadMedida(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (
                                    $articulo->getEstado()
                                ): ?>


                                    <span class="activo">
                                        Activo
                                    </span>


                                <?php else: ?>


                                    <span class="inactivo">
                                        Inactivo
                                    </span>


                                <?php endif; ?>


                            </td>



                            <?php if ($puedeGestionar): ?>


                                <td class="acciones">


                                    <a
                                        class="boton-editar"
                                        href="inventario_editar.php?id=<?= (int) $articulo->getIdInventario() ?>"
                                    >
                                        Editar
                                    </a>



                                    <form
                                        method="POST"
                                        action="inventario_estado.php"
                                    >

                                        <input
                                            type="hidden"
                                            name="id_inventario"
                                            value="<?= (int) $articulo->getIdInventario() ?>"
                                        >


                                        <button
                                            class="boton-estado"
                                            type="submit"
                                        >

                                            <?= $articulo->getEstado()
                                                ? 'Desactivar'
                                                : 'Activar'
                                            ?>

                                        </button>


                                    </form>


                                </td>


                            <?php endif; ?>


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