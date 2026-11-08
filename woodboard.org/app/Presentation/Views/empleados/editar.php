<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Editar empleado | Sistema de Indicadores
    </title>

    <style>
        /* WoodBoard · Estilo ejecutivo unificado · Editar empleado */
        :root {
            --navy: #192b48;
            --navy-hover: #263d60;
            --ink: #1d2b43;
            --muted: #708099;
            --line: #e4eaf2;
            --surface: #ffffff;
            --page: #f5f7fb;
            --blue: #315dba;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: var(--page);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            padding: 19px clamp(18px, 4vw, 46px);
            background: #fff;
            border-bottom: 1px solid var(--line);
            box-shadow: 0 3px 16px rgba(31, 48, 78, .025);
            position: relative;
        }
        header::before {
            content: "";
            position: absolute;
            height: 3px;
            background: var(--navy);
            top: 0;
            left: 0;
            right: 0;
        }
        .header-titulo { display: flex; flex-direction: column; gap: 5px; }
        .header-titulo strong { font-size: 17px; font-weight: 750; letter-spacing: -.3px; color: var(--navy); }
        .header-titulo span { color: var(--muted); font-size: 12px; }
        .volver-header {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 17px;
            color: var(--navy);
            background: #fff;
            border: 1px solid #d7e0ec;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: background .18s, border-color .18s, transform .18s;
        }
        .volver-header:hover { background: #f3f6fb; border-color: #b9c9dc; transform: translateY(-1px); }
        main { width: 100%; max-width: 790px; margin: auto; padding: 43px 25px 60px; }
        .titulo-pagina { margin-bottom: 24px; }
        .titulo-pagina h1 { margin: 0 0 9px; font-size: clamp(25px, 3vw, 31px); font-weight: 760; letter-spacing: -.8px; color: var(--navy); }
        .titulo-pagina p { margin: 0; color: var(--muted); font-size: 13.5px; line-height: 1.6; }
        .contenedor {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 15px;
            padding: 30px 32px;
            box-shadow: 0 12px 34px rgba(34, 55, 87, .035);
        }
        .campo { margin-bottom: 21px; }
        label { display: block; font-size: 13px; font-weight: 660; margin-bottom: 9px; color: #34435b; }
        input, select {
            display: block;
            width: 100%;
            height: 46px;
            padding: 0 14px;
            font: inherit;
            font-size: 14px;
            line-height: 1.4;
            color: var(--ink);
            background: #fff;
            border: 1px solid #d7dfeb;
            border-radius: 9px;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        input:hover, select:hover { border-color: #b6c4d7; }
        input:focus, select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(49, 93, 186, .105);
            background: #fff;
        }
        select { cursor: pointer; }
        .error {
            margin-bottom: 22px;
            padding: 13px 16px;
            background: #fff5f5;
            color: #a43b45;
            border: 1px solid #f1d4d7;
            border-left: 3px solid #d46d75;
            border-radius: 9px;
            font-size: 13px;
            line-height: 1.6;
        }
        .acciones {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 11px;
            margin-top: 29px;
            padding-top: 22px;
            border-top: 1px solid #edf1f6;
        }
        button, .cancelar {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 44px;
            padding: 11px 20px;
            border-radius: 9px;
            font: inherit;
            font-size: 13px;
            font-weight: 680;
            text-decoration: none;
            transition: background .18s, box-shadow .18s, transform .18s;
        }
        button {
            border: 1px solid var(--navy);
            background: var(--navy);
            color: white;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(25, 43, 72, .13);
        }
        button:hover { background: var(--navy-hover); transform: translateY(-1px); box-shadow: 0 7px 15px rgba(25,43,72,.17); }
        .cancelar { border: 1px solid #dce3ed; background: #f8fafc; color: #43536b; }
        .cancelar:hover { background: #eef2f7; }
        button:focus-visible, .cancelar:focus-visible, .volver-header:focus-visible { outline: 3px solid rgba(49,93,186,.25); outline-offset: 2px; }
        @media (max-width: 600px) {
            header { padding: 16px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-header { padding: 9px 12px; font-size: 12px; }
            main { padding: 26px 15px 42px; }
            .titulo-pagina { margin-bottom: 19px; }
            .titulo-pagina h1 { font-size: 25px; }
            .contenedor { padding: 22px 18px; border-radius: 12px; }
            .acciones { flex-direction: column; align-items: stretch; }
            button, .cancelar { width: 100%; text-align: center; }
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
        class="volver-header"
        href="empleados.php"
    >
        Volver
    </a>

</header>



<main>


    <div class="titulo-pagina">

        <h1>
            Editar empleado
        </h1>

        <p>
            Modifique la información correspondiente al empleado seleccionado.
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


            <!-- NOMBRE -->

            <div class="campo">

                <label for="nombre">
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['nombre']
                            ?? $empleado->getNombre()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- APELLIDO -->

            <div class="campo">

                <label for="apellido">
                    Apellido
                </label>

                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['apellido']
                            ?? $empleado->getApellido()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- PUESTO -->

            <div class="campo">

                <label for="puesto">
                    Puesto
                </label>

                <input
                    type="text"
                    id="puesto"
                    name="puesto"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['puesto']
                            ?? $empleado->getPuesto()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- FECHA DE INGRESO -->

            <div class="campo">

                <label for="fecha_ingreso">
                    Fecha de ingreso
                </label>

                <input
                    type="date"
                    id="fecha_ingreso"
                    name="fecha_ingreso"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['fecha_ingreso']
                            ?? $empleado->getFechaIngreso()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>



            <!-- ÁREA -->

            <div class="campo">

                <label for="id_area">
                    Área
                </label>


                <select
                    id="id_area"
                    name="id_area"
                    required
                >


                    <?php

                    $idAreaSeleccionada =
                        (int) (
                            $_POST['id_area']
                            ?? $empleado->getIdArea()
                        );

                    ?>


                    <?php foreach (
                        $areas
                        as $area
                    ): ?>


                        <?php

                        $idArea =
                            (int)
                            $area->getIdArea();

                        ?>


                        <option
                            value="<?= $idArea ?>"
                            <?= $idAreaSeleccionada === $idArea
                                ? 'selected'
                                : ''
                            ?>
                        >

                            <?= htmlspecialchars(
                                $area->getNombreArea(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </option>


                    <?php endforeach; ?>


                </select>

            </div>



            <!-- ACCIONES -->

            <div class="acciones">


                <button type="submit">
                    Guardar cambios
                </button>


                <a
                    class="cancelar"
                    href="empleados.php"
                >
                    Cancelar
                </a>


            </div>


        </form>


    </div>


</main>


</body>

</html>