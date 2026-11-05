# Tuldev — landing + panel

Landing de Tuldev ("software a la medida", Tulancingo, Hidalgo). El diseño aprobado vive en `design/index.html` (assets en `design/assets/`) y es la referencia al pixel. Instrucciones completas del proyecto: `PROMPT.md`.

## Stack
- Laravel 13, Filament 5 (panel en `/admin`), Livewire 4, MySQL 8 (Herd, base `tuldev`), Vite, Pest 4.
- Ajustes del sitio: `spatie/laravel-settings` + plugin de Filament.
- Correo: Resend (`MAIL_MAILER=resend`); en local `log`. Colas: driver `database`.
- Locale `es`, Faker `es_MX`, zona `America/Mexico_City`. Traducciones en `lang/es` (laravel-lang).
- Front público sin Tailwind: CSS propio en `resources/css/landing.css` (clases `cm-*`, sin cambiar valores del diseño). JS en `resources/js/landing.js`.
- Fuentes autoalojadas con `@fontsource` (Plus Jakarta Sans 400–800, JetBrains Mono 500–600).

## Comandos
- `composer install` y `npm install` (el `.npmrc` fuerza `legacy-peer-deps` por un bug de npm 10.8 con Arborist).
- `php artisan migrate:fresh --seed` — recrea la base con el contenido inicial.
- `npm run dev` / `npm run build` — Vite.
- `./vendor/bin/pest` — pruebas.
- URL local: https://tuldev.test (Herd).
- Admin: seeder crea usuario solo si `ADMIN_EMAIL` y `ADMIN_PASSWORD` están en `.env`; si no, `php artisan make:filament-user`.

## Despliegue (Dokploy)
- `Dockerfile.prod` (rama `main`) y `Dockerfile.dev` (ambiente de pruebas); la configuración de runtime vive en `docker/app/`.
- Contenedor único: nginx + php-fpm + colas, en el puerto **8000** (Container Port en Dokploy). No hay scheduler porque no hay tareas programadas.
- El arranque corre las migraciones, pero no los seeders: la primera vez, `php artisan db:seed --force` en la terminal del contenedor.
- `storage/` debe ser un volumen persistente: ahí viven las imágenes subidas desde el panel.

## Estructura
- `app/Filament/` Resources, páginas y widgets · `app/Models/` · `app/Settings/` · `app/Livewire/` formulario de contacto.
- `resources/views/components/landing/` un componente Blade por sección.
- Secciones editables desde Filament: servicios, portafolio, apps, tecnologías, proceso, preguntas frecuentes, cifras y testimonios (las secciones sin contenido publicado no se muestran).
- Páginas legales (`legal_pages`): aviso de privacidad y términos, editables en Filament; los marcadores {{responsable}}, {{domicilio}}, {{correo_privacidad}}, {{sitio}} y {{fecha}} se reemplazan con Ajustes. Son una base: debe revisarlas un abogado.
- `public/brand/` logotipos e isotipo para el panel.

## Reglas
- Todo el texto, imágenes y listados de la landing salen de la base de datos; en Blade solo la estructura.
- No inventar datos de la empresa (teléfonos, direcciones, precios, cifras). Si faltan, campo vacío en Ajustes.
- Nunca escribir credenciales en código; van en `.env`.
- Trabajar siempre en la rama `dev`, nunca directo en `main`. Commits por fase, en español.
- Repositorio: https://github.com/alainlemus/tuldev
- Cada cambio de contenido limpia la caché de la landing.
