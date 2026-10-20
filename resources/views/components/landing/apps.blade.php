@props(['s', 'apps'])
  <section id="apps" style="border-top: 1px solid #161B20; border-bottom: 1px solid #161B20; background: rgba(11,13,16,0.6)">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 96px 24px; display: flex; flex-direction: column; gap: 44px">
      <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
        <div class="cm-reveal" style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;apps&gt;</div>
        <h2 class="cm-reveal cm-d1" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->apps_title }}</h2>
      </div>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(340px, 100%), 1fr)); gap: 20px">
        @foreach ($apps as $app)
        <article class="cm-reveal cm-card cm-scrub" style="border-radius: 18px; border: 1px solid #1E252C; background: #0F1317; overflow: hidden; display: flex; flex-direction: column">
          <div style="overflow: hidden; aspect-ratio: 4 / 3; flex: none">
          <picture style="display: block; width: 100%; height: 100%">
            <img src="{{ $app->imageUrl() }}" alt="{{ $app->image_alt ?: 'Pantallas de la app '.$app->name }}" width="580" height="435" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; display: block">
          </picture>
          </div>
          <div style="padding: 24px; display: flex; flex-direction: column; gap: 10px">
            <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center; justify-content: space-between"><h3 style="margin: 0; font-size: 20px; font-weight: 700; letter-spacing: -0.02em">{{ $app->name }}</h3><span style="font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 999px; {{ $app->status->isHighlighted() ? 'background: rgba(31,191,169,0.14); color: #5FE0CC' : 'background: #1A2026; color: #B7C0C9' }}">{{ $app->status->getLabel() }}</span></div>
            <p style="margin: 0; font-size: 15px; line-height: 1.55; color: #B7C0C9">{{ $app->description }}</p>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
