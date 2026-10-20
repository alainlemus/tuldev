@props(['s', 'stats'])
@if ($stats->count() >= 2)
  <section aria-label="Cifras de Codemida" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 24px 24px 72px">
    <div class="cm-scrub cm-stats" style="border-radius: 20px; border: 1px solid #232B33; background: rgba(14,18,21,0.72); display: grid; grid-template-columns: repeat(auto-fit, minmax(min(220px, 100%), 1fr))">
      @foreach ($stats as $stat)
      @php
          preg_match('/^(\D*?)(\d[\d.,]*)(.*)$/u', $stat->value, $m);
      @endphp
      <div class="cm-stat" style="padding: 32px 28px; display: flex; flex-direction: column; gap: 8px">
        <div style="font-size: clamp(44px, 6vw, 68px); font-weight: 800; letter-spacing: -0.045em; line-height: 1; color: #F1F4F6">
          @if ($m)<span data-count="{{ str_replace(',', '', $m[2]) }}" data-prefix="{{ $m[1] }}" data-suffix="{{ $m[3] }}">{{ $stat->value }}</span>@else{{ $stat->value }}@endif
        </div>
        <div style="font-size: 15px; line-height: 1.5; color: #B7C0C9">{{ $stat->label }}</div>
      </div>
      @endforeach
    </div>
  </section>
@endif
