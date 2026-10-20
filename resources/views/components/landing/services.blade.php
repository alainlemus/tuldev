@props(['s', 'services'])
  <section id="servicios" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 80px 24px 96px; display: flex; flex-direction: column; gap: 44px">
    <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
      <div style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;servicios&gt;</div>
      <h2 class="cm-reveal" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->services_title }}</h2>
      <p style="margin: 0; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->services_intro }}</p>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(320px, 100%), 1fr)); gap: 16px">
      @foreach ($services as $service)
      <article class="cm-reveal cm-card" style="border-radius: 16px; border: 1px solid #1E252C; background: linear-gradient(180deg, #101418, #0B0E11); padding: 26px; display: flex; flex-direction: column; gap: 16px">
        <div style="display: flex; justify-content: space-between; align-items: center"><span style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 12px; color: #8E99A4">{{ $service->tag }}</span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $service->icon->svg() !!}</svg></div>
        <h3 style="margin: 0; font-size: 21px; font-weight: 700; letter-spacing: -0.02em">{{ $service->title }}</h3>
        <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #B7C0C9">{{ $service->description }}</p>
      </article>
      @endforeach
    </div>
  </section>
