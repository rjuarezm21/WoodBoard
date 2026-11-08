<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';

use App\Business\Controllers\AuthController;
use App\Business\Services\AuthService;
use App\Data\Repositories\UsuarioRepository;


/*
|--------------------------------------------------------------------------
| 1. Crear conexión PDO
|--------------------------------------------------------------------------
*/

$crearConexion = require __DIR__ . '/../config/database.php';

$pdo = $crearConexion();


/*
|--------------------------------------------------------------------------
| 2. Crear Repository
|--------------------------------------------------------------------------
*/

$usuarioRepository = new UsuarioRepository($pdo);


/*
|--------------------------------------------------------------------------
| 3. Crear Service
|--------------------------------------------------------------------------
*/

$authService = new AuthService(
    $usuarioRepository
);


/*
|--------------------------------------------------------------------------
| 4. Crear Controller
|--------------------------------------------------------------------------
*/

$authController = new AuthController(
    $authService
);


/*
|--------------------------------------------------------------------------
| 5. Si ya inició sesión, enviarlo al panel
|--------------------------------------------------------------------------
*/

if ($authController->estaAutenticado()) {

    header('Location: panel.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| 6. Variables para la View
|--------------------------------------------------------------------------
*/

$error = null;


/*
|--------------------------------------------------------------------------
| 7. Procesar formulario
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = (string) ($_POST['correo'] ?? '');
    $contrasena = (string) ($_POST['contrasena'] ?? '');

    $autenticado = $authController->iniciarSesion(
        $correo,
        $contrasena
    );

    if ($autenticado) {

        header('Location: panel.php');
        exit;
    }

    $error = 'Correo o contraseña incorrectos.';
}


/*
|--------------------------------------------------------------------------
| 8. Mostrar la View
|--------------------------------------------------------------------------
*/

require __DIR__
    . '/../app/Presentation/Views/login.php';