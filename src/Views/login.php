<?php require __DIR__ . '/header.php'; ?>
<main>
	<h1>Iniciar sesión</h1>
	<?php if (!empty($registered)): ?>
		<p>Cuenta creada. Ya puedes iniciar sesión.</p>
	<?php endif; ?>
	<?php if (isset($error)): ?>
		<p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
	<?php endif; ?>
	<?php if (isset($_GET['registrado']) && $_GET['registrado'] == 1): ?>
		<p style="color: #0f5132; background-color: #d1e7dd; padding: 10px; border-radius: 5px; border: 1px solid #badbcc;">
			¡Cuenta creada con éxito! Ya puedes iniciar sesión.
		</p>
	<?php endif; ?>
	<form action="/login" method="post">
		<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
		<label for="email">Email</label>
		<input id="email" name="email" type="email" autocomplete="email" required>
		<label for="password">Contraseña</label>
		<input id="password" name="password" type="password" autocomplete="current-password" required>
		<button type="submit">Iniciar sesión</button>
	</form>
	<p><a href="/register">Crear una cuenta</a></p>
</main>
</body>

</html>