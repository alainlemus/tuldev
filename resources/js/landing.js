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
        .querySelectorAll('.cm-reveal,.cm-proj,.cm-zoom,.cm-word,.cm-word-a')
        .forEach((el) => io.observe(el));
}
