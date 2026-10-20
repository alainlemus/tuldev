@props(['s'])
  <section id="contacto" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 96px 24px; display: flex; flex-wrap: wrap; gap: 48px; align-items: flex-start">
    <div style="flex: 1 1 380px; min-width: 0; display: flex; flex-direction: column; gap: 20px">
      <div style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&gt; iniciar_proyecto()</div>
      <h2 class="cm-reveal" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->contact_title }}</h2>
      <p style="margin: 0; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->contact_intro }}</p>
      <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 8px">
        @if ($s->whatsapp_url)
        <a href="{{ $s->whatsapp_url }}" style="display: flex; align-items: center; gap: 12px; min-height: 44px; color: #F1F4F6; text-decoration: none; font-size: 16px; font-weight: 600"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20l1.3-3.9A8 8 0 1 1 8 19.6L4 20z"></path></svg>WhatsApp · {{ $s->contact_whatsapp }}</a>
        @endif
        @if ($s->contact_email)
        <a href="mailto:{{ $s->contact_email }}" style="display: flex; align-items: center; gap: 12px; min-height: 44px; color: #F1F4F6; text-decoration: none; font-size: 16px; font-weight: 600"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>{{ $s->contact_email }}</a>
        @endif
        <div style="display: flex; align-items: center; gap: 12px; min-height: 44px; color: #B7C0C9; font-size: 16px"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"></path><circle cx="12" cy="9.5" r="2.5"></circle></svg>{{ $s->contact_area }}</div>
      </div>
    </div>

    <div class="cm-zoom" style="flex: 1 1 480px; min-width: 0; border-radius: 20px; border: 1px solid #232B33; background: #0E1215; padding: clamp(24px, 4vw, 40px)">
      <livewire:contact-form />
    </div>
  </section>
