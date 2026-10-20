@props(['s', 'faqs'])
@if ($faqs->isNotEmpty())
  <section id="faq" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 96px 24px 56px; display: flex; flex-wrap: wrap; gap: 48px; align-items: flex-start">
    <div style="flex: 1 1 320px; min-width: 0; display: flex; flex-direction: column; gap: 14px; max-width: 420px">
      <div class="cm-reveal" style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;faq&gt;</div>
      <h2 class="cm-reveal cm-d1" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->faq_title }}</h2>
      <p class="cm-reveal cm-d2" style="margin: 0; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->faq_intro }}</p>
    </div>
    <div style="flex: 2 1 480px; min-width: 0; display: flex; flex-direction: column; gap: 10px">
      @foreach ($faqs as $faq)
      <details class="cm-scrub cm-faq" style="border-radius: 14px; border: 1px solid #1E252C; background: #0E1215">
        <summary style="list-style: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 22px; min-height: 44px; font-size: 17px; font-weight: 600; letter-spacing: -0.01em">
          <span>{{ $faq->question }}</span>
          <svg class="cm-faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"></path></svg>
        </summary>
        <div class="cm-faq-answer" style="padding: 0 22px 22px; font-size: 16px; line-height: 1.65; color: #B7C0C9">{{ $faq->answer }}</div>
      </details>
      @endforeach
    </div>
  </section>
@endif
