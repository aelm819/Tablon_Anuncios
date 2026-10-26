<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Models\Post;
use App\Models\Comment;

class PostController
{

    public function __construct(protected Database $db) {}

    // Muestra la vista de los posts y maneja la búsqueda
    public function index(): void
    {
        $keyword = $_GET['keyword'] ?? '';
        $postModel = new Post($this->db, 'posts');

        if ($keyword !== '') {
            $posts = $postModel->search($keyword);
        } else {
            $posts = $postModel->getAll();
        }

        require __DIR__ . '/../Views/posts.php';
    }

    // Muestra la vista de un post específico
    public function show(): void
    {
        // Capturamos el ID de $_GET  
        $id = (int)($_GET['id'] ?? 0);

        $postModel = new Post($this->db, 'posts');

        // Usamos getById para buscar la publicación
        $post = $postModel->getById($id);

        // ¿Qué pasa si el ID es inventado o no existe?  
        if ($post === null) {
            // Detenemos la ejecución y mostramos un error amigable
            echo "Error 404: La publicación que buscas no existe.";

            return;
        }

        //  Buscar los comentarios de este post
        $commentModel = new Comment($this->db, 'comments');
        $comments = $commentModel->getByPostId($id);

        // Si todo fue bien, cargamos la vista donde usaremos la variable $post
        require __DIR__ . '/../Views/post-detail.php';
    }

    // Mostrar el formulario para crear un post
    public function create(): void
    {
        // Si NO hay sesión, redirigimos al login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Si pasa la validación, mostramos la vista del formulario
        require __DIR__ . '/../Views/post-create.php';
    }

    // Guardar el nuevo post en la base de datos
    public function store(): void
    {
        // Si NO hay sesión, redirigimos al login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Comprobar que los datos vienen por el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- PROTECCIÓN CSRF ---
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                http_response_code(403);
                die("Error 403: Token CSRF inválido o ausente.");
            }

            // Preparamos los datos.  .
            $data = [
                'title'     => $_POST['title'],
                'category'  => $_POST['category'],
                'body'      => $_POST['body'],
                'user_id'   => $_SESSION['user_id']
            ];

            // Instanciamos el modelo e insertamos
            $postModel = new Post($this->db, 'posts');
            $postModel->insert($data);

            // Redirigimos al listado principal
            header('Location: /');
            exit;
        }
    }

    // Mostrar formulario de edición
    public function edit(): void
    {
        // Autenticación (¿Estás logueado?)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $postModel = new Post($this->db, 'posts');
        $post = $postModel->getById($id);

        if ($post === null) {
            echo "Error 404: La publicación no existe.";
            return;
        }

        // Autorización (¿Eres el dueño?)
        if ($post['user_id'] !== $_SESSION['user_id']) {
            http_response_code(403);
            echo "Error 403: Prohibido. No tienes permiso para editar esta publicación.";
            return;
        }

        require __DIR__ . '/../Views/post-edit.php';
    }

    // Actualizar el post en la base de datos
    public function update(): void
    {
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

            $id = (int)$_POST['id'];

            $postModel = new Post($this->db, 'posts');
            $post = $postModel->getById($id);

            // Volvemos a comprobar la autorización antes de guardar
            if ($post === null || $post['user_id'] !== $_SESSION['user_id']) {
                http_response_code(403);
                echo "Error 403: Prohibido.";
                return;
            }

            $data = [
                'title'     => $_POST['title'],
                'category'  => $_POST['category'],
                'body'      => $_POST['body']
            ];

            $postModel->update($id, $data);
            header('Location: /');
            exit;
        }
    }

    // Eliminar el post
    public function destroy(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Para borrar de forma segura, el ID debería llegar por POST  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- PROTECCIÓN CSRF ---
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                http_response_code(403);
                die("Error 403: Token CSRF inválido o ausente.");
            }

            $id = (int)$_POST['id'];

            $postModel = new Post($this->db, 'posts');
            $post = $postModel->getById($id);

            // Comprobamos si existe y si es el dueño
            if ($post !== null && $post['user_id'] === $_SESSION['user_id']) {
                $postModel->delete($id);
            } else {
                http_response_code(403);
                echo "Error 403: No tienes permiso para borrar esto.";
                return;
            }

            header('Location: /');
            exit;
        }
    }
}
