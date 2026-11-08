<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Registrar venta | Sistema de Indicadores
    </title>

    <style>

        /* WoodBoard | Estilo unificado con Registrar área */
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
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header-titulo { display: flex; flex-direction: column; gap: 3px; min-width: 0; text-align: left; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .volver-header {
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
        .volver-header:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
        main { width: 100%; max-width: 760px; margin: 0 auto; padding: 38px 25px 60px; }
        .titulo-pagina { margin-bottom: 23px; }
        .titulo-pagina h1 { margin: 0 0 7px; color: var(--azul-oscuro); font-size: 27px; font-weight: 700; letter-spacing: -.5px; }
        .titulo-pagina p { margin: 0; color: var(--secundario); font-size: 13px; line-height: 1.6; }
        .formulario {
            padding: 30px;
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
        }
        .campo { margin-bottom: 23px; }
        label { display: block; margin-bottom: 9px; color: #334155; font-size: 13px; font-weight: 600; }
        input:not([type="hidden"]), textarea {
            display: block;
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: var(--texto);
            background: white;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        input:not([type="hidden"]) { height: 45px; }
        textarea { min-height: 115px; resize: vertical; line-height: 1.5; }
        input:not([type="hidden"]):hover, textarea:hover { border-color: #aab9cb; }
        input:not([type="hidden"]):focus, textarea:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(49,91,136,.10); }
        .error {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #f0cccc;
            border-radius: 8px;
            background: #fff1f1;
            color: #a33131;
            font-size: 13px;
            line-height: 1.5;
        }
        .acciones {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-top: 27px;
            padding-top: 21px;
            border-top: 1px solid #edf2f7;
        }
        .acciones button, .volver {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 19px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background .18s, border-color .18s, color .18s;
        }
        .acciones button { border: 1px solid var(--azul-oscuro); background: var(--azul-oscuro); color: white; }
        .acciones button:hover { background: #29415e; border-color: #29415e; }
        .volver { border: 1px solid #cbd5e1; background: white; color: #475569; }
        .volver:hover { background: #f1f5f9; }
        .acciones button:focus-visible, .volver:focus-visible, .volver-header:focus-visible { outline: 3px solid #9fc0df; outline-offset: 3px; }
        @media (max-width: 600px) {
            header { min-height: 68px; padding: 0 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-header { padding: 7px 10px; font-size: 11px; }
            main { padding: 24px 14px 40px; }
            .titulo-pagina h1 { font-size: 23px; }
            .formulario { padding: 22px 18px; }
            .acciones { flex-direction: column; align-items: stretch; }
            .acciones button, .volver { width: 100%; }
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
            Ventas
        </span>

    </div>


    <a
        class="volver-header"
        href="ventas.php"
    >
        Volver
    </a>

</header>



<main>


    <div class="titulo-pagina">

        <h1>
            Registrar venta
        </h1>

        <p>
            Ingrese la información correspondiente a la nueva venta.
        </p>

    </div>



    <div class="formulario">


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


            <!-- CSRF -->

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(
                    $csrfToken,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >



            <!-- FECHA -->

            <div class="campo">

                <label for="fecha_venta">
                    Fecha
                </label>

                <input
                    type="date"
                    id="fecha_venta"
                    name="fecha_venta"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['fecha_venta']
                            ?? date('Y-m-d')
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



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
                        ?? ''
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>

            </div>



            <!-- CANTIDAD -->

            <div class="campo">

                <label for="cantidad">
                    Cantidad
                </label>

                <input
                    type="number"
                    id="cantidad"
                    name="cantidad"
                    min="1"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['cantidad']
                            ?? ''
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- MONTO TOTAL -->

            <div class="campo">

                <label for="monto_total">
                    Monto total (Q)
                </label>

                <input
                    type="number"
                    id="monto_total"
                    name="monto_total"
                    min="0.01"
                    step="0.01"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['monto_total']
                            ?? ''
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
                    Registrar venta
                </button>


                <a
                    href="ventas.php"
                    class="volver"
                >
                    Cancelar
                </a>

            </div>


        </form>


    </div>


</main>


</body>

</html>