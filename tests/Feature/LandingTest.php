<?php

use App\Models\App;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use App\Settings\SiteSettings;

it('muestra el contenido publicado y oculta el no publicado', function () {
    Service::factory()->create(['title' => 'Servicio visible']);
    Service::factory()->inactive()->create(['title' => 'Servicio oculto']);
    Project::factory()->create(['name' => 'Proyecto visible']);
    Project::factory()->unpublished()->create(['name' => 'Proyecto oculto']);
    App::factory()->create(['name' => 'App visible']);
    App::factory()->unpublished()->create(['name' => 'App oculta']);
    Technology::factory()->create(['name' => 'TecVisible', 'row' => 1]);
    Technology::factory()->inactive()->create(['name' => 'TecOculta']);

    $this->get('/')
        ->assertOk()
        ->assertSee(['Servicio visible', 'Proyecto visible', 'App visible', 'TecVisible'])
        ->assertDontSee(['Servicio oculto', 'Proyecto oculto', 'App oculta', 'TecOculta']);
});

it('responde igual en solicitudes repetidas con la caché activa', function () {
    Service::factory()->create(['title' => 'Servicio en caché']);

    $this->get('/')->assertOk();
    $this->get('/')->assertOk()->assertSee('Servicio en caché');
});

it('limpia la caché al guardar contenido y ajustes', function () {
    Service::factory()->create(['title' => 'Antes']);
    $this->get('/')->assertSee('Antes');

    Service::query()->update(['title' => 'Después']);
    Service::first()->save();
    $this->get('/')->assertSee('Después');

    $settings = app(SiteSettings::class);
    $settings->hero_title = 'Título nuevo del hero';
    $settings->save();

    $this->get('/')->assertSee('Título nuevo del hero');
});

it('toma el fondo del hero de los ajustes', function () {
    $settings = app(SiteSettings::class);
    $settings->hero_background = \App\Enums\HeroBackground::Pulsos;
    $settings->save();

    $this->get('/')->assertSee('data-hero-bg="pulsos"', false);
});

it('oculta los enlaces de contacto vacíos y genera el de WhatsApp cuando existe', function () {
    $this->get('/')->assertDontSee('wa.me');

    $settings = app(SiteSettings::class);
    $settings->contact_whatsapp = '7751234567';
    $settings->save();

    $this->get('/')->assertSee('https://wa.me/527751234567', false);
});

it('muestra el botón flotante de WhatsApp solo si hay número configurado', function () {
    $this->get('/')->assertDontSee('cm-wa');

    $settings = app(SiteSettings::class);
    $settings->contact_whatsapp = '7751234567';
    $settings->contact_whatsapp_message = 'Hola, quiero cotizar';
    $settings->save();

    $this->get('/')
        ->assertSee('class="cm-wa"', false)
        ->assertSee('https://wa.me/527751234567?text=Hola%2C%20quiero%20cotizar', false);
});
