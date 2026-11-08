<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Registrar meta | Sistema de Indicadores
    </title>

    <style>
    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;
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

    /* ENCABEZADO CORPORATIVO */
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
    }
    .header-titulo { display: flex; flex-direction: column; gap: 3px; }
    .header-titulo strong {
        color: var(--azul-oscuro);
        font-size: 18px;
        font-weight: 700;
        letter-spacing: -.2px;
    }
    .header-titulo span { color: var(--texto-secundario); font-size: 12px; }
    .volver-header {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: var(--blanco);
        color: var(--azul-oscuro);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .18s ease, color .18s ease, border-color .18s ease;
    }
    .volver-header:hover {
        background: var(--azul-oscuro);
        color: #fff;
        border-color: var(--azul-oscuro);
    }

    /* CONTENIDO */
    main {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 38px 25px 60px;
    }
    .titulo-pagina { margin-bottom: 23px; }
    .titulo-pagina h1 {
        margin: 0 0 8px;
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

    /* FORMULARIO */
    .contenedor {
        padding: 29px;
        background: var(--blanco);
        border: 1px solid var(--borde);
        border-radius: var(--radio);
        box-shadow: 0 1px 3px rgba(15,23,42,.035);
    }
    .campo { margin-bottom: 21px; }
    label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 12.5px;
        font-weight: 650;
    }
    input, textarea {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #cfd8e3;
        border-radius: 8px;
        background: #fff;
        color: var(--texto);
        font: 13.5px "Segoe UI", Arial, sans-serif;
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    input { min-height: 44px; }
    textarea { min-height: 112px; resize: vertical; line-height: 1.55; }
    input:hover, textarea:hover { border-color: #aebdce; }
    input:focus, textarea:focus {
        border-color: var(--azul);
        box-shadow: 0 0 0 3px rgba(49,91,136,.11);
    }

    /* ACCIONES */
    .acciones {
        display: flex;
        gap: 11px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 26px;
        padding-top: 22px;
        border-top: 1px solid #edf1f5;
    }
    button, .cancelar {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        border-radius: 7px;
        font: 600 13px "Segoe UI", Arial, sans-serif;
        text-decoration: none;
        transition: background .18s ease, border-color .18s ease, color .18s ease;
    }
    button {
        border: 1px solid var(--azul-oscuro);
        background: var(--azul-oscuro);
        color: #fff;
        cursor: pointer;
    }
    button:hover { background: #2b415f; border-color: #2b415f; }
    .cancelar {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #344054;
    }
    .cancelar:hover { background: #f5f7fa; border-color: #aebdce; }
    button:focus-visible, .cancelar:focus-visible, .volver-header:focus-visible {
        outline: 3px solid #a6c5e4;
        outline-offset: 3px;
    }

    /* ERRORES */
    .error {
        margin-bottom: 22px;
        padding: 13px 15px;
        background: #fff3f3;
        color: #9f3030;
        border: 1px solid #f0cccc;
        border-left: 3px solid #c15d5d;
        border-radius: 7px;
        font-size: 13px;
        line-height: 1.5;
    }

    @media (max-width: 600px) {
        header { min-height: 68px; padding: 0 16px; gap: 12px; }
        .header-titulo strong { font-size: 15px; }
        .header-titulo span { font-size: 10.5px; }
        .volver-header { padding: 7px 10px; font-size: 11px; }
        main { padding: 24px 14px 40px; }
        .titulo-pagina h1 { font-size: 23px; }
        .contenedor { padding: 21px 18px; }
        .acciones { flex-direction: column; align-items: stretch; }
        button, .cancelar { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        button, .cancelar, .volver-header, input, textarea { transition: none; }
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
            Registrar meta
        </h1>

        <p>
            Ingrese la información correspondiente a la nueva meta de producción.
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
                        ?? ''
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>

            </div>



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
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



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
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



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
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <div class="acciones">

                <button type="submit">
                    Registrar meta
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