# Prompt para Claude Code — Landing de Codemida (Laravel + Filament + MySQL)

> Copia todo lo que está debajo de la línea y pégalo en Claude Code, dentro de la carpeta del proyecto.
> Antes, copia la carpeta `design/` de este kit a la raíz del proyecto.

---

Vas a construir la landing page de **Codemida** ("software a la medida"), mi empresa de desarrollo de software en Tulancingo, Hidalgo. El diseño final ya está hecho y aprobado: está en `design/index.html` con sus imágenes en `design/assets/`. Tu trabajo es convertirlo en una aplicación **Laravel** con contenido administrable desde **Filament** y base de datos **MySQL**, respetando el diseño al pixel.

## 0. Antes de escribir código

1. Lee `design/index.html` completo y abre las imágenes de `design/assets/` para entender cada sección, el CSS y el JavaScript.
2. Verifica con Composer cuáles son las **últimas versiones estables** de Laravel y de Filament (y la versión de PHP que exigen). No fijes versiones de memoria. Usa la combinación más reciente compatible entre sí.
3. Revisa qué tengo instalado (`php -v`, `composer -V`, `node -v`, `mysql --version`) y avísame si algo no cumple los requisitos.
4. Muéstrame un **plan por fases** (las de abajo) y espera mi visto bueno antes de empezar.
5. Crea un `CLAUDE.md` en la raíz con las convenciones de este proyecto (stack, comandos, estructura, reglas de diseño) para futuras sesiones.

## 1. Stack y configuración

- Laravel (última estable), Filament (última estable) con panel en `/admin`, Livewire (el que trae Filament), MySQL 8, Vite.
- Idioma `es`, locale de Faker `es_MX`, zona horaria `America/Mexico_City`. Traducciones de validación en español.
- Base de datos: `codemida` (ya la crearé yo). Lee las credenciales de `.env`; nunca las escribas en código.
- Correo transaccional con **Resend** (`MAIL_MAILER=resend`, `RESEND_API_KEY` en `.env`). En local usa `log` si no hay llave.
- Colas con driver `database` para el envío de correos.
- Sin Tailwind en el front público: el diseño ya trae su CSS. Filament usa sus propios estilos.
- Fuentes: Plus Jakarta Sans (400–800) y JetBrains Mono (500–600). Autoalójalas (por ejemplo con paquetes `@fontsource`) en vez de cargarlas desde Google Fonts.

## 2. Front público (fidelidad total al diseño)

- Una sola ruta `/` con un layout Blade y **un componente Blade por sección**: navegación fija, hero, frase animada, servicios, portafolio, apps, tecnologías (marquee), contacto y footer.
- Lleva el CSS de `design/index.html` a `resources/css/landing.css` **sin cambiar** colores, tamaños, espaciados, radios ni nombres de clase (`cm-*`). El JS (fallback con IntersectionObserver para Safari/Firefox) va en `resources/js/landing.js`.
- Conserva todas las animaciones e interacciones:
  - fondo animado del hero (3 variantes: `puntos`, `perspectiva`, `pulsos`, seleccionable desde Filament mediante `<body data-hero-bg="...">`),
  - terminal que se escribe sola,
  - hero que se desvanece al hacer scroll, frase que se ilumina palabra por palabra, apariciones de tarjetas, entrada en 3D del portafolio (todo con `animation-timeline: view()` y el fallback JS),
  - capturas del portafolio con scroll automático (se pausan al pasar el mouse),
  - marquee de tecnologías en dos filas con sentidos opuestos (se pausa al pasar el mouse),
  - menú fijo con desenfoque y efectos al pasar el mouse en tarjetas y botones,
  - respeto a `prefers-reduced-motion`.
- Todo el texto, las imágenes y los listados deben salir de la base de datos (ver sección 3), no estar escritos a mano en Blade. Lo único fijo es la estructura.
- Debe verse bien de 360 px a 1920 px sin scroll horizontal.
- Accesibilidad: conserva los `alt`, `aria-label`, `label` de los campos y el contraste del diseño.

