<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Empleados | Sistema de Indicadores
    </title>

    <style>
    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;
        --verde: #28786a;
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

    /* Encabezado corporativo, igual que WoodBoard */
    header {
        min-height: 76px;
        padding: 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        background: var(--blanco);
        border-top: 4px solid var(--azul-oscuro);
        border-bottom: 1px solid var(--borde);
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
    .header-titulo span { color: var(--texto-secundario); font-size: 12px; }
    .volver-panel {
        color: var(--azul-oscuro);
        text-decoration: none;
        border: 1px solid #cbd5e1;
        padding: 9px 15px;
        border-radius: 7px;
        background: var(--blanco);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        transition: color .18s, background .18s, border-color .18s;
    }
    .volver-panel:hover {
        color: #fff;
        background: var(--azul-oscuro);
        border-color: var(--azul-oscuro);
    }

    /* Contenido */
    main { width: 100%; max-width: 1320px; margin: 0 auto; padding: 38px 32px 60px; }
    .encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 26px;
    }
    .titulo-pagina h1 {
        margin: 0 0 7px;
        color: var(--azul-oscuro);
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -.5px;
    }
    .titulo-pagina p {
        margin: 0;
        color: var(--texto-secundario);
        font-size: 13px;
        line-height: 1.6;
    }
    .boton-nuevo {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 42px;
        padding: 11px 17px;
        color: white;
        background: var(--azul-oscuro);
        border: 1px solid var(--azul-oscuro);
        border-radius: 8px;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 650;
        transition: background .18s, transform .18s;
    }
    .boton-nuevo:hover { background: #2a4260; transform: translateY(-1px); }

    /* Avisos */
    .mensaje, .error {
        padding: 13px 16px;
        margin-bottom: 20px;
        border: 1px solid;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.5;
    }
    .mensaje { border-color: #cbe7db; background: #edf8f2; color: #24654d; }
    .error { border-color: #f0cccc; background: #fdf0f0; color: #a33131; }

    /* Tabla */
    .contenedor {
        background: var(--blanco);
        border: 1px solid var(--borde);
        border-radius: var(--radio);
        box-shadow: 0 1px 3px rgba(15,23,42,.04);
        overflow: hidden;
    }
    .tabla-scroll { overflow-x: auto; }
    table { width: 100%; min-width: 950px; border-collapse: collapse; }
    th, td {
        padding: 15px 16px;
        text-align: left;
        border-bottom: 1px solid #edf0f4;
        vertical-align: middle;
        font-size: 13px;
    }
    th {
        background: #f7f9fb;
        color: #536176;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }
    td { color: #394457; line-height: 1.5; }
    td:first-child { width: 65px; color: #8692a4; font-variant-numeric: tabular-nums; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover { background: #f8fbfd; }

    /* Estado de cada empleado */
    .activo, .inactivo {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 650;
        white-space: nowrap;
    }
    .activo { color: #236a50; background: #eaf5ef; }
    .inactivo { color: #697586; background: #f0f2f5; }

    /* Acciones existentes: mismos enlaces y formularios */
    .acciones { white-space: nowrap; }
    .acciones form { display: inline-block; margin-left: 5px; }
    .boton-editar, .boton-estado {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        min-height: 34px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 650;
        text-align: center;
        cursor: pointer;
        transition: background .18s, color .18s, border-color .18s;
    }
    .boton-editar {
        min-width: 69px;
        padding: 7px 12px;
        color: #344054;
        background: #f8fafc;
        border: 1px solid #d6dee8;
        text-decoration: none;
    }
    .boton-editar:hover { background: #eaf0f6; border-color: #b9c9dc; }
    .boton-estado {
        width: 92px;
        padding: 7px 10px;
        border: 1px solid var(--azul-oscuro);
        background: var(--azul-oscuro);
        color: #fff;
    }
    .boton-estado:hover { background: #2a4260; border-color: #2a4260; }
    .sin-registros { padding: 30px !important; text-align: center !important; color: var(--texto-secundario); }
    a:focus-visible, button:focus-visible { outline: 3px solid #9ebddd; outline-offset: 2px; }

    @media (max-width: 700px) {
        header { min-height: 68px; padding: 0 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 10.5px; }
        .volver-panel { padding: 7px 10px; font-size: 10.5px; }
        main { padding: 24px 14px 40px; }
        .encabezado { flex-direction: column; align-items: stretch; gap: 15px; }
        .titulo-pagina h1 { font-size: 23px; }
        .boton-nuevo { width: 100%; text-align: center; }
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
            Gestión de empleados
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

    <div class="encabezado">


        <div class="titulo-pagina">

            <h1>
                Empleados
            </h1>

            <p>
                Administración de los empleados registrados en la organización.
            </p>

        </div>


        <a
            class="boton-nuevo"
            href="empleado_crear.php"
        >
            Registrar nuevo empleado
        </a>


    </div>



    <!-- MENSAJES -->

    <?php if (isset($_GET['creado'])): ?>

        <div class="mensaje">
            Empleado registrado correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['editado'])): ?>

        <div class="mensaje">
            Empleado actualizado correctamente.
        </div>

    <?php endif; ?>



    <?php if (isset($_GET['estado'])): ?>

        <div class="mensaje">
            Estado del empleado actualizado correctamente.
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
                            Nombre
                        </th>

                        <th>
                            Puesto
                        </th>

                        <th>
                            Área
                        </th>

                        <th>
                            Fecha de ingreso
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


                <?php if (count($empleados) === 0): ?>


                    <tr>

                        <td
                            colspan="7"
                            class="sin-registros"
                        >
                            No hay empleados registrados.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $empleados
                        as $empleado
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $empleado['id_empleado']
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $empleado['nombre']
                                    . ' '
                                    . $empleado['apellido'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $empleado['puesto'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $empleado['nombre_area'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    date(
                                        'd/m/Y',
                                        strtotime(
                                            $empleado[
                                                'fecha_ingreso'
                                            ]
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (
                                    (bool)
                                    $empleado['estado']
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



                            <td class="acciones">


                                <a
                                    class="boton-editar"
                                    href="empleado_editar.php?id=<?= (int) $empleado['id_empleado'] ?>"
                                >
                                    Editar
                                </a>



                                <form
                                    method="POST"
                                    action="empleado_estado.php"
                                >

                                    <input
                                        type="hidden"
                                        name="id_empleado"
                                        value="<?= (int) $empleado['id_empleado'] ?>"
                                    >


                                    <button
                                        class="boton-estado"
                                        type="submit"
                                    >

                                        <?= (bool) $empleado['estado']
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