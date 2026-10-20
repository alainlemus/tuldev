document.documentElement.classList.add('js');

// Respaldo para navegadores sin animation-timeline (Safari/Firefox): IntersectionObserver añade .is-in
if (!CSS.supports('animation-timeline: view()')) {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    io.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -8% 0px' },
    );

    document
        .querySelectorAll('.cm-reveal:not(.cm-scrub),.cm-proj:not(.cm-scrub),.cm-zoom:not(.cm-scrub),.cm-word,.cm-word-a')
        .forEach((el) => io.observe(el));
}

// Pausa las animaciones de las capturas del portafolio cuando su tarjeta no está en pantalla.
const shotObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => entry.target.classList.toggle('is-playing', entry.isIntersecting));
});

document.querySelectorAll('.cm-shot').forEach((el) => shotObserver.observe(el));

import './scroll-fx.js';
