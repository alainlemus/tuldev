// Efectos de scroll estilo Apple. Un solo listener de scroll escribe variables CSS dentro de requestAnimationFrame.
const root = document.documentElement;
const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;
const clamp = (n, min = 0, max = 1) => Math.min(max, Math.max(min, n));

const nav = document.querySelector('.cm-nav');
const hero = document.querySelector('.cm-par')?.closest('section');
const pin = document.querySelector('.cm-pin');
const pinWords = pin ? [...pin.querySelectorAll('.cm-word, .cm-word-a')] : [];
const tracks = [...document.querySelectorAll('.cm-track')];
const parallaxImages = reduceMotion ? [] : [...document.querySelectorAll('#apps img')];
const visibleImages = new Set();

parallaxImages.forEach((img) => img.classList.add('cm-par-img'));

// Imágenes con parallax: solo se calculan mientras están en pantalla.
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => (entry.isIntersecting ? visibleImages.add(entry.target) : visibleImages.delete(entry.target)));
});
parallaxImages.forEach((img) => imageObserver.observe(img));

// Marquee: acelera según la velocidad del scroll y vuelve poco a poco a su ritmo.
let lastY = scrollY;
let lastT = performance.now();
let rate = 1;

function update(now) {
    const y = scrollY;
    const vh = innerHeight;
    const max = root.scrollHeight - vh;

    root.style.setProperty('--scroll-p', max > 0 ? clamp(y / max).toFixed(4) : 0);
    nav?.classList.toggle('is-scrolled', y > 8);

    if (reduceMotion) return;

    if (hero) {
        root.style.setProperty('--hero-p', clamp(y / Math.max(hero.offsetHeight, 1)).toFixed(4));
    }

    if (pin) {
        const rect = pin.getBoundingClientRect();
        const travel = Math.max(rect.height - vh, 1);
        const progress = clamp(-rect.top / travel);
        pinWords.forEach((word, i) => {
            word.classList.toggle('is-lit', progress >= 0.04 + 0.82 * (i / pinWords.length));
        });
    }

    visibleImages.forEach((img) => {
        const rect = img.parentElement.getBoundingClientRect();
        const p = clamp((rect.top + rect.height / 2 - vh / 2) / (vh / 2 + rect.height / 2), -1, 1);
        img.style.setProperty('--p', p.toFixed(3));
    });

    const dt = Math.max(now - lastT, 16);
    const velocity = Math.abs(y - lastY) / dt; // px por ms
    const target = 1 + Math.min(velocity * 5, 5);
    rate += (target - rate) * 0.12;
    lastY = y;
    lastT = now;
    tracks.forEach((track) => track.getAnimations()[0]?.updatePlaybackRate(Math.max(rate, 1)));
}

let ticking = false;
function onScroll() {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame((now) => {
        update(now);
        ticking = false;
    });
}

addEventListener('scroll', onScroll, { passive: true });
addEventListener('resize', onScroll, { passive: true });
update(performance.now());

// El marquee sigue desacelerándose aunque el scroll ya se haya detenido.
if (!reduceMotion && tracks.length) {
    (function settle(now) {
        if (rate > 1.01) update(now);
        requestAnimationFrame(settle);
    })(performance.now());
}

if (reduceMotion) {
    // Sin movimiento: el resto de efectos ya está desactivado por CSS.
} else {
    // Escalonado de tarjetas: posición dentro de la fila (3 columnas en escritorio).
    document.querySelectorAll('.cm-card, .cm-proj').forEach((el, i) => {
        el.style.setProperty('--i', i % 3);
    });
}

if (!reduceMotion && finePointer) {
    // Brillo que sigue al cursor en tarjetas.
    document.querySelectorAll('.cm-card').forEach((card) => {
        card.addEventListener('pointermove', (e) => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--mx', `${e.clientX - r.left}px`);
            card.style.setProperty('--my', `${e.clientY - r.top}px`);
        });
    });

    // Inclinación 3D de las capturas del portafolio.
    document.querySelectorAll('.cm-proj').forEach((proj) => {
        const frame = proj.querySelector('.cm-frame');
        if (!frame) return;
        proj.addEventListener('pointermove', (e) => {
            const r = frame.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            frame.style.setProperty('--rx', `${(x * 8).toFixed(2)}deg`);
            frame.style.setProperty('--ry', `${(-y * 8).toFixed(2)}deg`);
        });
        proj.addEventListener('pointerleave', () => {
            frame.style.setProperty('--rx', '0deg');
            frame.style.setProperty('--ry', '0deg');
        });
    });

    // Botones magnéticos.
    document.querySelectorAll('.cm-btn').forEach((btn) => {
        btn.addEventListener('pointermove', (e) => {
            const r = btn.getBoundingClientRect();
            btn.style.setProperty('--tx', `${((e.clientX - r.left) / r.width - 0.5) * 10}px`);
            btn.style.setProperty('--ty', `${((e.clientY - r.top) / r.height - 0.5) * 8}px`);
        });
        btn.addEventListener('pointerleave', () => {
            btn.style.setProperty('--tx', '0px');
            btn.style.setProperty('--ty', '0px');
        });
    });
}
