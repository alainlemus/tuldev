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
      <div id="cm-ok" hidden>
        <div role="status" style="display: flex; flex-direction: column; gap: 14px; align-items: flex-start; padding: 24px 0">
          <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(31,191,169,0.14); display: flex; align-items: center; justify-content: center"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10"></path></svg></div>
          <h3 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.02em">¡Recibimos tu mensaje!</h3>
          <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #B7C0C9">Te contactaremos pronto para platicar de tu proyecto.</p>
          <button type="button" id="cm-reset" style="height: 44px; padding: 0 18px; border-radius: 999px; border: 1px solid #2A333C; background: transparent; color: #F1F4F6; font: inherit; font-size: 14px; font-weight: 600; cursor: pointer">Enviar otro mensaje</button>
        </div>
      </div>
      <div id="cm-form-wrap">
        <form id="cm-form" style="display: flex; flex-direction: column; gap: 18px">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(200px, 100%), 1fr)); gap: 16px">
            <div style="display: flex; flex-direction: column; gap: 8px">
              <label for="cm-nombre" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Nombre</label>
              <input id="cm-nombre" name="nombre" type="text" required autocomplete="name" placeholder="Tu nombre" style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px">
              <label for="cm-negocio" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Negocio o empresa</label>
              <input id="cm-negocio" name="negocio" type="text" autocomplete="organization" placeholder="Nombre de tu negocio" style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px">
              <label for="cm-tel" style="font-size: 14px; font-weight: 600; color: #D5DBE1">WhatsApp</label>
              <input id="cm-tel" name="whatsapp" type="tel" required autocomplete="tel" placeholder="10 dígitos" style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px">
              <label for="cm-correo" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Correo</label>
              <input id="cm-correo" name="correo" type="email" autocomplete="email" placeholder="tu@correo.com" style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
            </div>
          </div>
          <div style="display: flex; flex-direction: column; gap: 8px">
            <label for="cm-tipo" style="font-size: 14px; font-weight: 600; color: #D5DBE1">¿Qué necesitas?</label>
            <select id="cm-tipo" name="tipo" required style="height: 48px; padding: 0 12px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
              <option value="">Elige una opción</option>
              <option>Sistema POS</option>
              <option>App móvil</option>
              <option>Tienda en línea</option>
              <option>Sitio web</option>
              <option>Base de datos</option>
              <option>Sistema a la medida o integración</option>
              <option>Todavía no lo sé</option>
            </select>
          </div>
          <div style="display: flex; flex-direction: column; gap: 8px">
            <label for="cm-msg" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Cuéntanos tu proyecto</label>
            <textarea id="cm-msg" name="mensaje" rows="4" placeholder="¿A qué se dedica tu negocio y qué te gustaría resolver?" style="padding: 12px 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px; line-height: 1.5; resize: vertical"></textarea>
          </div>
          <div style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center; justify-content: space-between">
            <span style="font-size: 13px; color: #8E99A4">Solo usamos tus datos para responderte.</span>
            <button type="submit" class="cm-btn" style="height: 52px; padding: 0 28px; border-radius: 999px; border: 0; background: #1FBFA9; color: #06201C; font: inherit; font-size: 16px; font-weight: 700; cursor: pointer">Enviar mensaje</button>
          </div>
        </form>
      </div>
    </div>
  </section>
