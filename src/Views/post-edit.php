<?php require __DIR__ . '/header.php'; ?>
<?php $post = $post ?? []; ?>

<h1>Editar Publicación</h1>

<form method="POST" action="/update">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <!-- Campo oculto vital para saber qué post estamos actualizando -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

    <label for="title">Título:</label><br>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label for="category">Categoría:</label><br>
    <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($post['category'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label for="body">Contenido:</label><br>
    <textarea name="body" id="body" rows="6" required><?php echo htmlspecialchars($post['body'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea><br><br>

    <button type="submit">Guardar Cambios</button>
</form>