<?php

if (!isset($nombreUsuario) || !is_string($nombreUsuario) || trim($nombreUsuario) === '') {
    $nombreUsuario = $_SESSION['nombre_usuario']
        ?? $_SESSION['nombre']
        ?? null;

    if (!$nombreUsuario && isset($_SESSION['usuario']) && is_string($_SESSION['usuario'])) {
        $nombreUsuario = $_SESSION['usuario'];
    }
}

if (!isset($nombreRol) || !is_string($nombreRol) || trim($nombreRol) === '') {
    $nombreRol = $_SESSION['nombre_rol']
        ?? $_SESSION['rol']
        ?? null;
}

$nombreUsuario = $nombreUsuario ?: 'Usuario';
$nombreRol = $nombreRol ?: 'Usuario';
?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Panel principal
    </title>

<style>

    :root {
        --azul-oscuro: #18253a;
        --azul: #315b88;
        --azul-suave: #eaf0f6;

        --fondo: #f4f6f8;
        --blanco: #ffffff;

        --texto: #1e293b;
        --texto-secundario: #64748b;
        --borde: #e2e8f0;

        --verde: #28786a;

        --radio: 10px;
    }


    * {
        box-sizing: border-box;
    }


    body {
        margin: 0;

        font-family:
            "Segoe UI",
            Arial,
            Helvetica,
            sans-serif;

        background: var(--fondo);
        color: var(--texto);
    }


    /* =========================================================
       HEADER
       ========================================================= */

    header {
        min-height: 76px;

        padding: 0 40px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        background: var(--blanco);

        border-top: 4px solid var(--azul-oscuro);
        border-bottom: 1px solid var(--borde);

        position: sticky;
        top: 0;

        z-index: 100;
    }


    .titulo-header {
        display: flex;
        flex-direction: column;

        gap: 3px;
    }


    .titulo-header strong {
        color: var(--azul-oscuro);

        font-size: 18px;
        font-weight: 700;

        letter-spacing: -0.2px;
    }


    .titulo-header span {
        color: var(--texto-secundario);

        font-size: 12px;
    }


    .header-derecha {
        display: flex;
        align-items: center;

        gap: 15px;
    }


    .cerrar-sesion {
        padding: 9px 15px;

        color: var(--azul-oscuro);

        background: var(--blanco);

        border: 1px solid #cbd5e1;

        border-radius: 7px;

        font-size: 12px;
        font-weight: 600;

        text-decoration: none;

        transition: 0.2s ease;
    }


    .cerrar-sesion:hover {
        color: white;
        background: var(--azul-oscuro);
        border-color: var(--azul-oscuro);
    }


    /* =========================================================
       CONTENIDO
       ========================================================= */

    main {
        width: 100%;
        max-width: 1320px;

        margin: 0 auto;

        padding:
            38px
            32px
            60px;
    }


    /* =========================================================
       BIENVENIDA
       ========================================================= */

    .bienvenida {
        position: relative;

        margin-bottom: 42px;

        padding:
            28px
            30px;

        background: var(--blanco);

        border: 1px solid var(--borde);
        border-left: 4px solid var(--azul);

        border-radius: var(--radio);

        box-shadow:
            0 1px 2px
            rgba(15, 23, 42, 0.03);
    }


    .bienvenida h1 {
        margin:
            0
            0
            22px;

        color: var(--azul-oscuro);

        font-size: 27px;
        font-weight: 700;

        letter-spacing: -0.5px;
    }


    /* =========================================================
       DATOS DEL USUARIO
       ========================================================= */

    .datos-panel {
        display: flex;
        flex-wrap: wrap;

        gap: 35px;

        margin-bottom: 16px;
    }


    .dato-usuario {
        display: flex;
        flex-direction: column;

        gap: 4px;
    }


    .dato-label {
        color: #94a3b8;

        font-size: 10px;
        font-weight: 700;

        letter-spacing: 0.8px;

        text-transform: uppercase;
    }


    .dato-valor {
        color: var(--texto);

        font-size: 14px;
        font-weight: 600;
    }


    .descripcion-panel {
        max-width: 700px;

        margin: 0;

        color: var(--texto-secundario);

        font-size: 13px;

        line-height: 1.6;
    }


    /* =========================================================
       SECCIONES
       ========================================================= */

    .seccion {
        margin-bottom: 45px;
    }


    .seccion-titulo {
        position: relative;

        margin-bottom: 18px;

        padding-bottom: 13px;

        border-bottom: 1px solid var(--borde);
    }


    .seccion-titulo::after {
        content: "";

        position: absolute;

        left: 0;
        bottom: -1px;

        width: 45px;
        height: 2px;

        background: var(--azul);
    }


    .seccion-titulo h2 {
        margin:
            0
            0
            5px;

        color: var(--azul-oscuro);

        font-size: 18px;
        font-weight: 700;

        letter-spacing: -0.2px;
    }


    .seccion-titulo p {
        margin: 0;

        color: var(--texto-secundario);

        font-size: 12.5px;
    }


    /* =========================================================
       GRID
       ========================================================= */

    .grid {
        display: grid;

        grid-template-columns:
            repeat(
                auto-fit,
                minmax(245px, 1fr)
            );

        gap: 17px;
    }


    /* =========================================================
       TARJETAS
       ========================================================= */

    .tarjeta {
        position: relative;

        display: block;

        min-height: 155px;

        padding:
            21px
            21px
            20px;

        overflow: hidden;

        background: var(--blanco);

        border: 1px solid var(--borde);

        border-radius: var(--radio);

        color: var(--texto);

        text-decoration: none;

        box-shadow:
            0 1px 2px
            rgba(15, 23, 42, 0.03);

        transition:
            transform 0.18s ease,
            border-color 0.18s ease,
            box-shadow 0.18s ease;
    }


    /* Línea superior discreta */

    .tarjeta::before {
        content: "";

        position: absolute;

        top: 0;
        left: 0;

        width: 100%;
        height: 3px;

        background: var(--azul);

        opacity: 0;
        transition: opacity 0.18s ease;
    }


    .tarjeta:hover {
        transform: translateY(-2px);

        border-color: #bccadd;

        box-shadow:
            0 7px 18px
            rgba(15, 23, 42, 0.06);
    }


    .tarjeta:hover::before {
        opacity: 1;
    }


    /* =========================================================
       ICONO
       ========================================================= */

    .icono {
        width: 38px;
        height: 38px;

        margin-bottom: 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--azul);

        background: var(--azul-suave);

        border: 1px solid #dce6f0;

        border-radius: 8px;

        font-size: 13px;
        font-weight: 700;

        transition:
            background 0.18s ease,
            color 0.18s ease;
    }


    .tarjeta:hover .icono {
        color: white;

        background: var(--azul);
    }


    /* =========================================================
       TEXTO TARJETAS
       ========================================================= */

    .tarjeta h3 {
        margin:
            0
            0
            7px;

        color: var(--azul-oscuro);

        font-size: 15px;
        font-weight: 650;
    }


    .tarjeta p {
        max-width: 280px;

        margin: 0;

        color: var(--texto-secundario);

        font-size: 12px;

        line-height: 1.55;
    }


    /* Flecha */

    .tarjeta::after {
        content: "→";

        position: absolute;

        right: 18px;
        bottom: 16px;

        color: #a8b3c2;

        font-size: 16px;

        opacity: 0;

        transform: translateX(-4px);

        transition:
            opacity 0.18s ease,
            transform 0.18s ease;
    }


    .tarjeta:hover::after {
        opacity: 1;
        transform: translateX(0);
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        header {
            padding:
                0
                24px;
        }


        main {
            padding:
                30px
                22px
                50px;
        }


        .grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }

    }


    @media (max-width: 600px) {

        header {
            min-height: 68px;

            padding:
                0
                16px;
        }


        .titulo-header strong {
            font-size: 15px;
        }


        .titulo-header span {
            font-size: 10px;
        }


        .cerrar-sesion {
            padding:
                7px
                10px;

            font-size: 10.5px;
        }


        main {
            padding:
                22px
                14px
                40px;
        }


        .bienvenida {
            margin-bottom: 32px;

            padding:
                22px
                20px;
        }


        .bienvenida h1 {
            font-size: 23px;
        }


        .datos-panel {
            gap: 18px;
        }


        .grid {
            grid-template-columns: 1fr;

            gap: 11px;
        }


        .seccion {
            margin-bottom: 35px;
        }


        .tarjeta {
            min-height: auto;

            padding: 16px;

            display: grid;

            grid-template-columns:
                43px
                1fr;

            column-gap: 13px;

            align-items: center;
        }


        .icono {
            margin: 0;

            grid-row:
                1
                / 3;
        }


        .tarjeta h3 {
            margin:
                0
                0
                4px;
        }


        .tarjeta p {
            font-size: 11.5px;
        }


        .tarjeta::after {
            display: none;
        }

    }

