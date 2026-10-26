<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablón de Anuncios</title>
    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9; /* Gris muy suave */
            color: #334155;
        }

        /* Contenedor principal para centrar el contenido en todas las vistas */
        main, .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #0f172a;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #2563eb;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #1d4ed8;
        }

        /* Menú superior moderno */
        .menu-usuario {
            background-color: #ffffff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        /* Agrupamos las opciones para que queden alineadas a la derecha */
        .menu-opciones {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-usuario > a:first-child {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }

        .menu-usuario span {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Estilo de tarjetas (Posts) */
        ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        li {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        li:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Formularios y Buscador */
        form {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        /* Buscador del index en una sola línea */
        form[action="/"] {
            display: flex;
            gap: 10px;
            padding: 15px 25px;
        }

        form[action="/"] input {
            margin: 0;
            flex: 1;
        }

        form[action="/"] button {
            margin: 0;
            white-space: nowrap;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        button, .btn {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background-color 0.2s ease;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background-color: #1d4ed8;
        }

        /* Botón de crear publicación */
        .btn-crear {
            background-color: #10b981 !important;
            color: white !important;
            padding: 8px 16px !important;
            border-radius: 6px;
        }

        .btn-crear:hover {
            background-color: #059669 !important;
        }
    </style>
</head>
<body>
    <header>
        <nav class="menu-usuario">
            <!-- Título alineado a la izquierda -->
            <a href="/">Mi Tablón de Anuncios</a>
            
            <!-- Opciones alineadas a la derecha -->
            <div class="menu-opciones">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?></span>
                    <a href="/create" class="btn-crear">Crear publicación</a>
                    <a href="/logout">Cerrar sesión</a>
                <?php else: ?>
                    <a href="/login">Iniciar sesión</a>
                    <a href="/register">Registrarse</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    
    <!-- IMPORTANTE: El html y el body se cierran en las otras vistas -->