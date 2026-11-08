<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';

if (isset($_SESSION['usuario_id'])) {

    header('Location: panel.php');
    exit;
}

header('Location: login.php');
exit;