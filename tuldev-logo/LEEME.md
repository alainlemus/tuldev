# Logo de Tuldev

El texto de todos los logotipos ya está **convertido a curvas**: no hace falta tener instalada la fuente Plus Jakarta Sans para que se vean bien.

## Colores

| Uso | Hex |
|---|---|
| Grafito (texto y fondo del isotipo) | `#171A1F` |
| Verde cursor (acento sobre fondo oscuro, cursor del isotipo) | `#1FBFA9` |
| Verde texto (acento sobre fondo claro) | `#0E8A7B` |
| Fondo noche (web) | `#08090B` |

Tipografías: Plus Jakarta Sans (800 en el nombre y 500 en los signos `< >`) y JetBrains Mono para los detalles de código.

## Archivos

**`svg/`**: versiones vectoriales, para la web y para imprimir.
- `logotipo-horizontal-para-fondo-oscuro.svg` y `…-para-fondo-claro.svg`: la versión principal (isotipo + tul<dev>).
- `logotipo-con-lema-…`: la misma, con "SOFTWARE A LA MEDIDA" debajo.
- `nombre-solo-…`: solo tul<dev>, sin isotipo.
- `isotipo.svg` (cuadro redondeado) e `isotipo-circular.svg` (para foto de perfil en redes).
- `isotipo-sin-fondo-blanco.svg` e `isotipo-sin-fondo-grafito.svg`.
- `…-mono-negro.svg` y `…-mono-blanco.svg`: a una sola tinta, para sellos, grabado o bordado.
- `imagen-redes-1200x630.svg`: la imagen que aparece al compartir el sitio (Open Graph).

**`png/`**: el isotipo de 16 a 1024 px, los logotipos en alta resolución con fondo transparente y la imagen para redes en 1200×630.

**`favicon/`**: archivos listos para la carpeta `public/` de Laravel: `favicon.ico`, `favicon.svg`, `favicon-16x16.png`, `favicon-32x32.png`, `apple-touch-icon.png`, `android-chrome-192x192.png`, `android-chrome-512x512.png` y `site.webmanifest`.

## Reglas de uso

- Deja alrededor del logo un espacio libre de al menos la altura de la "t".
- Sobre fondos oscuros usa la versión `para-fondo-oscuro`, y sobre fondos claros la `para-fondo-claro`.
- No lo estires, no lo rotes y no le cambies los colores; si necesitas una sola tinta, usa las versiones `mono`.
- Tamaño mínimo del logotipo horizontal: 96 px de ancho en pantalla o 25 mm impreso. Por debajo de eso, usa solo el isotipo.

## Implementarlo con Claude Code

Copia esta carpeta a la raíz de tu proyecto Laravel (por ejemplo como `tuldev-logo/`) y pega el contenido de `PROMPT-LOGO.md` en Claude Code.
