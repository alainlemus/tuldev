# Prompt para Claude Code — Implementar el logo de Tuldev

> Copia la carpeta `tuldev-logo/` a la raíz del proyecto y pega lo que está debajo de la línea en Claude Code.

---

Implementa la identidad de **Tuldev** en este proyecto Laravel + Filament usando los archivos de `tuldev-logo/` (lee primero `tuldev-logo/LEEME.md`). No redibujes ni modifiques los SVG: úsalos tal cual.

1. **Archivos públicos**
   - Copia todo `tuldev-logo/favicon/` a `public/`, para que queden en la raíz `/favicon.ico`, `/favicon.svg`, `/apple-touch-icon.png`, etc.
   - Copia `tuldev-logo/svg/` a `public/brand/svg/` y `tuldev-logo/png/` a `public/brand/png/`.

2. **`<head>` del sitio público** (layout Blade):
   - `<link rel="icon" href="/favicon.svg" type="image/svg+xml">`, `<link rel="icon" href="/favicon.ico" sizes="any">`, `<link rel="apple-touch-icon" href="/apple-touch-icon.png">`, `<link rel="manifest" href="/site.webmanifest">` y `<meta name="theme-color" content="#08090B">`.
   - Open Graph y Twitter Card con `/brand/png/imagen-redes-1200x630.png` (`og:image:width` 1200, `og:image:height` 630). Si la imagen para compartir es editable en Ajustes de Filament, usa este archivo como valor por defecto.

3. **Header y footer de la landing**: reemplaza el logo actual por `public/brand/svg/logotipo-horizontal-para-fondo-oscuro.svg` dentro de un `<img>` con `alt="Tuldev"`, `height` de 30 px en el header y 24 px en el footer, enlazado a `/`. Si el diseño usa el logo en línea (SVG + texto), sustitúyelo por la imagen, para que el texto quede en curvas y se vea igual en todos los dispositivos.

4. **Panel de Filament** (en el `PanelProvider`, verificando primero la API de la versión instalada):
   - Nombre de la marca: `Tuldev`.
   - Logo en modo claro: `brand/svg/logotipo-horizontal-para-fondo-claro.svg`; en modo oscuro: `brand/svg/logotipo-horizontal-para-fondo-oscuro.svg`; altura de 2 rem.
   - Favicon: `/favicon.svg`.
   - Color primario: `#1FBFA9`. Gris: el que mejor combine con el grafito `#171A1F`.
   - Página de inicio de sesión con el mismo logo.

5. **Correos** (notificación de leads y cualquier Mailable): publica las vistas de correo de Laravel si hace falta y pon en el encabezado `brand/png/logotipo-horizontal-para-fondo-claro-chico.png` con URL absoluta (`asset()`), `alt="Tuldev"` y 160 px de ancho.

6. **Limpieza**: busca en todo el proyecto (vistas, config, `.env.example`, seeders, `CLAUDE.md`, `README`) referencias a nombres o logos anteriores (por ejemplo "Codemida") y reemplázalas por Tuldev. Muéstrame la lista antes de cambiar algo que no sea obvio.

7. **Verificación**: levanta el servidor y revisa el favicon en la pestaña, el header y el footer de la landing a 1440 px y a 390 px, el login y el panel de Filament en modo claro y oscuro, y la vista previa de un correo (`/mail-preview` temporal o Mailpit). Dime qué revisaste y el resultado.

No hagas `git push`; un commit local con el mensaje "Identidad Tuldev: logo, favicon y marca en Filament" está bien.
