@props(['s', 'projects'])
  <section id="portafolio" style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 40px 24px 96px; display: flex; flex-direction: column; gap: 44px">
    <div style="display: flex; flex-wrap: wrap; gap: 24px; justify-content: space-between; align-items: flex-end">
      <div style="display: flex; flex-direction: column; gap: 14px; max-width: 640px">
        <div style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; color: #5FE0CC">&lt;portafolio&gt;</div>
        <h2 class="cm-reveal" style="margin: 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.08">{{ $s->portfolio_title }}</h2>
      </div>
      <p class="cm-reveal" style="margin: 0; max-width: 440px; font-size: 17px; line-height: 1.6; color: #B7C0C9">{{ $s->portfolio_intro }}</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(340px, 100%), 1fr)); gap: 24px">
      @foreach ($projects as $project)
      <article class="cm-proj" style="display: flex; flex-direction: column; gap: 16px">
        <div class="cm-frame" style="border-radius: 14px; border: 1px solid #232B33; background: #0E1215; overflow: hidden">
          <div style="display: flex; align-items: center; gap: 6px; padding: 10px 12px; border-bottom: 1px solid #1C2329"><span style="width: 9px; height: 9px; border-radius: 50%; background: #3A434C"></span><span style="width: 9px; height: 9px; border-radius: 50%; background: #3A434C"></span><span style="width: 9px; height: 9px; border-radius: 50%; background: #3A434C"></span><span style="margin-left: 8px; flex-grow: 1; height: 22px; border-radius: 6px; background: #161B20; display: flex; align-items: center; padding: 0 10px; font-size: 12px; color: #8E99A4">{{ $project->name }}</span></div>
          <div class="cm-shot" role="img" aria-label="{{ $project->altText() }}" style="aspect-ratio: 16 / 10; background-image: url('{{ $project->scrollImageUrl() }}'); animation-duration: {{ $project->scroll_duration }}s{{ $project->scroll_delay ? '; animation-delay: '.$project->scroll_delay.'s' : '' }}"></div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px">
          @if ($project->badge)
          <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center"><h3 style="margin: 0; font-size: 20px; font-weight: 700; letter-spacing: -0.02em">{{ $project->name }}</h3><span style="font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 999px; {{ $project->isOwnProduct() ? 'background: rgba(31,191,169,0.14); color: #5FE0CC' : 'background: #1A2026; color: #B7C0C9' }}">{{ $project->badge }}</span></div>
          @else
          <h3 style="margin: 0; font-size: 20px; font-weight: 700; letter-spacing: -0.02em">{{ $project->name }}</h3>
          @endif
          <p style="margin: 0; font-size: 15px; line-height: 1.55; color: #B7C0C9">{{ $project->description }}</p>
          @if ($project->tags)
          <div style="font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 12px; color: #8E99A4">{{ implode(' · ', $project->tags) }}</div>
          @endif
        </div>
      </article>
      @endforeach
    </div>
  </section>