## 3. Contenido administrable en Filament

Crea modelos, migraciones, factories y Resources de Filament para lo siguiente. En los listados, ordena arrastrando (campo `sort`) cuando aplique y usa un interruptor de "publicado/activo".

1. **Ajustes del sitio**, como página de Filament con un solo registro (usa el plugin oficial de Filament para `spatie/laravel-settings` u otra solución equivalente):
   - Hero: texto pequeño superior, título, subtítulo y textos de los dos botones.
   - Fondo del hero: `puntos` | `perspectiva` | `pulsos`.
   - Frase animada de la segunda sección, con la parte final resaltada en verde en un campo aparte.
   - Contacto: número de WhatsApp (los botones generan el enlace `https://wa.me/52...`), correo, ciudad/zona de cobertura, correo que recibe las notificaciones de leads.
   - SEO: título, descripción, imagen para compartir (Open Graph) y redes sociales (opcionales).
2. **Servicios**: título, descripción, etiqueta tipo ruta de código (por ejemplo `ventas/pos`), ícono (selector entre los íconos SVG del diseño), orden y activo.
3. **Proyectos del portafolio**: nombre, slug, descripción, etiquetas (TagsInput, se muestran como `SaaS · App iOS · ...`), insignia opcional (`Producto propio`, `En desarrollo` o texto libre), **imagen de scroll** (captura vertical larga; FileUpload a disco `public`), duración de la animación en segundos, URL opcional (no se muestra en la landing; solo es para mi referencia), orden y publicado.
4. **Apps**: nombre, descripción, imagen, estado (`publicada` → "Publicada en tiendas", `proximamente` → "Próximamente en tiendas", `en_desarrollo`), enlaces opcionales a App Store y Google Play, orden y publicado.
5. **Tecnologías**: nombre, logo (SVG o PNG), fila del marquee (1 o 2), orden y activo.
6. **Leads (solicitudes de contacto)**: nombre, negocio, WhatsApp, correo, tipo de proyecto, mensaje, estado (`nuevo`, `contactado`, `cotizado`, `ganado`, `perdido`), notas internas, IP, user agent y UTM de origen (`utm_source`, `utm_medium`, `utm_campaign`, si vienen en la URL).
   - En Filament: tabla con filtros por estado y tipo, insignia con el número de leads nuevos en el menú, acción "Abrir WhatsApp" (enlace `wa.me` con un mensaje inicial), acción para cambiar de estado y vista detallada. No permitas crear leads desde el panel.
7. **Dashboard**: widgets con los leads de los últimos 30 días (gráfica), los leads por tipo de proyecto y los últimos 5 leads.

Usa caché para los datos de la landing y bórrala automáticamente al guardar cualquier modelo o ajuste.

## 4. Formulario de contacto

- Componente **Livewire** con los mismos campos y diseño del formulario de `design/index.html`: nombre (requerido), negocio, WhatsApp (requerido, 10 dígitos), correo (opcional, válido), "¿Qué necesitas?" (requerido; opciones: Sistema POS, App móvil, Tienda en línea, Sitio web, Base de datos, Sistema a la medida o integración, Todavía no lo sé) y mensaje.
- Validación en español, mostrada debajo de cada campo con el estilo del diseño.
- Protección anti-spam: campo honeypot oculto, límite de 5 envíos por minuto por IP y tiempo mínimo de llenado.
- Al enviar: guarda el lead, encola un correo (Mailable en Markdown, en español) al correo de notificaciones configurado en Ajustes con los datos del lead y un botón para abrir WhatsApp, y muestra el estado de éxito tal como está en el diseño ("¡Recibimos tu mensaje!" con el botón "Enviar otro mensaje").

## 5. Contenido inicial (seeders)

