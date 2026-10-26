<?php require __DIR__ . '/header.php'; ?>

<h1>Listado de Publicaciones</h1>

<!-- Buscador -->
<form method="GET" action="/">
    <input type="text" name="keyword" placeholder="Buscar por título o categoría..." 
           value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <button type="submit">Buscar</button>
</form>

<?php if (empty($posts)): ?>
    <p>No se encontraron publicaciones.</p>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <h3>
                    <a href="/show?id=<?php echo $post['id']; ?>">
                        <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h3>
                <p>Categoría: <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></p>
                
                <!-- Autorización: Solo el dueño ve los botones de editar y borrar -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
                    <a href="/edit?id=<?php echo $post['id']; ?>">Editar</a>
                    
                    <form method="POST" action="/destroy" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta publicación?');">Borrar</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>