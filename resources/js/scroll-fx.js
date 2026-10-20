// Efectos de scroll estilo Apple. Un solo listener de scroll escribe variables CSS dentro de requestAnimationFrame.
const root = document.documentElement;
const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;
const clamp = (n, min = 0, max = 1) => Math.min(max, Math.max(min, n));

const nav = document.querySelector('.cm-nav');
const services = document.querySelector('#servicios');
const portfolio = document.querySelector('#portafolio');
const contact = document.querySelector('#contacto');
const process = document.querySelector('#proceso');
const cta = document.querySelector('#hablemos');
const hero = document.querySelector('.cm-par')?.closest('section');
const pin = document.querySelector('.cm-pin');
const pinWords = pin ? [...pin.querySelectorAll('.cm-word, .cm-word-a')] : [];
const tracks = [...document.querySelectorAll('.cm-track')];
const parallaxImages = reduceMotion ? [] : [...document.querySelectorAll('#apps img')];
const visibleImages = new Set();
const scrubTargets = reduceMotion ? [] : [...document.querySelectorAll('.cm-scrub')];
const visibleScrub = new Set();

parallaxImages.forEach((img) => img.classList.add('cm-par-img'));

// Imágenes con parallax: solo se calculan mientras están en pantalla.
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => (entry.isIntersecting ? visibleImages.add(entry.target) : visibleImages.delete(entry.target)));
});
parallaxImages.forEach((img) => imageObserver.observe(img));

// Elementos que aparecen "pegados" al scroll (portafolio, apps, formulario): solo se calculan los cercanos a la pantalla.
const scrubObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => (entry.isIntersecting ? visibleScrub.add(entry.target) : visibleScrub.delete(entry.target)));
        onScroll();
    },
    { rootMargin: '0px 0px 15% 0px' },
);
scrubTargets.forEach((el) => scrubObserver.observe(el));

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

    // Transición entre el fondo del hero y el fondo de cuadrícula del resto de la página.
    root.style.setProperty('--hero-fade', hero ? clamp(y / Math.max(hero.offsetHeight, 1)).toFixed(4) : 1);

    if (reduceMotion) return;

    if (hero) {
        root.style.setProperty('--hero-p', clamp(y / Math.max(hero.offsetHeight, 1)).toFixed(4));
    }

    if (pin) {
        const rect = pin.getBoundingClientRect();
        const travel = Math.max(rect.height - vh, 1);
        const progress = clamp(-rect.top / travel);
        pin.style.setProperty('--pin-p', progress.toFixed(4));
        pinWords.forEach((word, i) => {
            word.classList.toggle('is-lit', progress >= 0.04 + 0.82 * (i / pinWords.length));
        });
    }

    [services, portfolio, contact, process, cta].forEach((section) => {
        if (!section) return;
        const rect = section.getBoundingClientRect();
        const progress = clamp((vh - rect.top) / (vh + rect.height));
        section.style.setProperty('--svc-p', progress.toFixed(4));
        section.style.setProperty('--ct-p', progress.toFixed(4));
        section.style.setProperty('--pp', (progress * 2 - 1).toFixed(4));
    });

    visibleScrub.forEach((el) => {
        const rect = el.getBoundingClientRect();
        const order = Number(el.style.getPropertyValue('--i')) || 0;
        const linear = clamp((vh * 0.96 - rect.top) / (vh * 0.42) - order * 0.16);
        el.style.setProperty('--rv', (linear * linear * (3 - 2 * linear)).toFixed(3));
    });

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

// Servicios: los íconos se "dibujan" una vez, cuando su tarjeta entra en pantalla.
if (services) {
    services.querySelectorAll('.cm-card svg :is(path, rect, circle, ellipse)').forEach((shape) => shape.setAttribute('pathLength', '1'));

    const drawObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-drawn');
                    drawObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.35 },
    );

    services.querySelectorAll('.cm-card').forEach((card) => drawObserver.observe(card));
}

// Portafolio: asigna a cada tarjeta su velocidad de parallax según la columna en la que cae.
function assignColumns() {
    if (!portfolio || reduceMotion) return;
    const cards = [...portfolio.querySelectorAll('.cm-proj')];
    const lefts = [...new Set(cards.map((card) => card.offsetLeft))].sort((a, b) => a - b);
    const speeds = { 1: [0], 2: [1, -1], 3: [1, 0, -1] }[Math.min(lefts.length, 3)] ?? [0];
    cards.forEach((card) => card.style.setProperty('--k', speeds[lefts.indexOf(card.offsetLeft)] ?? 0));
}

assignColumns();
addEventListener('resize', assignColumns, { passive: true });

// Luz de fondo que sigue al cursor con un pequeño retraso suave.
if (!reduceMotion && finePointer) {
    const glow = document.createElement('div');
    glow.className = 'cm-cursor-glow';
    glow.setAttribute('aria-hidden', 'true');
    document.body.appendChild(glow);

    let targetX = innerWidth / 2;
    let targetY = innerHeight / 3;
    let x = targetX;
    let y = targetY;
    let running = false;

    const follow = () => {
        x += (targetX - x) * 0.14;
        y += (targetY - y) * 0.14;
        glow.style.transform = `translate3d(${x.toFixed(1)}px, ${y.toFixed(1)}px, 0)`;

        if (Math.abs(targetX - x) > 0.5 || Math.abs(targetY - y) > 0.5) {
            requestAnimationFrame(follow);
        } else {
            running = false;
        }
    };

    addEventListener(
        'pointermove',
        (e) => {
            targetX = e.clientX;
            targetY = e.clientY;
            glow.classList.add('is-on');

            if (!running) {
                running = true;
                requestAnimationFrame(follow);
            }
        },
        { passive: true },
    );

    document.documentElement.addEventListener('pointerleave', () => glow.classList.remove('is-on'));
}

// Cifras: cuentan desde 0 hasta su valor la primera vez que aparecen.
const counters = [...document.querySelectorAll('[data-count]')];

if (counters.length && !reduceMotion) {
    const countObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                countObserver.unobserve(entry.target);

                const el = entry.target;
                const target = parseFloat(el.dataset.count);
                const decimals = (el.dataset.count.split('.')[1] || '').length;
                const { prefix = '', suffix = '' } = el.dataset;
                const start = performance.now();
                const duration = 1600;

                const tick = (now) => {
                    const t = clamp((now - start) / duration);
                    const eased = 1 - Math.pow(1 - t, 3);
                    el.textContent = `${prefix}${(target * eased).toFixed(decimals)}${suffix}`;
                    if (t < 1) requestAnimationFrame(tick);
                };

                requestAnimationFrame(tick);
            });
        },
        { threshold: 0.6 },
    );

    counters.forEach((el) => {
        el.textContent = `${el.dataset.prefix ?? ''}0${el.dataset.suffix ?? ''}`;
        countObserver.observe(el);
    });
}
