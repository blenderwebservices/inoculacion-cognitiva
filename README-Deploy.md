Resumen del Trabajo Realizado
Inicialización y Dependencias:

Se creó el proyecto Laravel 13 en el subdirectorio backend.
Se configuró la base de datos SQLite local.
Se instaló Filament PHP (v5.6) y se registró el proveedor de paneles administrativos /admin.
Se instaló el SDK de Laravel AI (laravel/ai).
Modelos, Migraciones y Seeders:

Se añadió la columna role a la tabla users (con valores por defecto 'user').
Se diseñaron las migraciones y modelos Eloquent para AiVendor, AiModel y AiProvider (con soporte para las métricas y mentiras de HCS).
Se crearon seeders para pre-cargar los proveedores de IA (Gemini, OpenAI, Ollama), los 3 bots predeterminados de los ejercicios y los usuarios de prueba:
Piloto (User): user@habanero.com / password
Administrador (Admin): admin@habanero.com / password
Filament Resource (AiProviderResource):

Panel de administración CRUD en /admin que restringe el acceso solo a usuarios con rol admin.
Formulario que permite configurar credenciales, system prompts, temperaturas y la lista de mentiras del agente (utilizando un componente de tags).
Lógica del Agente y API REST:

Implementado el agente en backend/app/Ai/Agents/CognitiveAgent.php.
Creado ApiController.php para gestionar autenticación de sesiones, CRUD de bots y chat.
Si el administrador ingresa la API Key en Filament, la llamada a CognitiveAgent->prompt() inyecta dinámicamente dicha clave para conectar con Gemini u OpenAI.
Si no hay llave de API registrada, el controlador activa un Mock LLM Fallback que replica las respuestas correctas de los ejercicios para que sigan siendo completamente interactivos y testeables de inmediato.
Modificaciones del Frontend React:

Se actualizó vite.config.ts para redireccionar llamadas de /api al puerto 8000.
Se cambiaron las URLs absolutas en el cliente a rutas relativas (/api/...).
Creado src/views/Login.tsx con botones de inicio de sesión rápido para Admin y User.
Se actualizó src/App.tsx para verificar la sesión en el inicio y, si el usuario es admin, renderizar el botón hacia el panel de Filament.
Tanto el servidor web de Laravel (http://localhost:8000) como el servidor de desarrollo de React (http://localhost:5173) están activos y corriendo de fondo concurrentemente.