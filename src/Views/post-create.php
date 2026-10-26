<?php require __DIR__ . '/header.php'; ?>

<h1>Crear Nueva Publicación</h1>

<!-- Ajusta el action según las rutas de tu Front Controller -->
<form method="POST" action="/store">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="title">Título:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="category">Categoría:</label><br>
    <input type="text" name="category" id="category" required><br><br>

    <label for="body">Contenido:</label><br>
    <textarea name="body" id="body" rows="6" required></textarea><br><br>

    <button type="submit">Publicar</button>
</form>