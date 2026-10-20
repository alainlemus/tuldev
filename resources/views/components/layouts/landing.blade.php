@props(['s'])
<!doctype html>
<html lang="es-MX">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $s->seo_title }}</title>
<meta name="description" content="{{ $s->seo_description }}">
<link rel="icon" href="{{ asset('brand/isotipo.svg') }}" type="image/svg+xml">
@vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body data-hero-bg="{{ $s->hero_background }}">
<div style="min-height: 100vh; background: #08090B; color: #F1F4F6; font-family: 'Plus Jakarta Sans', system-ui, sans-serif">
{{ $slot }}
</div>
</body>
</html>
