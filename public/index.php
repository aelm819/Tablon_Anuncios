<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Core\Database;
use App\Models\User;

require dirname(__DIR__) . '/vendor/autoload.php';

// 1. Iniciar sesión y seguridad CSRF
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. Cargar dependencias y conexión a la base de datos
require dirname(__DIR__) . '/vendor/autoload.php';
$db = new \App\Core\Database();

// 3. Instanciar controladores
$postController = new \App\Controllers\PostController($db);
$authController = new \App\Controllers\AuthController($db);
$commentController = new \App\Controllers\CommentController($db);

// 4. Sistema de Enrutamiento (Router)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '/index.php':
        $postController->index();
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login(); // Procesa los datos
        } else {
            $authController->showLoginForm(); // Muestra la pantalla
        }
        break;

    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register(); // Procesa los datos
        } else {
            $authController->showRegisterForm(); // Muestra la pantalla
        }
        break;

    case '/logout':
        $authController->logout(); // Asegúrate de tener este método en AuthController
        break;

    case '/show':
        $postController->show();
        break;

    case '/create':
        $postController->create();
        break;

    case '/store':
        $postController->store();
        break;

    case '/edit':
        $postController->edit();
        break;

    case '/update':
        $postController->update();
        break;

    case '/destroy':
        $postController->destroy();
        break;

    case '/comment/store':
        $commentController->store();
        break;

    default:
        http_response_code(404);
        echo "Error 404: Página no encontrada";
        break;
}
