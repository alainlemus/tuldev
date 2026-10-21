<?php

use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Settings\SiteSettings;

it('muestra el proceso, las preguntas frecuentes y las cifras publicadas', function () {
    ProcessStep::factory()->create(['title' => 'Paso visible']);
    ProcessStep::factory()->hidden()->create(['title' => 'Paso oculto']);
    Faq::factory()->create(['question' => '¿Pregunta visible?']);
    Faq::factory()->hidden()->create(['question' => '¿Pregunta oculta?']);
    Stat::factory()->create(['value' => '15+', 'label' => 'años de prueba']);
    Stat::factory()->create(['value' => '9', 'label' => 'proyectos de prueba']);

    $this->get('/')
        ->assertOk()
        ->assertSee(['Paso visible', '¿Pregunta visible?', 'años de prueba', 'proyectos de prueba'])
        ->assertDontSee(['Paso oculto', '¿Pregunta oculta?']);
});

it('oculta las secciones sin contenido', function () {
    $this->get('/')
        ->assertOk()
        ->assertDontSee('id="proceso"', false)
        ->assertDontSee('id="faq"', false)
        ->assertDontSee('id="clientes"', false)
        ->assertDontSee('Cifras de Tuldev');
});

it('no muestra las cifras si hay menos de dos publicadas', function () {
    Stat::factory()->create(['label' => 'única cifra']);

    $this->get('/')->assertDontSee('única cifra');
});

it('muestra testimonios publicados y oculta los no publicados', function () {
    Testimonial::factory()->create(['author' => 'Ana Visible', 'quote' => 'Excelente servicio de prueba.']);
    Testimonial::factory()->hidden()->create(['author' => 'Beto Oculto']);

    $this->get('/')
        ->assertSee(['Ana Visible', 'Excelente servicio de prueba.', 'id="clientes"'], false)
        ->assertDontSee('Beto Oculto');
});

it('agrega las preguntas frecuentes a los datos estructurados', function () {
    Faq::factory()->create(['question' => '¿Hacen apps?', 'answer' => 'Sí, para iOS y Android.']);

    $this->get('/')
        ->assertSee('"@type":"FAQPage"', false)
        ->assertSee('¿Hacen apps?', false);
});

it('usa WhatsApp en la llamada final solo si está configurado', function () {
    $this->get('/')->assertSee('id="hablemos"', false)->assertDontSee('wa.me');

    $settings = app(SiteSettings::class);
    $settings->contact_whatsapp = '7751234567';
    $settings->save();

    $this->get('/')->assertSee('Escríbenos por WhatsApp')->assertSee('https://wa.me/527751234567', false);
});

it('convierte a WebP la foto de un testimonio', function () {
    \Illuminate\Support\Facades\Storage::fake('public');
    \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('testimonials', \Illuminate\Http\UploadedFile::fake()->image('foto.jpg', 200, 200), 'foto.jpg');

    $testimonial = Testimonial::factory()->create(['photo' => 'testimonials/foto.jpg']);

    expect($testimonial->fresh()->photo)->toBe('testimonials/foto.webp');
});

it('muestra las zonas de cobertura y las oculta si no hay ninguna', function () {
    $this->get('/')->assertOk()->assertSee(['Querétaro', 'Ciudad de México', 'todo Hidalgo']);

    $s = app(SiteSettings::class);
    $s->coverage_places = '';
    $s->save();

    $this->get('/')->assertDontSee('Zonas donde tenemos clientes');
});
