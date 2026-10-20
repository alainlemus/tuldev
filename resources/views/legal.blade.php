<x-layouts.landing
    :s="$s"
    :services="$services"
    :page-title="$page->title.' · Codemida'"
    :page-description="$page->meta_description ?: $s->seo_description"
    :canonical="route('legal', $page->slug)"
    :structured="false"
>
    <x-landing.nav :home="url('/')" />
    <main>
        <article class="cm-legal">
            <a href="{{ url('/') }}" class="cm-link cm-legal-back">← Volver al inicio</a>
            <h1>{{ $page->title }}</h1>
            <div class="cm-legal-body">{!! $page->renderedContent() !!}</div>
        </article>
    </main>
    <x-landing.footer :s="$s" :legal-pages="$legalPages" />
</x-layouts.landing>
