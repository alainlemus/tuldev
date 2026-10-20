@props(['s'])
  <section id="hablemos" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 56px 24px 24px">
    <div class="cm-scrub cm-cta" style="position: relative; overflow: hidden; border-radius: 28px; border: 1px solid #232B33; background: #0E1215; padding: clamp(36px, 7vw, 84px) clamp(24px, 5vw, 64px); display: flex; flex-direction: column; align-items: center; gap: 22px; text-align: center">
      <div aria-hidden="true" class="cm-cta-glow"></div>
      <h2 style="position: relative; margin: 0; max-width: 760px; font-size: clamp(34px, 5vw, 60px); font-weight: 800; letter-spacing: -0.04em; line-height: 1.05; text-wrap: balance">{{ $s->cta_title }}</h2>
      <p style="position: relative; margin: 0; max-width: 560px; font-size: 18px; line-height: 1.6; color: #B7C0C9">{{ $s->cta_text }}</p>
      <div style="position: relative; display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-top: 8px">
        @if ($s->whatsapp_url)
        <a href="{{ $s->whatsapp_url }}" class="cm-btn" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; height: 52px; padding: 0 26px; border-radius: 999px; background: #1FBFA9; color: #06201C; text-decoration: none; font-size: 16px; font-weight: 700">{{ $s->cta_primary_label }}</a>
        <a href="#contacto" class="cm-btn" style="display: inline-flex; align-items: center; height: 52px; padding: 0 26px; border-radius: 999px; border: 1px solid #2A333C; background: rgba(8,9,11,0.6); color: #F1F4F6; text-decoration: none; font-size: 16px; font-weight: 600">{{ $s->cta_secondary_label }}</a>
        @else
        <a href="#contacto" class="cm-btn" style="display: inline-flex; align-items: center; height: 52px; padding: 0 26px; border-radius: 999px; background: #1FBFA9; color: #06201C; text-decoration: none; font-size: 16px; font-weight: 700">{{ $s->cta_secondary_label }}</a>
        @endif
      </div>
    </div>
  </section>
