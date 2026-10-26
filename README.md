# Tablon de anuncios

Aplicacion web para publicar y consultar anuncios. Los usuarios pueden registrarse, iniciar sesion, gestionar sus propias publicaciones y comentar anuncios.

## Funcionalidades

- Listado y busqueda de publicaciones.
- Registro, inicio y cierre de sesion.
- Creacion, edicion y eliminacion de publicaciones propias.
- Vista de detalle y comentarios en cada publicacion.
- Proteccion CSRF en las operaciones que modifican datos.
- Control de acceso para las acciones de usuarios autenticados.

## Tecnologias

- PHP 8.2 con Apache.
- MySQL 8.4 y PDO.
- Docker Compose.
- phpMyAdmin para administrar la base de datos.

Compose tambien inicia un servicio Redis, aunque la aplicacion actualmente no lo utiliza.

## Requisitos

- Docker Engine y Docker Compose.
- Puertos `8080` y `8081` disponibles en el equipo.

## Puesta en marcha

1. Desde la raiz del proyecto, construye e inicia los servicios:

	```bash
	docker compose up -d --build
	```

2. En una base de datos nueva, carga el esquema y los datos de ejemplo. El archivo no se importa automaticamente al iniciar los contenedores; ejecuta este paso una sola vez:

	```bash
	docker compose exec -T db mysql -uroot -plaquesea tablon_anuncios < database.sql
	```

3. Abre la aplicacion en [http://localhost:8080](http://localhost:8080).

Para administrar MySQL, abre [http://localhost:8081](http://localhost:8081). En esta configuracion local, phpMyAdmin se conecta al servicio `db`; la base de datos se llama `tablon_anuncios`.

## Configuracion

La conexion se define en `config.php` y Compose monta ese archivo dentro del contenedor. Los valores actuales son:

| Parametro | Valor local |
| --- | --- |
| Host MySQL | `db` |
| Base de datos | `tablon_anuncios` |
| Usuario | `root` |
| Contrasena | `laquesea` |

Estas credenciales son solo para desarrollo local. Cambialas antes de desplegar la aplicacion en un entorno accesible desde Internet.

## Rutas principales

| Ruta | Funcion |
| --- | --- |
| `/` | Listado y busqueda de anuncios |
| `/login` | Inicio de sesion |
| `/register` | Registro |
| `/logout` | Cierre de sesion |
| `/show?id=1` | Detalle y comentarios de un anuncio |
| `/create` | Formulario para publicar un anuncio |
| `/edit?id=1` | Edicion de una publicacion propia |

Las rutas amigables se dirigen a `public/index.php` mediante `public/.htaccess`.

## Estructura

```text
public/            Punto de entrada y reglas de Apache
src/Controllers/   Controladores y enrutamiento de acciones
src/Models/        Acceso a usuarios, publicaciones y comentarios
src/Core/          Conexion a la base de datos
src/Views/         Plantillas de la interfaz
database.sql       Esquema y datos de ejemplo
docker-compose.yml Servicios locales
```

## Pruebas

Los casos de prueba manuales de autenticacion, publicaciones, permisos, comentarios y CSRF estan en [TESTING.md](TESTING.md).