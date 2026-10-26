<?php require __DIR__ . '/header.php'; ?>
<?php $post = $post ?? ['title' => '', 'category' => '', 'body' => '']; ?>

<h1><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
<p><strong>Categoría:</strong> <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></p>

<div class="contenido-post">
    <!-- nl2br() convierte los saltos de línea del textarea en etiquetas <br> de HTML -->
    <p><?php echo nl2br(htmlspecialchars($post['body'], ENT_QUOTES, 'UTF-8')); ?></p>
</div>

<a href="/">Volver al listado</a>

<hr>
<h2>Comentarios</h2>

<!-- Listado de comentarios -->
<?php if (empty($comments)): ?>
    <p>No hay comentarios todavía. ¡Sé el primero!</p>
<?php else: ?>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li style="margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <p><?php echo nl2br(htmlspecialchars($comment['body'], ENT_QUOTES, 'UTF-8')); ?></p>
                <small>
                    Escrito por Usuario ID: <?php echo htmlspecialchars((string)$comment['user_id'], ENT_QUOTES, 'UTF-8'); ?>
                    <!-- Si tu tabla tiene created_at, puedes descomentar esto: -->
                    <!-- el <?php //echo $comment['created_at']; ?> -->
                </small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Formulario para añadir comentario (SOLO SI ESTÁ LOGUEADO) -->
<?php if (isset($_SESSION['user_id'])): ?>
    <h3>Añadir un comentario</h3>
    <form action="/comment/store" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <!-- El post_id va oculto para saber en qué post estamos comentando -->
        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
        
        <div>
            <textarea name="body" rows="3" required placeholder="Escribe tu comentario aquí..."></textarea>
        </div>
        <button type="submit">Enviar comentario</button>
    </form>
<?php else: ?>
    <p><a href="/login">Inicia sesión</a> para dejar un comentario.</p>
<?php endif; ?>