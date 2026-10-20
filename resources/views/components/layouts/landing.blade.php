@props(['s', 'services'])
@php
    $ogImage = $s->seo_image ? url(Storage::disk('public')->url($s->seo_image)) : null;
@endphp
<!doctype html>
<html lang="es-MX">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $s->seo_title }}</title>
<meta name="description" content="{{ $s->seo_description }}">
<meta name="theme-color" content="#08090B">
<link rel="canonical" href="{{ url('/') }}">
<link rel="icon" href="{{ asset('brand/isotipo.svg') }}" type="image/svg+xml">
<meta property="og:type" content="website">
<meta property="og:locale" content="es_MX">
<meta property="og:site_name" content="Codemida">
<meta property="og:title" content="{{ $s->seo_title }}">
<meta property="og:description" content="{{ $s->seo_description }}">
<meta property="og:url" content="{{ url('/') }}">
@if ($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif
<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $s->seo_title }}">
<meta name="twitter:description" content="{{ $s->seo_description }}">
@if ($ogImage)<meta name="twitter:image" content="{{ $ogImage }}">@endif
<script type="application/ld+json">{!! json_encode(\App\Support\StructuredData::professionalService($s, $services), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body data-hero-bg="{{ $s->hero_background }}">
<div style="min-height: 100vh; background: #08090B; color: #F1F4F6; font-family: 'Plus Jakarta Sans', system-ui, sans-serif">
{{ $slot }}
</div>
</body>
</html>
