# Plan de Pruebas Manual - Tablón de Anuncios

A continuación se detallan los casos de prueba para validar la funcionalidad y seguridad de la aplicación.

## 1. Autenticación y Sesiones 🔐
*   **[1.1] Registro normal:** 
    *   *Acción:* Rellenar el formulario de registro con un email nuevo y contraseña válida.
    *   *Resultado esperado:* El usuario se guarda en BD, inicia sesión automáticamente y redirige a la home.
    *   *Resultado obtenido:* [Pendiente]
*   **[1.2] Registro duplicado (Caso de error):** 
    *   *Acción:* Intentar registrarse con un email que ya existe en la base de datos.
    *   *Resultado esperado:* Rechaza el registro y muestra un mensaje de error ("El email ya está en uso" o similar).
    *   *Resultado obtenido:* [Pendiente]
*   **[1.3] Control de acceso de invitados (Caso límite):**
    *   *Acción:* Escribir manualmente en la URL la ruta de crear post (ej. `/create`) sin estar logueado.
    *   *Resultado esperado:* Redirección inmediata a `/login` sin mostrar el formulario.
    *   *Resultado obtenido:* [Pendiente]

## 2. Gestión de Publicaciones (Posts) 📝
*   **[2.1] Creación de Post:**
    *   *Acción:* Loguearse, rellenar el formulario de "Nuevo Anuncio" y enviarlo.
    *   *Resultado esperado:* Redirige a la home. El anuncio aparece en el listado y en la BD tiene mi `user_id`.
    *   *Resultado obtenido:* [Pendiente]
*   **[2.2] Búsqueda de Posts (Filtro):**
    *   *Acción:* En la home, usar el buscador introduciendo una palabra que exista en el título de un anuncio.
    *   *Resultado esperado:* La lista se actualiza mostrando solo los anuncios que coinciden con la búsqueda.
    *   *Resultado obtenido:* [Pendiente]

## 3. Autorización (Permisos) 🛡️
*   **[3.1] Editar post ajeno (Caso de seguridad):**
    *   *Acción:* Loguearse con el Usuario A. Escribir manualmente en la URL la ruta para editar un post creado por el Usuario B (ej. `/edit?id=5`).
    *   *Resultado esperado:* La aplicación detiene la carga y muestra "Error 403: Prohibido. No tienes permiso para editar esta publicación."
    *   *Resultado obtenido:* [Pendiente]
*   **[3.2] Borrar post propio:**
    *   *Acción:* Pulsar el botón/formulario de borrar en un anuncio que yo mismo he creado.
    *   *Resultado esperado:* El anuncio desaparece de la home y se elimina de la base de datos.
    *   *Resultado obtenido:* [Pendiente]

## 4. Comentarios 💬
*   **[4.1] Comentar un post:**
    *   *Acción:* Entrar al detalle de un anuncio, rellenar el comentario y enviarlo.
    *   *Resultado esperado:* Redirección al mismo anuncio. El comentario aparece abajo ordenado por fecha y asociado a mi usuario.
    *   *Resultado obtenido:* [Pendiente]
*   **[4.2] Integridad de comentarios (Caso de seguridad):**
    *   *Acción:* Intentar inspeccionar el código HTML del formulario de comentario para cambiar el `user_id`.
    *   *Resultado esperado:* No es posible manipularlo desde el HTML porque el controlador coge el `user_id` de la sesión (`$_SESSION['user_id']`), no del formulario.
    *   *Resultado obtenido:* [Pendiente]

## 5. Seguridad CSRF 🚫
*   **[5.1] Petición sin token:**
    *   *Acción:* Usar las herramientas de desarrollador del navegador (F12) para borrar el campo `<input type="hidden" name="csrf_token">` antes de enviar un nuevo post o comentario.
    *   *Resultado esperado:* La aplicación bloquea la acción mostrando "Error 403: Petición no válida (Fallo de seguridad CSRF)."
    *   *Resultado obtenido:* [Pendiente]