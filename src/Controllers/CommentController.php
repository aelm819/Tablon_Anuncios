<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Models\Comment;

class CommentController
{

    public function __construct(protected Database $db)
    {
    }

    public function store(): void
    {
        // Validar que esté logueado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- PROTECCIÓN CSRF ---
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                http_response_code(403);
                die("Error 403: Token CSRF inválido o ausente.");
            }

            $postId = (int)$_POST['post_id'];
            $body = $_POST['body'] ?? '';

            //  Preparar los datos. 
            $data = [
                'post_id' => $postId,
                'user_id' => $_SESSION['user_id'], 
                'body' => $body,
            ];

            // Guardar en BD
            $commentModel = new Comment($this->db, 'comments');
            $commentModel->insert($data);

            //Redirigir de vuelta al mismo post
            header('Location: /show?id=' . $postId);
            exit;
        }
    }
}