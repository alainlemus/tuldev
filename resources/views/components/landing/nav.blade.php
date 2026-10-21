@props(['home' => ''])
  <div class="cm-progress" aria-hidden="true"></div>
  <div class="cm-nav" style="position: sticky; top: 0; z-index: 50; background: rgba(8,9,11,0.72); backdrop-filter: saturate(180%) blur(18px); -webkit-backdrop-filter: saturate(180%) blur(18px); border-bottom: 1px solid rgba(255,255,255,0.06)">
    <header style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 12px 24px; display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between; align-items: center">
      <a href="{{ $home ?: '#' }}" style="display: flex; align-items: center; text-decoration: none">
        <img src="{{ asset('brand/svg/nombre-solo-para-fondo-oscuro.svg') }}" alt="Tuldev" width="140" height="30" style="height: 30px; width: auto; display: block">
      </a>
      <nav aria-label="Principal" style="display: flex; flex-wrap: wrap; gap: 4px; align-items: center">
        <a href="{{ $home }}#servicios" class="cm-link cm-nav-link" style="padding: 10px 12px; color: #B7C0C9; text-decoration: none; font-size: 14px; font-weight: 600">Servicios</a>
        <a href="{{ $home }}#portafolio" class="cm-link cm-nav-link" style="padding: 10px 12px; color: #B7C0C9; text-decoration: none; font-size: 14px; font-weight: 600">Portafolio</a>
        <a href="{{ $home }}#apps" class="cm-link cm-nav-link" style="padding: 10px 12px; color: #B7C0C9; text-decoration: none; font-size: 14px; font-weight: 600">Apps</a>
        <a href="{{ $home }}#contacto" class="cm-link cm-nav-link" style="padding: 10px 12px; color: #B7C0C9; text-decoration: none; font-size: 14px; font-weight: 600">Contacto</a>
        <a href="{{ $home }}#contacto" class="cm-btn" style="display: inline-flex; align-items: center; height: 44px; padding: 0 18px; margin-left: 6px; border-radius: 999px; background: #F1F4F6; color: #08090B; text-decoration: none; font-size: 14px; font-weight: 700">Cotiza tu proyecto</a>
      </nav>
    </header>
  </div>
