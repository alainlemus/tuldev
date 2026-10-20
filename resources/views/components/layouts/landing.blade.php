@props(['s', 'services', 'faqs' => null, 'pageTitle' => null, 'pageDescription' => null, 'canonical' => null, 'structured' => true])
@php
    $siteUrl = $canonical ?? url('/');
    $title = $pageTitle ?? $s->seo_title;
    $description = $pageDescription ?? $s->seo_description;
    $hasCustomOg = filled($s->seo_image);
    $ogImage = $hasCustomOg ? url(Storage::disk('public')->url($s->seo_image)) : url('images/og-codemida.jpg');
    $ogAlt = 'Codemida: software a la medida en Tulancingo, Hidalgo';
    $fonts = [
        'node_modules/@fontsource/plus-jakarta-sans/files/plus-jakarta-sans-latin-400-normal.woff2',
        'node_modules/@fontsource/plus-jakarta-sans/files/plus-jakarta-sans-latin-800-normal.woff2',
    ];
@endphp
<!doctype html>
<html lang="es-MX">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="Codemida">
<meta name="theme-color" content="#08090B">
<meta name="color-scheme" content="dark">
<meta name="format-detection" content="telephone=no">
<link rel="canonical" href="{{ $siteUrl }}">
<link rel="alternate" hreflang="es-MX" href="{{ $siteUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $siteUrl }}">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
<link rel="icon" href="{{ asset('brand/isotipo.svg') }}" type="image/svg+xml">
<link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png" sizes="32x32">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="es_MX">
<meta property="og:site_name" content="Codemida">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $siteUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ str_replace('http://', 'https://', $ogImage) }}">
<meta property="og:image:alt" content="{{ $ogAlt }}">
@unless ($hasCustomOg)
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endunless
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="{{ $ogAlt }}">
@foreach ($fonts as $font)
<link rel="preload" href="{{ Vite::asset($font) }}" as="font" type="font/woff2" crossorigin>
@endforeach
@if ($structured)
<script type="application/ld+json">{!! json_encode(\App\Support\StructuredData::graph($s, $services, $ogImage, $faqs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endif
@vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body data-hero-bg="{{ $s->hero_background }}">
<div class="cm-bg-global" aria-hidden="true"></div>
<div style="min-height: 100vh; color: #F1F4F6; font-family: 'Plus Jakarta Sans', system-ui, sans-serif">
{{ $slot }}
</div>
</body>
</html>
