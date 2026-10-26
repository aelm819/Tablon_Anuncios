-- 1. Creamos la base de datos (si no existe) y la usamos
CREATE DATABASE IF NOT EXISTS tablon_anuncios;
USE tablon_anuncios;

-- 2. Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla de publicaciones (posts)
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    body TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. Tabla de comentarios (1:N)
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. Inserción de datos de prueba
-- NOTA: Las contraseñas aquí son un hash de ejemplo de la palabra "123456" 
-- generado con password_hash(). ¡Nunca insertes texto plano aquí!
 -- 1. Insertar 5 usuarios (Contraseña para todos: 123456)
INSERT INTO users (email, password) VALUES 
('alumno1@iescelia.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),  
('alumno2@iescelia.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('marta@iescelia.org', '$2y$10$V0v1e.w.9eJ/m7n9Kz.X.euqO9Qe.h1n9y5X/T4oFzW4P.x0TqN.G'),
('carlos@iescelia.org', '$2y$10$V0v1e.w.9eJ/m7n9Kz.X.euqO9Qe.h1n9y5X/T4oFzW4P.x0TqN.G'),
('laura@iescelia.org', '$2y$10$V0v1e.w.9eJ/m7n9Kz.X.euqO9Qe.h1n9y5X/T4oFzW4P.x0TqN.G');

-- 2. Insertar 5 publicaciones (Posts)
INSERT INTO posts (user_id, title, body, category) VALUES 
(1, 'Vendo libro de DWES', 'Libro en perfecto estado, edición 2023. Atiendo rápido.', 'Ventas'),
(2, 'Busco grupo para proyecto', 'Me he quedado sin grupo, ¿alguien tiene un hueco?', 'Estudios'),
(3, 'Duda con Docker y Apache', 'No consigo arrancar el contenedor en Linux, ¿alguien me pasa su configuración?', 'Dudas'),
(4, 'Apuntes de Despliegue', 'He subido a mi GitHub un resumen con todos los comandos de Docker que entran en el examen.', 'Recursos'),
(5, 'Intercambio de clases', 'Se me da muy bien PHP pero sufro con CSS. ¿Alguien hacemos intercambio de clases?', 'Estudios');

-- 3. Insertar 5 comentarios
INSERT INTO comments (post_id, user_id, body) VALUES 
(1, 2, '¡Me interesa! ¿Por cuánto lo vendes?'),
(2, 1, 'Vente con nosotros, nos falta un integrante para cerrar el grupo.'),
(3, 4, 'Revisa que no tengas el puerto 8080 ya ocupado por otro servicio en tu máquina.'),
(4, 5, '¡Mil gracias por compartir esto! Me viene genial para repasar.'),
(1, 3, 'Si al final no se lo queda el compañero 2, avísame que me interesa el libro.');