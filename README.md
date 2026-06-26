<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


php artisan db:seed --class=DatabaseSeeder



He terminado de reorganizar y corregir la configuración del proyecto para que el backend de Laravel funcione directamente en la raíz de forma unificada con el frontend de React.

🛠️ Correcciones realizadas:
Fusión de package.json:

El archivo package.json en la raíz había sido sobrescrito por el del backend. He restaurado y fusionado las dependencias de React (react, lucide-react, express, etc.) y las herramientas de desarrollo del backend (tailwindcss, laravel-vite-plugin).
Actualicé los scripts para adaptarlos a la nueva estructura en la raíz:
json
"dev:frontend": "vite --config vite.config.ts",
"dev:backend": "php artisan serve --port=8000",
"dev": "concurrently \"npm run dev:frontend\" \"npm run dev:backend\"",
"build": "tsc -b && vite build --config vite.config.ts",
Evitar conflictos de Vite:

Al tener vite.config.js (Laravel) y vite.config.ts (React) en la misma raíz, configuré los scripts del frontend en el package.json para indicarle a Vite de forma explícita que use --config vite.config.ts. Esto evita que use por defecto la configuración de Laravel.
Instalación y Verificación:

Corrí npm install en la raíz para instalar todos los paquetes requeridos por el frontend.
Compilé el frontend (npm run build) para verificar que no hubiera errores de TypeScript o Vite.
Copié los archivos compilados de la carpeta dist/ a la carpeta public/ en la raíz (ahora contiene tanto index.html y la carpeta assets del front, como el index.php y los recursos de Filament del backend).
Confirmé que las rutas de inicialización en 

public/index.php
 apuntan correctamente a la raíz (/vendor/autoload.php y /bootstrap/app.php).
Sincronización en Git:

Commiteé y subí los cambios de configuración fusionados a tu rama remota origin/main bajo el mensaje: chore: merge package.json dependencies and scripts for unified root structure.
🚀 Cómo ejecutar y desplegar ahora:
En tu máquina local:
Como tu terminal ya tiene corriendo php artisan serve en el puerto 8000 en segundo plano, solo necesitas iniciar el servidor de desarrollo del frontend de React ejecutando en la raíz:

bash
npm run dev:frontend
(Si en algún momento detienes el servidor PHP, puedes correr npm run dev para iniciar ambos de forma concurrente, tal como lo hacías antes).

En tu servidor de producción:
Para desplegar la aplicación de forma simplificada en tu servidor con esta nueva estructura:

Haz un git pull en producción.
Asegúrate de apuntar el dominio de tu servidor web directamente a la carpeta /public en la raíz del proyecto.
Ejecuta composer install --no-dev para instalar las dependencias de PHP.
Compila el frontend con npm run build y copia los archivos resultantes a la carpeta /public ejecutando:
bash
npm run build && cp -R dist/* public/
¡Listo! Tu servidor de producción (Nginx o Apache) servirá el frontend de React por defecto al acceder al dominio, y Laravel resolverá las peticiones de /api/* y /admin sin necesidad de configuraciones complejas o múltiples sitios.



php artisan db:seed --class=DatabaseSeeder