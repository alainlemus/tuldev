@props(['s'])
  <section style="position: relative; overflow: hidden; min-height: 720px; display: flex; flex-direction: column">
    <div class="cm-bg" data-bg="puntos">
      <div aria-hidden="true" class="cm-anim" style="position: absolute; inset: 0; pointer-events: none; background-image: radial-gradient(rgba(31,191,169,0.35) 1px, transparent 1.6px); background-size: 24px 24px; animation: cm-drift 40s linear infinite; mask-image: radial-gradient(ellipse 80% 75% at 60% 45%, #000 25%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse 80% 75% at 60% 45%, #000 25%, transparent 80%)"></div>
    </div>
    <div class="cm-bg" data-bg="perspectiva">
      <div aria-hidden="true" style="position: absolute; inset: 0; overflow: hidden; pointer-events: none">
        <div class="cm-anim" style="position: absolute; left: -50%; right: -50%; bottom: -10%; height: 70%; transform: perspective(520px) rotateX(62deg); transform-origin: 50% 100%; background-image: linear-gradient(rgba(31,191,169,0.38) 1px, transparent 1px), linear-gradient(90deg, rgba(31,191,169,0.38) 1px, transparent 1px); background-size: 64px 64px; animation: cm-grid-run 1.6s linear infinite; mask-image: linear-gradient(to top, #000 10%, transparent 85%); -webkit-mask-image: linear-gradient(to top, #000 10%, transparent 85%)"></div>
      </div>
    </div>
    <div class="cm-bg" data-bg="pulsos">
      <div aria-hidden="true" style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; background-image: linear-gradient(rgba(31,191,169,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(31,191,169,0.10) 1px, transparent 1px); background-size: 56px 56px">
        <div class="cm-anim" style="position: absolute; left: 785px; top: 113px; width: 55px; height: 55px; background: rgba(31,191,169,0.22); animation: cm-cell 4s ease-in-out infinite"></div>
        <div class="cm-anim" style="position: absolute; left: 1009px; top: 225px; width: 55px; height: 55px; background: rgba(31,191,169,0.30); animation: cm-cell 5s ease-in-out 1.2s infinite"></div>
        <div class="cm-anim" style="position: absolute; left: 1177px; top: 505px; width: 55px; height: 55px; background: rgba(31,191,169,0.24); animation: cm-cell 4.5s ease-in-out 0.6s infinite"></div>
        <div class="cm-anim" style="position: absolute; left: 0; top: 168px; width: 200px; height: 1px; background: linear-gradient(90deg, transparent, #1FBFA9, transparent); animation: cm-streak-x 6s linear infinite"></div>
        <div class="cm-anim" style="position: absolute; left: 952px; top: 0; width: 1px; height: 200px; background: linear-gradient(180deg, transparent, #1FBFA9, transparent); animation: cm-streak-y 5s linear 1s infinite"></div>
      </div>
    </div>



    <div class="cm-hero-out" style="position: relative; flex-grow: 1; width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 72px 24px 112px; display: flex; flex-wrap: wrap; gap: 56px; align-items: center">
      <div class="cm-par-slow" style="flex: 1 1 460px; min-width: 0; display: flex; flex-direction: column; gap: 24px">
        <div class="cm-in" style="--i: 0; font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 14px; color: #5FE0CC">{{ $s->hero_eyebrow }}</div>
        <h1 class="cm-in" style="--i: 1; margin: 0; font-size: clamp(40px, 5.4vw, 68px); font-weight: 800; letter-spacing: -0.045em; line-height: 1.02; text-wrap: balance">{{ $s->hero_title }}</h1>
        <p class="cm-in" style="--i: 2; margin: 0; max-width: 520px; font-size: clamp(16px, 1.6vw, 19px); line-height: 1.6; color: #B7C0C9">{{ $s->hero_subtitle }}</p>
        <div class="cm-in" style="--i: 3; display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px">
          <a href="#contacto" class="cm-btn" style="display: inline-flex; align-items: center; height: 52px; padding: 0 26px; border-radius: 999px; background: #1FBFA9; color: #06201C; text-decoration: none; font-size: 16px; font-weight: 700">{{ $s->hero_primary_label }}</a>
          <a href="#portafolio" class="cm-btn" style="display: inline-flex; align-items: center; height: 52px; padding: 0 26px; border-radius: 999px; border: 1px solid #2A333C; background: rgba(8,9,11,0.6); color: #F1F4F6; text-decoration: none; font-size: 16px; font-weight: 600">{{ $s->hero_secondary_label }}</a>
        </div>
      </div>

      <div class="cm-par" style="position: relative; flex: 1 1 460px; min-width: 0">
        <div aria-hidden="true" class="cm-anim" style="position: absolute; left: 10%; right: 10%; top: 10%; bottom: 10%; border-radius: 50%; background: radial-gradient(closest-side, rgba(31,191,169,0.35), transparent); filter: blur(30px); animation: cm-glow 6s ease-in-out infinite"></div>
        <figure class="cm-in" role="img" aria-label="Terminal que muestra el proceso de un proyecto: analizar procesos, diseñar la base de datos, programar y entregar" style="--i: 2; position: relative; margin: 0; border-radius: 16px; border: 1px solid #232B33; background: #0E1215; overflow: hidden">
          <div style="display: flex; align-items: center; gap: 8px; padding: 14px 16px; border-bottom: 1px solid #1C2329">
            <span style="width: 11px; height: 11px; border-radius: 50%; background: #3A434C"></span>
            <span style="width: 11px; height: 11px; border-radius: 50%; background: #3A434C"></span>
            <span style="width: 11px; height: 11px; border-radius: 50%; background: #3A434C"></span>
            <span style="margin-left: 8px; font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 12px; color: #8E99A4">codemida — proyecto</span>
          </div>
          <div style="padding: 24px 22px 28px; display: flex; flex-direction: column; gap: 12px; font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 14px; line-height: 1.5; min-height: 210px">
            <div style="display: flex"><span class="cm-anim" style="display: inline-block; overflow: hidden; white-space: nowrap; width: 25ch; color: #F1F4F6; animation: cm-t1 10s infinite">$ codemida nuevo-proyecto</span></div>
            <div style="display: flex"><span class="cm-anim" style="display: inline-block; overflow: hidden; white-space: nowrap; width: 33ch; color: #B7C0C9; animation: cm-t2 10s infinite"><span style="color: #1FBFA9">✓</span> analizando procesos del negocio</span></div>
            <div style="display: flex"><span class="cm-anim" style="display: inline-block; overflow: hidden; white-space: nowrap; width: 25ch; color: #B7C0C9; animation: cm-t3 10s infinite"><span style="color: #1FBFA9">✓</span> diseñando base de datos</span></div>
            <div style="display: flex"><span class="cm-anim" style="display: inline-block; overflow: hidden; white-space: nowrap; width: 32ch; color: #B7C0C9; animation: cm-t4 10s infinite"><span style="color: #1FBFA9">✓</span> programando POS + app + tienda</span></div>
            <div style="display: flex; align-items: center; gap: 4px"><span class="cm-anim" style="display: inline-block; overflow: hidden; white-space: nowrap; width: 19ch; color: #5FE0CC; animation: cm-t5 10s infinite">→ listo para vender</span><span class="cm-anim" style="display: inline-block; width: 9px; height: 17px; background: #1FBFA9; animation: cm-blink 1s steps(1) infinite"></span></div>
          </div>
        </figure>
      </div>
    </div>
  </section>
