@props(['s', 'rows'])
  <section id="tecnologias" style="padding: 112px 0 0; display: flex; flex-direction: column; gap: 44px">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 0 24px; display: flex; flex-wrap: wrap; gap: 24px; justify-content: space-between; align-items: flex-end">
      <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
        <div class="cm-reveal" style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;stack&gt;</div>
        <h2 class="cm-reveal" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->stack_title }}</h2>
      </div>
      <p class="cm-reveal" style="margin: 0; max-width: 440px; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->stack_intro }}</p>
    </div>
    <div class="cm-reveal" style="display: flex; flex-direction: column; gap: 14px; mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent)">
        <div class="cm-marquee" style="overflow: hidden; padding: 4px 0">
          <ul class="cm-track" style="margin: 0; padding: 0; list-style: none; display: flex; gap: 12px; width: max-content; animation-duration: 38s">
            @foreach ([false, true] as $duplicate)
            @foreach ($rows[1] as $tech)
            <li class="cm-chip"{!! $duplicate ? ' aria-hidden="true"' : '' !!} style="display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 14px; border: 1px solid #1E252C; background: #0E1215; white-space: nowrap; font-size: 15px; font-weight: 600; color: #D5DBE1"><img src="{{ $tech->logoUrl() }}" alt="" width="22" height="22" loading="lazy" decoding="async" style="width: 22px; height: 22px; display: block">{{ $tech->name }}</li>
            @endforeach
            @endforeach
          </ul>
        </div>
        <div class="cm-marquee" style="overflow: hidden; padding: 4px 0">
          <ul class="cm-track cm-rev" style="margin: 0; padding: 0; list-style: none; display: flex; gap: 12px; width: max-content; animation-duration: 52s">
            @foreach ([false, true] as $duplicate)
            @foreach ($rows[2] as $tech)
            <li class="cm-chip"{!! $duplicate ? ' aria-hidden="true"' : '' !!} style="display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 14px; border: 1px solid #1E252C; background: #0E1215; white-space: nowrap; font-size: 15px; font-weight: 600; color: #D5DBE1"><img src="{{ $tech->logoUrl() }}" alt="" width="22" height="22" loading="lazy" decoding="async" style="width: 22px; height: 22px; display: block">{{ $tech->name }}</li>
            @endforeach
            @endforeach
          </ul>
        </div>
    </div>
  </section>
