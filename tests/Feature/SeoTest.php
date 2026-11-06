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
        ->assertSee('brand/png/imagen-redes-1200x630.png', false)
        ->assertSee('name="twitter:card" content="summary_large_image"', false)
        ->assertSee('hreflang="es-MX"', false)
        ->assertSee('Tulancingo de Bravo', false)
        ->assertSee('Sistemas POS', false);
});

it('no inventa teléfono ni dirección en los datos estructurados', function () {
    $json = $this->get('/')->getContent();

    expect($json)->not->toContain('"telephone"')->not->toContain('"streetAddress"');
});

it('ubica el negocio en Tulancingo sin publicar el domicilio fiscal a los buscadores', function () {
    $settings = app(SiteSettings::class);
    $settings->business_address = 'Calle Fiscal 123, Ciudad de México';
    $settings->business_phone = '55 1234 5678';
    $settings->save();

    $html = $this->get('/')->getContent();

    expect($html)
        ->toContain('"addressLocality":"Tulancingo de Bravo"')
        ->toContain('"telephone":"+525512345678"')
        ->not->toContain('"streetAddress"')
        ->not->toContain('Calle Fiscal 123');
});

it('menciona el desarrollo de software en Tulancingo y Pachuca en la portada y en los servicios', function () {
    $this->get('/')
        ->assertSee('<title>Desarrollo de software en Tulancingo y Pachuca | Tuldev</title>', false)
        ->assertSee('{ desarrollo de software en Tulancingo }', false)
        ->assertSee('Desarrollo de software a la medida en Tulancingo y Pachuca, Hidalgo:', false)
        ->assertSee('Desarrollo de software en Tulancingo y Pachuca, con un solo equipo', false)
        ->assertSee('Para negocios de Tulancingo, Pachuca y todo Hidalgo', false);
});

it('agrega Pachuca a los servicios sin tocar lo editado desde el panel', function () {
    \App\Models\Faq::factory()->create();
    $original = Service::factory()->create([
        'title' => 'Páginas web administrables',
        'description' => 'Páginas web en Tulancingo, rápidas y bien posicionadas en Google, con panel para que actualices tu menú, productos o promociones sin depender de nadie.',
    ]);
    $edited = Service::factory()->create(['title' => 'Sistemas POS', 'description' => 'Texto propio']);

    (require database_path('migrations/2026_11_06_100001_add_pachuca_to_services_copy.php'))->up();

    expect($original->fresh()->description)->toStartWith('Páginas web en Tulancingo y Pachuca')
        ->and($edited->fresh()->description)->toBe('Texto propio')
        ->and(\App\Models\Faq::where('question', 'like', '%negocios de Pachuca%')->exists())->toBeTrue();
});

it('enfoca en Tulancingo los textos sin tocar lo editado desde el panel', function () {
    $faq = \App\Models\Faq::factory()->create();
    $original = Service::factory()->create([
        'title' => 'Tiendas en línea',
        'description' => 'Vende las 24 horas con catálogo, carrito, pagos con tarjeta y envíos, conectada a tu inventario real.',
    ]);
    $edited = Service::factory()->create(['title' => 'Sistemas POS', 'description' => 'Texto propio']);

    (require database_path('migrations/2026_11_06_100000_focus_services_copy_on_tulancingo.php'))->up();

    expect($original->fresh()->description)->toStartWith('Tu tienda en línea desde Tulancingo')
        ->and($edited->fresh()->description)->toBe('Texto propio')
        ->and(\App\Models\Faq::where('question', 'like', '%servicios de desarrollo de software%')->first()->sort)->toBe($faq->sort + 1);
});

it('sirve robots.txt bloqueando el panel y apuntando al sitemap', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertSee('Disallow: /admin', false)
        ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
});

it('no bloquea en robots.txt el JavaScript de Livewire que usa la página', function () {
    $this->get('/robots.txt')->assertDontSee('/livewire', false);
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
