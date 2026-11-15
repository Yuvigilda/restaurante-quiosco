# Restaurantelb

Quiosco de restaurante. React muestra el menú y Laravel responde el API. Los dos viven en el mismo sitio.

- Frontend: `lbreactquiosco` (React + Vite)
- Backend: `lblaravelquiosco` (Laravel 13, PHP 8.3, MySQL)

## Por qué no abría en DOM Cloud

DOM Cloud publica la carpeta `public` de Laravel. En este repositorio esa carpeta está en `lblaravelquiosco/public`, no en la raíz. Sin un script de despliegue el servidor no instala `vendor`, no crea el `.env`, no migra MySQL y no compila React. Además el frontend llamaba a `http://localhost:8000`, así que el navegador del visitante buscaba la API en su propia computadora.

## Desarrollo local

Backend:

```bash
cd lblaravelquiosco
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Frontend, en otra terminal:

```bash
cd lbreactquiosco
npm install
npm run dev
```

`lbreactquiosco/.env.local` debe tener:

```
VITE_API_URL=http://127.0.0.1:8000
```

## Despliegue en DOM Cloud

1. Sube estos cambios a `main` en GitHub.
2. En DOM Cloud abre el sitio, entra a **Setup → Deploy** y crea una tarea.
3. Borra el script que haya y pega el contenido de `domcloud.yml`.
4. En esa tarea cambia `CAMBIA-ESTA-CLAVE1+` por una contraseña tuya. Debe tener al menos 8 caracteres, una letra, un número y un símbolo.
5. Ejecuta la tarea y espera a que termine sin errores.
6. Entra a `https://TU-DOMINIO/auth/login` con el correo `admin@TU-DOMINIO` y la contraseña que pusiste.

La primera vez el script clona el repositorio, instala PHP 8.3, Node LTS y MySQL, compila React y copia el resultado dentro de `lblaravelquiosco/public`. Nginx usa esa carpeta como raíz: los archivos estáticos salen directo y `/api` entra a Laravel.

En el siguiente despliegue borra la línea `source:` del script antes de ejecutarlo. Si la dejas, DOM Cloud vacía `public_html` y se pierden las fotos subidas desde el panel. La base MySQL no se borra.

Si la tarea dice que PHP 8.3 no existe, cambia `php 8.3` por `php latest` y vuelve a ejecutarla. Laravel 13 no arranca con PHP 8.2 o menor.
