<div>
  @if ($sent)
  <div id="cm-ok">
    <div role="status" style="display: flex; flex-direction: column; gap: 14px; align-items: flex-start; padding: 24px 0">
      <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(31,191,169,0.14); display: flex; align-items: center; justify-content: center"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10"></path></svg></div>
      <h3 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.02em">¡Recibimos tu mensaje!</h3>
      <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #B7C0C9">Te contactaremos pronto para platicar de tu proyecto.</p>
      <button type="button" wire:click="resetForm" style="height: 44px; padding: 0 18px; border-radius: 999px; border: 1px solid #2A333C; background: transparent; color: #F1F4F6; font: inherit; font-size: 14px; font-weight: 600; cursor: pointer">Enviar otro mensaje</button>
    </div>
  </div>
  @else
  <div id="cm-form-wrap">
    <form id="cm-form" wire:submit="submit" novalidate style="display: flex; flex-direction: column; gap: 18px">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(200px, 100%), 1fr)); gap: 16px">
            <div class="cm-field" style="--i: 0; display: flex; flex-direction: column; gap: 8px">
              <label for="cm-nombre" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Nombre</label>
              <input id="cm-nombre" wire:model="name" type="text" required autocomplete="name" placeholder="Tu nombre" @error('name') aria-invalid="true" aria-describedby="cm-name-error" @enderror style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
              @error('name')<span id="cm-name-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
            </div>
            <div class="cm-field" style="--i: 1; display: flex; flex-direction: column; gap: 8px">
              <label for="cm-negocio" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Negocio o empresa</label>
              <input id="cm-negocio" wire:model="business" type="text" autocomplete="organization" placeholder="Nombre de tu negocio" @error('business') aria-invalid="true" aria-describedby="cm-business-error" @enderror style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
              @error('business')<span id="cm-business-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
            </div>
            <div class="cm-field" style="--i: 2; display: flex; flex-direction: column; gap: 8px">
              <label for="cm-tel" style="font-size: 14px; font-weight: 600; color: #D5DBE1">WhatsApp</label>
              <input id="cm-tel" wire:model="whatsapp" type="tel" required autocomplete="tel" placeholder="10 dígitos" @error('whatsapp') aria-invalid="true" aria-describedby="cm-whatsapp-error" @enderror style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
              @error('whatsapp')<span id="cm-whatsapp-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
            </div>
            <div class="cm-field" style="--i: 3; display: flex; flex-direction: column; gap: 8px">
              <label for="cm-correo" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Correo</label>
              <input id="cm-correo" wire:model="email" type="email" autocomplete="email" placeholder="tu@correo.com" @error('email') aria-invalid="true" aria-describedby="cm-email-error" @enderror style="height: 48px; padding: 0 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
              @error('email')<span id="cm-email-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
            </div>
      </div>
      <div class="cm-field" style="--i: 4; display: flex; flex-direction: column; gap: 8px">
        <label for="cm-tipo" style="font-size: 14px; font-weight: 600; color: #D5DBE1">¿Qué necesitas?</label>
        <select id="cm-tipo" wire:model="type" required @error('type') aria-invalid="true" aria-describedby="cm-type-error" @enderror style="height: 48px; padding: 0 12px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px">
          <option value="">Elige una opción</option>
          @foreach ($types as $option)
          <option value="{{ $option->value }}">{{ $option->getLabel() }}</option>
          @endforeach
        </select>
        @error('type')<span id="cm-type-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
      </div>
      <div class="cm-field" style="--i: 5; display: flex; flex-direction: column; gap: 8px">
        <label for="cm-msg" style="font-size: 14px; font-weight: 600; color: #D5DBE1">Cuéntanos tu proyecto</label>
        <textarea id="cm-msg" wire:model="message" rows="4" placeholder="¿A qué se dedica tu negocio y qué te gustaría resolver?" @error('message') aria-invalid="true" aria-describedby="cm-message-error" @enderror style="padding: 12px 14px; border-radius: 10px; border: 1px solid #2A333C; background: #0A0D10; color: #F1F4F6; font: inherit; font-size: 15px; line-height: 1.5; resize: vertical"></textarea>
        @error('message')<span id="cm-message-error" role="alert" style="font-size: 13px; color: #F08A8A">{{ $message }}</span>@enderror
      </div>
      <div aria-hidden="true" style="position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden">
        <label for="cm-website">No llenes este campo</label>
        <input id="cm-website" wire:model="website" type="text" tabindex="-1" autocomplete="off">
      </div>
      @error('form')<div role="alert" style="font-size: 14px; color: #F08A8A">{{ $message }}</div>@enderror
      <div style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center; justify-content: space-between">
        <span style="font-size: 13px; color: #8E99A4">Solo usamos tus datos para responderte.</span>
        <button type="submit" class="cm-btn" wire:loading.attr="disabled" style="height: 52px; padding: 0 28px; border-radius: 999px; border: 0; background: #1FBFA9; color: #06201C; font: inherit; font-size: 16px; font-weight: 700; cursor: pointer">Enviar mensaje</button>
      </div>
    </form>
  </div>
  @endif
</div>
