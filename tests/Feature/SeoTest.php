<?php

use App\Models\Service;
use App\Settings\SiteSettings;
use App\Support\ImageOptimizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('incluye meta tags, canonical y datos estructurados', function () {
    Service::factory()->create(['title' => 'Sistemas POS']);

    $settings = app(SiteSettings::class);
    $settings->seo_title = 'Título SEO de prueba';
    $settings->save();

    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="es-MX">', false)
        ->assertSee('<title>Título SEO de prueba</title>', false)
        ->assertSee('rel="canonical"', false)
        ->assertSee('property="og:title"', false)
        ->assertSee('name="twitter:card"', false)
        ->assertSee('"@type":"ProfessionalService"', false)
        ->assertSee('Tulancingo de Bravo', false)
        ->assertSee('Sistemas POS', false);
});

it('no inventa teléfono ni dirección en los datos estructurados', function () {
    $json = $this->get('/')->getContent();

    expect($json)->not->toContain('"telephone"')->not->toContain('"streetAddress"');
});

it('sirve robots.txt bloqueando el panel y apuntando al sitemap', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertSee('Disallow: /admin', false)
        ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
});

it('sirve un sitemap.xml válido', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee('<loc>'.url('/').'</loc>', false);
});

it('genera la versión WebP de las imágenes subidas', function () {
    Storage::fake('public');
    Storage::disk('public')->putFileAs('projects', UploadedFile::fake()->image('captura.jpg', 400, 900), 'captura.jpg');

    ImageOptimizer::generate('projects/captura.jpg');

    expect(Storage::disk('public')->exists('projects/captura.jpg.webp'))->toBeTrue()
        ->and(ImageOptimizer::webpUrl('projects/captura.jpg'))->not->toBeNull();
});
