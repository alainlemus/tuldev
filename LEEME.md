# Kit de la landing de Codemida

## Qué trae

- `design/index.html`: el diseño final. Se abre directo en el navegador, con animaciones, fondo del hero, marquee y formulario de demostración. Es la referencia que Claude Code debe copiar al pixel.
- `design/assets/portafolio/`: capturas largas de cada proyecto, las que se desplazan solas en el portafolio.
- `design/assets/apps/`: imágenes de las apps de Fideli, Consultoría Inmobiliaria y far+macias.
- `design/assets/logos/`: logos de las tecnologías para el marquee.
- `design/assets/brand/`: isotipo y logotipo de Codemida, en versiones para fondo claro y oscuro.
- `PROMPT.md`: el prompt completo para Claude Code.

## Cómo usarlo

1. Requisitos en tu máquina: PHP 8.3 o superior, Composer, Node 20 o superior y MySQL 8 corriendo. Crea la base de datos `codemida`.
2. Crea la carpeta del proyecto (por ejemplo `~/Sites/codemida`) y copia dentro la carpeta `design/` de este kit.
3. Abre una terminal en esa carpeta y ejecuta `claude`.
4. Pega el contenido de `PROMPT.md` (todo lo que está debajo de la línea). También puedes copiar `PROMPT.md` a la carpeta y escribir: *"Lee PROMPT.md y sigue sus instrucciones"*.
5. Revisa el plan que te proponga, apruébalo y ve validando cada fase.
6. Al final, entra a `/admin` y llena tu WhatsApp, tu correo y el correo donde quieres recibir los leads.

## Notas

- En `design/index.html` puedes cambiar `data-hero-bg="puntos"` por `perspectiva` o `pulsos` para ver los otros fondos del hero.
- Las animaciones al hacer scroll usan CSS nativo en Chrome y Edge, y un respaldo en JavaScript en Safari y Firefox.
- El logotipo en SVG usa la fuente Plus Jakarta Sans. Para imprimirlo o mandarlo a otros, conviene convertir el texto a curvas en Illustrator, Figma o Inkscape.
