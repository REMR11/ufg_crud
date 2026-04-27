# Estado de migracion Laravel

Se implemento la migracion funcional de codigo (modelos, migraciones, servicios, requests, controladores y vistas Blade) en `laravel_app`.

## Bloqueo de entorno detectado

En este equipo, `php` y `composer` no estan disponibles en PATH, por lo que no fue posible inicializar el esqueleto oficial Laravel via `composer create-project`.

## Pasos para ejecutar en tu entorno

1. Instalar PHP 8.2+ y Composer.
2. Crear esqueleto Laravel en `laravel_app` o copiar estos archivos sobre un Laravel limpio.
3. Instalar dependencias:
   - `composer install`
4. Configurar `.env` y ejecutar:
   - `php artisan key:generate`
   - `php artisan migrate`
   - `php artisan storage:link`
5. Instalar auth base:
   - `composer require laravel/breeze --dev`
   - `php artisan breeze:install blade`
   - `npm install && npm run build`
6. Ejecutar pruebas y servidor:
   - `php artisan test`
   - `php artisan serve`

## Componentes migrados

- Rutas: `routes/web.php`
- Modelos: `app/Models/*`
- Reglas de negocio: `app/Services/HorarioService.php`, `app/Services/AlumnoCarreraService.php`
- Validaciones: `app/Http/Requests/*`
- Controladores: `app/Http/Controllers/*`
- Vistas Blade: `resources/views/*`
- JS de formularios: `public/js/form-validation.js`
