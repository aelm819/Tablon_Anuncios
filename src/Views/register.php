<?php require __DIR__ . '/header.php'; ?>
	<main>
		<h1>Crear cuenta</h1>
		<?php if (isset($error)): ?>
			<p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
		<?php endif; ?>
		<form action="/register" method="post">
			<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
			<label for="email">Email</label>
			<input id="email" name="email" type="email" autocomplete="email" required>
			<label for="password">Contraseña</label>
			<input id="password" name="password" type="password" autocomplete="new-password" required>
			<button type="submit">Registrarse</button>
		</form>
	</main>
</body>
</html>
			