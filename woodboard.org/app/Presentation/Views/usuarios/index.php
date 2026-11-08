<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Usuarios | Sistema de Indicadores
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
        .header-titulo { display: flex; flex-direction: column; gap: 3px; min-width: 0; text-align: left; }
        .header-titulo strong { font-size: 18px; font-weight: 700; color: var(--azul-oscuro); letter-spacing: -.2px; }
        .header-titulo span { font-size: 12px; color: var(--secundario); }
        .volver-panel {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            padding: 9px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            color: var(--azul-oscuro);
            background: var(--blanco);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background .18s, color .18s, border-color .18s;
        }
        .volver-panel:hover { background: var(--azul-oscuro); color: white; border-color: var(--azul-oscuro); }
        main { width: 100%; max-width: 1400px; margin: 0 auto; padding: 38px 30px 60px; }
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
            display: inline-flex; align-items: center; justify-content: center;
            min-height: 43px; padding: 10px 19px;
            background: var(--azul-oscuro); color: white; text-decoration: none;
            border: 1px solid var(--azul-oscuro); border-radius: 8px;
            font-size: 13px; font-weight: 600;
            transition: background .18s, border-color .18s;
        }
        .boton-nuevo:hover { background: #29415e; border-color: #29415e; }
        .contenedor {
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15,23,42,.035);
        }
        .tabla-scroll { overflow-x: auto; }
        table { width: 100%; min-width: 1050px; border-collapse: collapse; }
        th, td {
            padding: 14px 15px;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            font-size: 13px;
        }
        th { background: #f8fafc; color: #475569; font-size: 12px; font-weight: 700; white-space: nowrap; }
        td { color: #39475a; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #f8fafc; }
        td:first-child { width: 65px; color: #64748b; }
        .activo, .inactivo {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 72px; padding: 5px 10px; border-radius: 999px;
            font-size: 12px; font-weight: 600;
        }
        .activo { background: #ecf8f0; color: #237144; border: 1px solid #ccead4; }
        .inactivo { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
        .acciones { white-space: nowrap; }
        .acciones form { display: inline-block; margin-left: 6px; }
        .boton-editar, .boton-estado {
            display: inline-flex; align-items: center; justify-content: center;
            min-height: 35px; padding: 8px 12px;
            border-radius: 7px; font-family: inherit;
            font-size: 12px; font-weight: 600; text-align: center;
            transition: background .18s, color .18s, border-color .18s;
        }
        .boton-editar { min-width: 65px; background: #fff; color: #334155; text-decoration: none; border: 1px solid #cbd5e1; }
        .boton-editar:hover { background: #f1f5f9; }
        .boton-estado { width: 98px; background: var(--azul-oscuro); color: #fff; border: 1px solid var(--azul-oscuro); cursor: pointer; }
        .boton-estado:hover { background: #29415e; border-color: #29415e; }
        .sin-registros { padding: 35px 20px !important; text-align: center !important; color: var(--secundario); }
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
            .contenedor { border-radius: 10px; }
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
            Gestión de usuarios
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
                Usuarios
            </h1>

            <p>
                Administración de usuarios, roles y áreas asignadas dentro del sistema.
            </p>

        </div>


        <a
            class="boton-nuevo"
            href="usuario_crear.php"
        >
            Registrar nuevo usuario
        </a>


    </div>



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
                            Correo
                        </th>

                        <th>
                            Rol
                        </th>

                        <th>
                            Área
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


                <?php if (count($usuarios) === 0): ?>


                    <tr>

                        <td
                            colspan="7"
                            class="sin-registros"
                        >
                            No hay usuarios registrados.
                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach (
                        $usuarios
                        as $usuario
                    ): ?>


                        <tr>


                            <td>

                                <?= (int)
                                    $usuario['id_usuario']
                                ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $usuario['nombre']
                                    . ' '
                                    . $usuario['apellido'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $usuario['correo'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $usuario['nombre_rol'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>

                                <?= htmlspecialchars(
                                    $usuario['nombre_area'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>



                            <td>


                                <?php if (
                                    (bool)
                                    $usuario['estado']
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
                                    href="usuario_editar.php?id=<?= (int) $usuario['id_usuario'] ?>"
                                >
                                    Editar
                                </a>



                                <form
                                    method="POST"
                                    action="usuario_estado.php"
                                >

                                    <input
                                        type="hidden"
                                        name="id_usuario"
                                        value="<?= (int) $usuario['id_usuario'] ?>"
                                    >


                                    <button
                                        class="boton-estado"
                                        type="submit"
                                    >

                                        <?= (bool) $usuario['estado']
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