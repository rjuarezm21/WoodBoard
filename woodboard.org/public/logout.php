<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\AuthController;
use App\Business\Services\AuthService;
use App\Data\Repositories\UsuarioRepository;


/*
|--------------------------------------------------------------------------
| Crear conexión
|--------------------------------------------------------------------------
*/

$crearConexion = require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| Crear dependencias
|--------------------------------------------------------------------------
*/

$usuarioRepository = new UsuarioRepository($pdo);

$authService = new AuthService(
    $usuarioRepository
);

$authController = new AuthController(
    $authService
);


/*
|--------------------------------------------------------------------------
| Cerrar sesión
|--------------------------------------------------------------------------
*/

$authController->cerrarSesion();


/*
|--------------------------------------------------------------------------
| Regresar al login
|--------------------------------------------------------------------------
*/

header('Location: login.php');
exit;