@props(['s'])
@php
    $places = collect(preg_split('/\R/', (string) $s->coverage_places))->map(fn ($p) => trim($p))->filter()->values();
@endphp
@if ($places->isNotEmpty())
  <section aria-label="Zonas donde tenemos clientes" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 0 24px 72px">
    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 14px 20px">
      <p style="margin: 0; font-size: 15px; line-height: 1.5; color: #B7C0C9">{{ $s->coverage_title }}</p>
      <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: 10px">
        @foreach ($places as $place)
        <li style="display: inline-flex; align-items: center; gap: 8px; min-height: 36px; padding: 0 16px; border-radius: 999px; border: 1px solid #232B33; background: rgba(14,18,21,0.72); color: #F1F4F6; font-size: 14px; font-weight: 600">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1FBFA9" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"></path><circle cx="12" cy="9.5" r="2.5"></circle></svg>{{ $place }}
        </li>
        @endforeach
      </ul>
    </div>
  </section>
@endif
