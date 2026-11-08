<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Áreas | Sistema de Indicadores
    </title>


    <style>
    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;
        --fondo: #f4f6f8;
        --blanco: #ffffff;
        --texto: #1e293b;
        --secundario: #64748b;
        --borde: #e2e8f0;
        --verde: #28786a;
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

    /* Encabezado: mismo estilo de los dashboards */
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
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-titulo { display: flex; flex-direction: column; gap: 3px; }
    .header-titulo strong {
        color: var(--azul-oscuro);
        font-size: 18px;
        font-weight: 700;
        letter-spacing: -.2px;
    }
    .header-titulo span { color: var(--secundario); font-size: 12px; }

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
        transition: background .18s ease, color .18s ease, border-color .18s ease;
    }
    .volver-panel:hover {
        color: white;
        background: var(--azul-oscuro);
        border-color: var(--azul-oscuro);
    }

    /* Contenido y título */
    main { width: 100%; max-width: 1320px; margin: auto; padding: 38px 32px 60px; }
    .encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 25px;
    }
    .titulo-pagina h1 {
        margin: 0 0 7px;
        color: var(--azul-oscuro);
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -.5px;
    }
    .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }

    .boton-nuevo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 10px 17px;
        color: white;
        background: var(--azul-oscuro);
        border: 1px solid var(--azul-oscuro);
        border-radius: 7px;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        transition: background .18s ease, transform .18s ease;
    }
    .boton-nuevo:hover { background: #29425f; transform: translateY(-1px); }

    /* Tabla de áreas */
    .contenedor {
        background: var(--blanco);
        border: 1px solid var(--borde);
        border-radius: var(--radio);
        box-shadow: 0 1px 2px rgba(15, 23, 42, .03);
        overflow: hidden;
    }
    .tabla-scroll { width: 100%; overflow-x: auto; }
    table { width: 100%; min-width: 800px; border-collapse: collapse; }
    th, td {
        padding: 16px 18px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #edf1f5;
        font-size: 13px;
    }
    th {
        background: #f8fafc;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .25px;
        white-space: nowrap;
    }
    td { color: #394457; line-height: 1.5; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover { background: #fafbfd; }
    td:first-child { width: 68px; color: #94a3b8; font-variant-numeric: tabular-nums; }
    tbody td:nth-child(2) { font-weight: 600; color: var(--azul-oscuro); }

    /* Estados discretos y legibles */
    .activo, .inactivo {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 650;
        white-space: nowrap;
    }
    .activo { color: #236b58; background: #eaf5f1; }
    .inactivo { color: #667387; background: #eef1f5; }

    /* Mantiene los botones y formularios originales */
    .acciones { white-space: nowrap; }
    .acciones form { display: inline-block; margin-left: 5px; }
    .boton-editar, .boton-estado {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 34px;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-family: inherit;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: background .18s ease, border-color .18s ease;
    }
    .boton-editar {
        min-width: 65px;
        color: #344054;
        background: #f8fafc;
        border: 1px solid #d7dfe9;
    }
    .boton-editar:hover { background: #edf2f7; border-color: #cbd5e1; }
    .boton-estado {
        width: 92px;
        color: white;
        background: var(--azul-oscuro);
        border: 1px solid var(--azul-oscuro);
        cursor: pointer;
    }
    .boton-estado:hover { background: #29425f; border-color: #29425f; }
    .sin-registros { padding: 34px !important; text-align: center !important; color: var(--secundario); }

    a:focus-visible, button:focus-visible { outline: 3px solid #a4c6e8; outline-offset: 3px; }

    @media (max-width: 700px) {
        header { min-height: 68px; padding: 0 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 11px; }
        .volver-panel { padding: 7px 10px; font-size: 11px; }
        main { padding: 24px 14px 40px; }
        .encabezado { flex-direction: column; align-items: stretch; gap: 15px; }
        .titulo-pagina h1 { font-size: 23px; }
        .boton-nuevo { width: 100%; }
        th, td { padding: 13px 14px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .volver-panel, .boton-nuevo, .boton-editar, .boton-estado { transition: none; }
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
            Gestión de áreas
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
                Áreas
            </h1>

            <p>
                Administración de las áreas registradas en la organización.
            </p>

        </div>


        <a
            class="boton-nuevo"
            href="area_crear.php"
        >
            Registrar nueva área
        </a>


    </div>



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
                            Área
                        </th>

                        <th>
                            Descripción
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


                <?php if (count($areas) === 0): ?>


                    <tr>

                        <td
                            colspan="5"
                            class="sin-registros"
                        >
                            No hay áreas registradas.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $areas
                        as $area
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $area->getIdArea()
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $area->getNombreArea(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $area->getDescripcion()
                                    ?? 'Sin descripción',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (
                                    $area->getEstado()
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
                                    href="area_editar.php?id=<?= (int) $area->getIdArea() ?>"
                                >
                                    Editar
                                </a>



                                <form
                                    method="POST"
                                    action="area_estado.php"
                                >

                                    <input
                                        type="hidden"
                                        name="id_area"
                                        value="<?= (int) $area->getIdArea() ?>"
                                    >


                                    <button
                                        class="boton-estado"
                                        type="submit"
                                    >

                                        <?= $area->getEstado()
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