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
        ->assertSee('"@type":"WebSite"', false)
        ->assertSee('property="og:image"', false)
        ->assertSee('images/og-codemida.jpg', false)
        ->assertSee('name="twitter:card" content="summary_large_image"', false)
        ->assertSee('hreflang="es-MX"', false)
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

it('convierte a WebP las imágenes JPG subidas y borra el original', function () {
    Storage::fake('public');
    Storage::disk('public')->putFileAs('projects', UploadedFile::fake()->image('captura.jpg', 400, 900), 'captura.jpg');

    $new = ImageOptimizer::convert('projects/captura.jpg');

    expect($new)->toBe('projects/captura.webp')
        ->and(Storage::disk('public')->exists('projects/captura.webp'))->toBeTrue()
        ->and(Storage::disk('public')->exists('projects/captura.jpg'))->toBeFalse();
});

it('deja intactos los SVG y los WebP', function () {
    expect(ImageOptimizer::convert('technologies/php.svg'))->toBe('technologies/php.svg')
        ->and(ImageOptimizer::convert('apps/x.webp'))->toBe('apps/x.webp');
});

it('convierte a WebP al guardar un proyecto con imagen JPG', function () {
    Storage::fake('public');
    Storage::disk('public')->putFileAs('projects', UploadedFile::fake()->image('nuevo.png', 300, 600), 'nuevo.png');

    $project = \App\Models\Project::factory()->create(['scroll_image' => 'projects/nuevo.png']);

    expect($project->fresh()->scroll_image)->toBe('projects/nuevo.webp')
        ->and(Storage::disk('public')->exists('projects/nuevo.webp'))->toBeTrue();
});
