@props(['s'])
@php
    $words = collect(preg_split('/\s+/', trim($s->phrase), -1, PREG_SPLIT_NO_EMPTY))->map(fn ($w) => [$w, 'cm-word'])
        ->merge(collect(preg_split('/\s+/', trim($s->phrase_accent), -1, PREG_SPLIT_NO_EMPTY))->map(fn ($w) => [$w, 'cm-word-a']));
@endphp
  <section aria-label="Nuestra forma de trabajar" class="cm-pin">
   <div class="cm-pin-stick">
    <div style="position: relative; z-index: 1; width: 100%; max-width: 1100px; margin: 0 auto; box-sizing: border-box; padding: 140px 24px 60px">
    <p style="margin: 0; font-size: clamp(30px, 4.6vw, 60px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.12; text-wrap: balance">@foreach ($words as [$word, $class])<span class="{{ $class }}">{{ $word }}</span>{{ $loop->last ? '' : ' ' }}@endforeach</p>
    </div>
   </div>
  </section>
