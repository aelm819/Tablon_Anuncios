<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;

class AuthController
{
    // Recibimos la conexión a la base de datos para pasársela a los modelos
    public function __construct(protected Database $db) {}

    // Muestra la vista del formulario de registro
    public function showRegisterForm(): void
    {
        require __DIR__ . '/../Views/register.php';
    }

    // Procesa los datos de registro
    public function register(): void
    {

        // --- PROTECCIÓN CSRF ---
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            http_response_code(403);
            die("Error 403: Token CSRF inválido o ausente.");
        }

        // Encriptamos la contraseña
        $passwordEncriptada = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $data = [
            'email'    => $_POST['email'],
            'password' => $passwordEncriptada
        ];

        // Instanciamos el modelo y guardamos
        $userModel = new User($this->db, 'users');
        $userModel->insert($data);

        // Redirigimos al usuario al login
        header('Location: /login?registrado=1');
        exit;
    }

    // Muestra la vista del formulario de login
    public function showLoginForm(): void
    {
        require __DIR__ . '/../Views/login.php';
    }

    // Procesa el login e inicia la sesión
    public function login(): void
    {

        // --- PROTECCIÓN CSRF ---
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            http_response_code(403);
            die("Error 403: Token CSRF inválido o ausente.");
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new User($this->db, 'users');
        $userId = $userModel->findByEmail($email, $password);

        if ($userId !== null) {
            // Guardamos los datos  
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_email'] = $email;

            // Redirigimos al tablón de anuncios
            header('Location: /');
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    }

    // 5. Cierra la sesión
    public function logout(): void
    {
        // 1. Vaciamos el array de sesión por seguridad
        $_SESSION = [];

        // 2. Destruimos la sesión activa en el servidor
        session_destroy();

        // 3. Redirigimos al login
        header('Location: /login');
        exit;
    }
}
