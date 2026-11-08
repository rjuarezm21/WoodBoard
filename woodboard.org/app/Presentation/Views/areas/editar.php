<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar área | Sistema de Indicadores</title>
    <style>
        :root {
            --azul-oscuro: #18253a;
            --azul: #315b88;
            --fondo: #f4f6f8;
            --blanco: #ffffff;
            --texto: #1e293b;
            --texto-secundario: #64748b;
            --borde: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--fondo);
            color: var(--texto);
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
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
        .header-titulo strong { color: var(--azul-oscuro); font-size: 18px; font-weight: 700; }
        .header-titulo span { color: var(--texto-secundario); font-size: 12px; }
        .volver-header {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 15px;
            color: var(--azul-oscuro);
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: background .18s ease, color .18s ease, border-color .18s ease;
        }
        .volver-header:hover { color: white; background: var(--azul-oscuro); border-color: var(--azul-oscuro); }
        main { width: 100%; max-width: 800px; margin: auto; padding: 38px 25px 55px; }
        .titulo-pagina { margin-bottom: 23px; }
        .titulo-pagina h1 { margin: 0 0 8px; color: var(--azul-oscuro); font-size: 27px; font-weight: 700; letter-spacing: -.4px; }
        .titulo-pagina p { margin: 0; color: var(--texto-secundario); font-size: 13px; line-height: 1.6; }
        .contenedor {
            background: white;
            padding: 30px;
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, .035);
        }
        .campo { margin-bottom: 22px; }
        label { display: block; margin-bottom: 9px; color: #334155; font-size: 13px; font-weight: 600; }
        input, textarea {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            color: var(--texto);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        input { height: 45px; }
        textarea { min-height: 120px; line-height: 1.55; resize: vertical; }
        input:focus, textarea:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(49, 91, 136, .12); }
        .error { margin-bottom: 22px; padding: 13px 15px; border: 1px solid #f0cccc; border-radius: 8px; background: #fdeeee; color: #a33131; font-size: 13px; line-height: 1.5; }
        .acciones { display: flex; align-items: center; gap: 11px; margin-top: 26px; padding-top: 21px; border-top: 1px solid #edf2f7; }
        button, .cancelar { display: inline-flex; align-items: center; justify-content: center; min-height: 43px; padding: 10px 19px; border-radius: 8px; font-family: inherit; font-size: 13px; font-weight: 600; text-decoration: none; transition: background .18s ease, border-color .18s ease, color .18s ease; }
        button { border: 1px solid var(--azul-oscuro); background: var(--azul-oscuro); color: white; cursor: pointer; }
        button:hover { background: #2a405b; border-color: #2a405b; }
        .cancelar { border: 1px solid #cbd5e1; background: white; color: #475569; }
        .cancelar:hover { background: #f1f5f9; }
        button:focus-visible, .cancelar:focus-visible, .volver-header:focus-visible { outline: 3px solid #9fc0df; outline-offset: 2px; }
        @media (max-width: 600px) {
            header { min-height: 68px; padding: 0 16px; gap: 12px; }
            .header-titulo strong { font-size: 15px; }
            .header-titulo span { font-size: 11px; }
            .volver-header { padding: 7px 10px; font-size: 11px; }
            main { padding: 24px 14px 40px; }
            .titulo-pagina h1 { font-size: 23px; }
            .contenedor { padding: 22px 18px; }
            .acciones { flex-direction: column; align-items: stretch; }
            button, .cancelar { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) { input, textarea, button, .cancelar, .volver-header { transition: none; } }
    </style>
</head>
<body>
<header>
    <div class="header-titulo">
        <strong>Sistema de Indicadores</strong>
        <span>Gestión de áreas</span>
    </div>
    <a class="volver-header" href="areas.php">Volver</a>
</header>
<main>
    <div class="titulo-pagina">
        <h1>Editar área</h1>
        <p>Modifique la información correspondiente al área seleccionada.</p>
    </div>
    <div class="contenedor">
        <?php if ($error !== null): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="campo">
                <label for="nombre_area">Nombre del área</label>
                <input
                    type="text"
                    id="nombre_area"
                    name="nombre_area"
                    value="<?= htmlspecialchars(
                        (string) (
                            $_POST['nombre_area']
                            ?? $area->getNombreArea()
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >
            </div>
            <div class="campo">
                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                ><?= htmlspecialchars(
                    (string) (
                        $_POST['descripcion']
                        ?? $area->getDescripcion()
                        ?? ''
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>
            </div>
            <div class="acciones">
                <button type="submit">Guardar cambios</button>
                <a class="cancelar" href="areas.php">Cancelar</a>
            </div>
        </form>
    </div>
</main>
</body>
</html>
