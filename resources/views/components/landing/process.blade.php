@props(['s', 'steps'])
@if ($steps->isNotEmpty())
  <section id="proceso" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 56px 24px 96px; display: flex; flex-direction: column; gap: 44px">
    <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
      <div class="cm-reveal" style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;proceso&gt;</div>
      <h2 class="cm-reveal cm-d1" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->process_title }}</h2>
      <p class="cm-reveal cm-d2" style="margin: 0; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->process_intro }}</p>
    </div>
    <ol class="cm-proc" style="list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(min(240px, 100%), 1fr)); gap: 16px">
      @foreach ($steps as $step)
      <li class="cm-scrub cm-card cm-step" style="border-radius: 16px; border: 1px solid #1E252C; background: linear-gradient(180deg, #101418, #0B0E11); padding: 26px; display: flex; flex-direction: column; gap: 14px">
        <span class="cm-step-num" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
        <h3 style="margin: 0; font-size: 21px; font-weight: 700; letter-spacing: -0.02em">{{ $step->title }}</h3>
        <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #B7C0C9">{{ $step->description }}</p>
      </li>
      @endforeach
    </ol>
  </section>
@endif