Crea un `LandingContentSeeder` que cargue **exactamente** los textos del diseño (hero, frase, 6 servicios, 9 proyectos, 3 apps, 26 tecnologías) y copie las imágenes de `design/assets/` a `storage/app/public` con sus registros:

- Portafolio: `design/assets/portafolio/*-scroll.jpg` (Fideli, far+macias, Consultoría Inmobiliaria, Star Pubs, Pan y Brasas, Pelaná, VR Studio Arquitectura, Grupo Litesa, Mundo Fit), con las descripciones, etiquetas e insignias del diseño.
- Apps: `design/assets/apps/*.jpg` (Fideli y Consultoría Inmobiliaria → `publicada`; far+macias → `proximamente`).
- Tecnologías: `design/assets/logos/*.svg` con el nombre y la fila que tienen en el diseño.
- Ajustes: WhatsApp y correo vacíos (los lleno yo en el panel), fondo `puntos`.
- Logo y favicon: `design/assets/brand/` (isotipo para el favicon y el panel de Filament, y el logotipo en el header del panel). Personaliza Filament con el color primario `#1FBFA9`, la marca de Codemida y modo oscuro por defecto.

Usuario administrador: crea un seeder que lo genere **solo** si existen `ADMIN_EMAIL` y `ADMIN_PASSWORD` en `.env`. No inventes ni escribas credenciales en el código; si no existen, dime que corra `php artisan make:filament-user`.

## 6. SEO y rendimiento

- `<title>`, meta description, canonical, Open Graph y Twitter Card desde Ajustes; `lang="es-MX"`.
- JSON-LD tipo `ProfessionalService` con Codemida, Tulancingo de Bravo, Hidalgo, México, y los servicios. Deja como campos vacíos en Ajustes los datos que no tengo (teléfono, dirección exacta).
- `sitemap.xml` y `robots.txt` (bloquea `/admin`).
- Imágenes: genera versiones WebP optimizadas de lo que se suba en Filament y usa `loading="lazy"` y `decoding="async"` donde aplique. Las animaciones de las capturas del portafolio solo deben arrancar cuando la tarjeta es visible.
- Objetivo de Lighthouse en móvil: 90+ en Performance, Accessibility, Best Practices y SEO. Mídelo al final y dime los resultados.

## 7. Pruebas

Con **Pest**:
- La landing responde 200 y muestra servicios, proyectos, apps y tecnologías publicados (y oculta los no publicados).
- El formulario valida campos, guarda el lead, encola el correo, respeta el honeypot y el límite de envíos.
- Las páginas de Filament cargan para un admin y redirigen a quien no ha iniciado sesión.

## 8. Despliegue (al final, solo si te lo pido)

Lo publico con **Dokploy** desde un Dockerfile. Cuando te lo pida, prepara un `Dockerfile` de producción (PHP-FPM + Nginx o FrankenPHP), con `php artisan optimize`, `storage:link`, migraciones al arrancar, un worker de colas y el `scheduler`, más un `.env.example` documentado.

## Reglas de trabajo

- Trabaja por fases: (1) instalación y configuración, (2) modelos, migraciones y seeders, (3) front público fiel al diseño, (4) Filament, (5) formulario y correo, (6) SEO y rendimiento, (7) pruebas. Al terminar cada fase, corre las pruebas y `php artisan migrate:fresh --seed`, y muéstrame un resumen corto.
- Al terminar la fase 3, levanta el servidor y compara la página con `design/index.html` lado a lado, tanto a 1440 px como a 390 px. Corrige las diferencias antes de seguir.
- No inventes datos de mi empresa (teléfonos, direcciones, precios, cifras, testimonios). Si falta algo, déjalo como campo vacío en Ajustes y avísame.
- No hagas `git push` ni mezcles ramas; yo lo hago manualmente. Puedes hacer commits locales por fase con mensajes en español.
- Código limpio, tipado, siguiendo las convenciones de Laravel y Filament. Comentarios solo donde aporten.
