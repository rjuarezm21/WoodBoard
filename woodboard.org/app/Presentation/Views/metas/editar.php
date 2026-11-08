<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Editar meta | Sistema de Indicadores
    </title>


    <style>
    :root {
        --navy: #18253a;
        --blue: #315b88;
        --bg: #f4f6f8;
        --white: #fff;
        --text: #1e293b;
        --muted: #64748b;
        --border: #e2e8f0;
        --radius: 10px;
    }

    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: "Segoe UI", Arial, Helvetica, sans-serif;
        background: var(--bg);
        color: var(--text);
        -webkit-font-smoothing: antialiased;
    }

    /* Encabezado coherente con los dashboards */
    header {
        min-height: 76px;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        background: var(--white);
        color: var(--navy);
        border-top: 4px solid var(--navy);
        border-bottom: 1px solid var(--border);
    }
    .header-titulo { display: flex; flex-direction: column; gap: 3px; }
    .header-titulo strong { font-size: 18px; font-weight: 700; letter-spacing: -.2px; }
    .header-titulo span { color: var(--muted); font-size: 12px; }
    .volver-header {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        color: var(--navy);
        background: var(--white);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .18s ease, color .18s ease, border-color .18s ease;
    }
    .volver-header:hover { background: var(--navy); color: white; border-color: var(--navy); }

    /* Distribución del formulario */
    main { width: 100%; max-width: 760px; margin: auto; padding: 38px 25px 60px; }
    .titulo-pagina { margin-bottom: 23px; }
    .titulo-pagina h1 {
        margin: 0 0 7px;
        color: var(--navy);
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -.5px;
    }
    .titulo-pagina p { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.6; }
    .contenedor {
        background: var(--white);
        border: 1px solid var(--border);
        border-top: 3px solid var(--blue);
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .035);
    }
    .campo { margin-bottom: 22px; }
    .campo:last-of-type { margin-bottom: 0; }
    label { display: block; margin-bottom: 8px; color: #334155; font-size: 12.5px; font-weight: 650; }
    input, textarea {
        display: block;
        width: 100%;
        padding: 11px 13px;
        background: #fff;
        color: var(--text);
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        font: 13.5px "Segoe UI", Arial, Helvetica, sans-serif;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    input { min-height: 44px; }
    textarea { min-height: 112px; resize: vertical; line-height: 1.6; }
    input:hover, textarea:hover { border-color: #aab9ca; }
    input:focus, textarea:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(49, 91, 136, .11);
    }

    /* Acciones */
    .acciones {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 21px;
        border-top: 1px solid #edf1f5;
    }
    button, .cancelar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 10px 19px;
        border-radius: 7px;
        font: 600 12.5px "Segoe UI", Arial, sans-serif;
        text-align: center;
        text-decoration: none;
        transition: background .18s ease, border-color .18s ease, color .18s ease;
    }
    button { background: var(--navy); border: 1px solid var(--navy); color: #fff; cursor: pointer; }
    button:hover { background: #29435f; border-color: #29435f; }
    .cancelar { background: #fff; color: #344054; border: 1px solid #cbd5e1; }
    .cancelar:hover { background: #f1f5f9; }
    button:focus-visible, .cancelar:focus-visible, .volver-header:focus-visible {
        outline: 3px solid #9fc0df;
        outline-offset: 2px;
    }

    .error {
        margin-bottom: 22px;
        padding: 13px 15px;
        border: 1px solid #efc8c8;
        border-radius: 8px;
        background: #fff3f3;
        color: #a33131;
        font-size: 13px;
        line-height: 1.5;
    }

    @media (max-width: 600px) {
        header { min-height: 68px; padding: 0 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 10.5px; }
        .volver-header { padding: 7px 10px; font-size: 11px; }
        main { padding: 25px 14px 40px; }
        .titulo-pagina h1 { font-size: 23px; }
        .contenedor { padding: 22px 17px; }
        .acciones { flex-direction: column; align-items: stretch; }
        button, .cancelar { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        input, textarea, button, .cancelar, .volver-header { transition: none; }
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
        class="volver-header"
        href="metas.php"
    >
        Volver
    </a>

</header>



<main>


    <div class="titulo-pagina">

        <h1>
            Editar meta
        </h1>

        <p>
            Modifique la información correspondiente a la meta de producción.
        </p>

    </div>



    <div class="contenedor">


        <?php if ($error !== null): ?>

            <div class="error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>

        <?php endif; ?>



        <form method="POST">


            <!-- DESCRIPCIÓN -->

            <div class="campo">

                <label for="descripcion">
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    required
                ><?= htmlspecialchars(
                    (string) (
                        $_POST['descripcion']
                        ?? $meta->getDescripcion()
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>

            </div>



            <!-- CANTIDAD -->

            <div class="campo">

                <label for="cantidad_objetivo">
                    Cantidad objetivo
                </label>

                <input
                    type="number"
                    id="cantidad_objetivo"
                    name="cantidad_objetivo"
                    min="1"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['cantidad_objetivo']
                            ?? $meta->getCantidadObjetivo()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- FECHA INICIO -->

            <div class="campo">

                <label for="fecha_inicio">
                    Fecha de inicio
                </label>

                <input
                    type="date"
                    id="fecha_inicio"
                    name="fecha_inicio"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['fecha_inicio']
                            ?? $meta->getFechaInicio()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- FECHA FINAL -->

            <div class="campo">

                <label for="fecha_fin">
                    Fecha de finalización
                </label>

                <input
                    type="date"
                    id="fecha_fin"
                    name="fecha_fin"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['fecha_fin']
                            ?? $meta->getFechaFin()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- ACCIONES -->

            <div class="acciones">

                <button type="submit">
                    Guardar cambios
                </button>


                <a
                    class="cancelar"
                    href="metas.php"
                >
                    Cancelar
                </a>

            </div>


        </form>


    </div>


</main>


</body>

</html>