@props(['s', 'testimonials'])
@if ($testimonials->isNotEmpty())
  <section id="clientes" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 24px 24px 96px; display: flex; flex-direction: column; gap: 44px">
    <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
      <div class="cm-reveal" style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;clientes&gt;</div>
      <h2 class="cm-reveal cm-d1" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->testimonials_title }}</h2>
      <p class="cm-reveal cm-d2" style="margin: 0; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->testimonials_intro }}</p>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(320px, 100%), 1fr)); gap: 16px">
      @foreach ($testimonials as $testimonial)
      <figure class="cm-scrub cm-card" style="margin: 0; border-radius: 16px; border: 1px solid #1E252C; background: linear-gradient(180deg, #101418, #0B0E11); padding: 28px; display: flex; flex-direction: column; gap: 22px; justify-content: space-between">
        <blockquote style="margin: 0; font-size: 17px; line-height: 1.65; color: #D5DBE1"><span aria-hidden="true" style="display: block; font-size: 44px; line-height: 0.7; color: #1FBFA9; font-weight: 800; margin-bottom: 8px">“</span>{{ $testimonial->quote }}</blockquote>
        <figcaption style="display: flex; align-items: center; gap: 12px">
          @if ($testimonial->photoUrl())
          <img src="{{ $testimonial->photoUrl() }}" alt="" width="44" height="44" loading="lazy" decoding="async" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover">
          @else
          <span aria-hidden="true" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(31,191,169,0.14); color: #5FE0CC; display: flex; align-items: center; justify-content: center; font-weight: 800">{{ mb_strtoupper(mb_substr($testimonial->author, 0, 1)) }}</span>
          @endif
          <span style="display: flex; flex-direction: column; gap: 2px"><strong style="font-size: 15px; font-weight: 700">{{ $testimonial->author }}</strong>@if ($testimonial->role)<span style="font-size: 13px; color: #8E99A4">{{ $testimonial->role }}</span>@endif</span>
        </figcaption>
      </figure>
      @endforeach
    </div>
  </section>
@endif
