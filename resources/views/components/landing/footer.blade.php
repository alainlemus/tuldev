@props(['s', 'legalPages' => collect()])
  <footer style="border-top: 1px solid #1A2026">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 28px 24px; display: flex; flex-wrap: wrap; gap: 12px 24px; justify-content: space-between; align-items: center; font-size: 14px; color: #8E99A4">
      <a href="{{ url('/') }}" style="display: inline-flex; padding: 8px 0"><img src="{{ asset('brand/svg/nombre-solo-para-fondo-oscuro.svg') }}" alt="Tuldev" width="112" height="24" loading="lazy" decoding="async" style="height: 24px; width: auto; display: block"></a></span>
      <span style="display: flex; flex-wrap: wrap; gap: 8px 20px; align-items: center">
        @foreach ($legalPages as $legalPage)
        <a href="{{ route('legal', $legalPage->slug) }}" class="cm-link" style="color: #8E99A4; text-decoration: none; padding: 10px 0">{{ $legalPage->title }}</a>
        @endforeach
        <span>{{ $s->footer_text }}</span>
      </span>
    </div>
  </footer>