</style>


</head>


<body>


<header>

    <div class="titulo-header">

        <strong>
            Sistema de Indicadores
        </strong>

        <span>
            Panel de control
        </span>

    </div>


    <div class="header-derecha">

        <a
            class="cerrar-sesion"
            href="logout.php"
        >
            Cerrar sesión
        </a>

    </div>

</header>


<main>


    <!--
    ========================================================================
    BIENVENIDA
    ========================================================================
    -->

<section class="bienvenida">

    <h1>
        Panel principal
    </h1>

    <div class="datos-panel">

        <div class="dato-usuario">

            <span class="dato-label">
                Nombre
            </span>

            <strong class="dato-valor">
                <?= htmlspecialchars($nombreUsuario) ?>
            </strong>

        </div>


    </div>


    <p class="descripcion-panel">
        Seleccione una opción para consultar indicadores,
        generar reportes o gestionar información del sistema.
    </p>

</section>


    <!--
    ========================================================================
    DASHBOARDS
    ========================================================================
    -->

    <?php if (
        $puedeVerDashboard
        || (
            $puedeVerIndicadores
            && $puedeVerProduccion
        )
        || (
            $puedeVerIndicadores
            && $puedeVerInventario
        )
        || (
            $puedeVerIndicadores
            && $puedeVerVentas
        )
    ): ?>


        <section class="seccion">

            <div class="seccion-titulo">

                <h2>
                    Dashboards
                </h2>

                <p>
                    Visualización y análisis de
                    indicadores clave.
                </p>

            </div>


            <div class="grid">


                <?php if (
                    $puedeVerDashboard
                ): ?>

                    <a
                        class="tarjeta"
                        href="dashboard.php"
                    >

                        <div class="icono">
                            G
                        </div>

                        <h3>
                            Dashboard general
                        </h3>

                        <p>
                            Resumen general de ventas,
                            producción, inventario y
                            metas.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerIndicadores
                    && $puedeVerProduccion
                ): ?>

                    <a
                        class="tarjeta"
                        href="dashboard_produccion.php"
                    >

                        <div class="icono">
                            P
                        </div>

                        <h3>
                            Producción
                        </h3>

                        <p>
                            Producción por período,
                            comparaciones y cumplimiento
                            de metas.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerIndicadores
                    && $puedeVerInventario
                ): ?>

                    <a
                        class="tarjeta"
                        href="dashboard_inventario.php"
                    >

                        <div class="icono">
                            I
                        </div>

                        <h3>
                            Inventario
                        </h3>

                        <p>
                            Existencias, entradas,
                            salidas y comparación de
                            movimientos.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerIndicadores
                    && $puedeVerVentas
                ): ?>

                    <a
                        class="tarjeta"
                        href="dashboard_ventas.php"
                    >

                        <div class="icono">
                            V
                        </div>

                        <h3>
                            Ventas
                        </h3>

                        <p>
                            Montos vendidos, unidades,
                            comparaciones y productos
                            más vendidos.
                        </p>

                    </a>

                <?php endif; ?>


            </div>

        </section>


    <?php endif; ?>


    <!--
    ========================================================================
    REPORTES
    ========================================================================
    -->

    <?php if (
        $puedeVerReportes
    ): ?>


        <section class="seccion">

            <div class="seccion-titulo">

                <h2>
                    Reportes
                </h2>

                <p>
                    Consulta e impresión de información
                    por período.
                </p>

            </div>


            <div class="grid">


                <a
                    class="tarjeta"
                    href="reportes.php"
                >

                    <div class="icono">
                        R
                    </div>

                    <h3>
                        Generar reportes
                    </h3>

                    <p>
                        Consulte reportes de ventas,
                        producción e inventario según
                        los permisos asignados.
                    </p>

                </a>


                <?php if (
                    $puedeVerVentas
                ): ?>

                    <a
                        class="tarjeta"
                        href="reportes.php?tipo=ventas"
                    >

                        <div class="icono">
                            V
                        </div>

                        <h3>
                            Reporte de ventas
                        </h3>

                        <p>
                            Consulte ventas, cantidades,
                            montos y usuarios responsables.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerProduccion
                ): ?>

                    <a
                        class="tarjeta"
                        href="reportes.php?tipo=produccion"
                    >

                        <div class="icono">
                            P
                        </div>

                        <h3>
                            Reporte de producción
                        </h3>

                        <p>
                            Consulte producción,
                            cantidades y metas trabajadas.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerInventario
                ): ?>

                    <a
                        class="tarjeta"
                        href="reportes.php?tipo=inventario"
                    >

                        <div class="icono">
                            I
                        </div>

                        <h3>
                            Reporte de inventario
                        </h3>

                        <p>
                            Consulte entradas, salidas
                            y movimientos registrados.
                        </p>

                    </a>

                <?php endif; ?>


            </div>

        </section>


    <?php endif; ?>


    <!--
    ========================================================================
    OPERACIONES
    ========================================================================
    -->

    <?php if (
        $puedeGestionarMetas
        || $puedeVerProduccion
        || $puedeRegistrarProduccion
        || $puedeVerInventario
        || $puedeVerMovimientos
        || $puedeRegistrarMovimientos
        || $puedeVerVentas
        || $puedeRegistrarVentas
    ): ?>


        <section class="seccion">

            <div class="seccion-titulo">

                <h2>
                    Operaciones
                </h2>

                <p>
                    Registro y consulta de las
                    actividades principales.
                </p>

            </div>


            <div class="grid">


                <?php if (
                    $puedeGestionarMetas
                ): ?>

                    <a
                        class="tarjeta"
                        href="metas.php"
                    >

                        <div class="icono">
                            M
                        </div>

                        <h3>
                            Metas de producción
                        </h3>

                        <p>
                            Registrar, editar y administrar
                            las metas de producción.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerProduccion
                ): ?>

                    <a
                        class="tarjeta"
                        href="produccion.php"
                    >

                        <div class="icono">
                            P
                        </div>

                        <h3>
                            Registros de producción
                        </h3>

                        <p>
                            Consultar el historial de
                            producción registrado.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeRegistrarProduccion
                ): ?>

                    <a
                        class="tarjeta"
                        href="produccion_crear.php"
                    >

                        <div class="icono">
                            +
                        </div>

                        <h3>
                            Registrar producción
                        </h3>

                        <p>
                            Registrar nuevas cantidades
                            producidas asociadas a una meta.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerInventario
                ): ?>

                    <a
                        class="tarjeta"
                        href="inventario.php"
                    >

                        <div class="icono">
                            I
                        </div>

                        <h3>
                            Inventario
                        </h3>

                        <p>
                            Consultar artículos,
                            existencias y estado actual.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerMovimientos
                ): ?>

                    <a
                        class="tarjeta"
                        href="movimientos.php"
                    >

                        <div class="icono">
                            ↔
                        </div>

                        <h3>
                            Movimientos
                        </h3>

                        <p>
                            Consultar entradas y salidas
                            registradas en inventario.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeRegistrarMovimientos
                ): ?>

                    <a
                        class="tarjeta"
                        href="movimiento_crear.php"
                    >

                        <div class="icono">
                            +
                        </div>

                        <h3>
                            Registrar movimiento
                        </h3>

                        <p>
                            Registrar entradas o salidas
                            y actualizar existencias.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeVerVentas
                ): ?>

                    <a
                        class="tarjeta"
                        href="ventas.php"
                    >

                        <div class="icono">
                            V
                        </div>

                        <h3>
                            Ventas
                        </h3>

                        <p>
                            Consultar el historial de
                            ventas registradas.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeRegistrarVentas
                ): ?>

                    <a
                        class="tarjeta"
                        href="venta_crear.php"
                    >

                        <div class="icono">
                            +
                        </div>

                        <h3>
                            Registrar venta
                        </h3>

                        <p>
                            Registrar cantidades vendidas
                            y montos de venta.
                        </p>

                    </a>

                <?php endif; ?>


            </div>

        </section>


    <?php endif; ?>


    <!--
    ========================================================================
    ADMINISTRACIÓN
    ========================================================================
    -->

    <?php if (
        $puedeGestionarUsuarios
        || $puedeGestionarRoles
        || $puedeGestionarPermisos
        || $puedeGestionarAreas
        || $puedeGestionarEmpleados
        || $puedeGestionarInventario
    ): ?>


        <section class="seccion">

            <div class="seccion-titulo">

                <h2>
                    Administración
                </h2>

                <p>
                    Mantenimiento de información
                    administrativa del sistema.
                </p>

            </div>


            <div class="grid">


                <?php if (
                    $puedeGestionarUsuarios
                ): ?>

                    <a
                        class="tarjeta"
                        href="usuarios.php"
                    >

                        <div class="icono">
                            U
                        </div>

                        <h3>
                            Usuarios
                        </h3>

                        <p>
                            Registrar, editar y administrar
                            usuarios del sistema.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeGestionarRoles
                    && $puedeGestionarPermisos
                ): ?>

                    <a
                        class="tarjeta"
                        href="roles.php"
                    >

                        <div class="icono">
                            R
                        </div>

                        <h3>
                            Roles y permisos
                        </h3>

                        <p>
                            Administrar funciones y
                            permisos asociados a cada rol.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeGestionarAreas
                ): ?>

                    <a
                        class="tarjeta"
                        href="areas.php"
                    >

                        <div class="icono">
                            A
                        </div>

                        <h3>
                            Áreas
                        </h3>

                        <p>
                            Registrar y administrar
                            las áreas de la organización.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeGestionarEmpleados
                ): ?>

                    <a
                        class="tarjeta"
                        href="empleados.php"
                    >

                        <div class="icono">
                            E
                        </div>

                        <h3>
                            Empleados
                        </h3>

                        <p>
                            Gestionar información de
                            empleados y sus áreas.
                        </p>

                    </a>

                <?php endif; ?>


                <?php if (
                    $puedeGestionarInventario
                ): ?>

                    <a
                        class="tarjeta"
                        href="inventario.php"
                    >

                        <div class="icono">
                            I
                        </div>

                        <h3>
                            Gestión de inventario
                        </h3>

                        <p>
                            Registrar y editar artículos
                            del inventario.
                        </p>

                    </a>

                <?php endif; ?>


            </div>

        </section>


    <?php endif; ?>


</main>


</body>

</html>