<?php

use App\Filament\Resources\LegalPages\LegalPageResource;
use App\Models\LegalPage;
use App\Models\User;
use App\Settings\SiteSettings;
use Database\Seeders\LegalPagesSeeder;

beforeEach(fn () => $this->seed(LegalPagesSeeder::class));

it('publica el aviso de privacidad y los términos y condiciones', function () {
    $this->get('/aviso-de-privacidad')
        ->assertOk()
        ->assertSee('Aviso de privacidad')
        ->assertSee('Derechos de acceso, rectificación, cancelación y oposición', false)
        ->assertSee('rel="canonical" href="'.url('/aviso-de-privacidad').'"', false);

    $this->get('/terminos-y-condiciones')->assertOk()->assertSee('Términos y condiciones');
});

it('reemplaza los marcadores con los datos de Ajustes', function () {
    $settings = app(SiteSettings::class);
    $settings->legal_name = 'Juan Pérez López';
    $settings->business_address = 'Calle Falsa 123, Tulancingo, Hgo.';
    $settings->privacy_email = 'privacidad@ejemplo.test';
    $settings->save();

    $this->get('/aviso-de-privacidad')
        ->assertSee('Juan Pérez López')
        ->assertSee('Calle Falsa 123, Tulancingo, Hgo.')
        ->assertSee('privacidad@ejemplo.test')
        ->assertDontSee('dato pendiente')
        ->assertDontSee('{{responsable}}', false);
});

it('marca como pendiente lo que falta capturar y usa el correo de contacto como respaldo', function () {
    $this->get('/aviso-de-privacidad')->assertSee('dato pendiente');

    $settings = app(SiteSettings::class);
    $settings->contact_email = 'hola@ejemplo.test';
    $settings->save();

    $this->get('/aviso-de-privacidad')->assertSee('hola@ejemplo.test');
});

it('no permite HTML peligroso en el contenido', function () {
    LegalPage::where('slug', LegalPage::TERMS)->update(['content' => '<p>Texto</p><script>alert(1)</script><img src=x onerror=alert(2)>']);

    $this->get('/terminos-y-condiciones')->assertSee('Texto')->assertDontSee('<script>alert(1)', false)->assertDontSee('<img', false);
});

it('responde 404 si la página no está publicada o no existe', function () {
    LegalPage::where('slug', LegalPage::TERMS)->update(['is_published' => false]);

    $this->get('/terminos-y-condiciones')->assertNotFound();
    $this->get('/otra-pagina')->assertNotFound();
});

it('enlaza las páginas legales en el pie y en el formulario de contacto', function () {
    $this->get('/')
        ->assertSee(url('/aviso-de-privacidad'), false)
        ->assertSee(url('/terminos-y-condiciones'), false)
        ->assertSee('aviso de privacidad');

    // update() sobre el modelo dispara los eventos que limpian la caché de la landing.
    LegalPage::where('slug', LegalPage::TERMS)->first()->update(['is_published' => false]);

    $this->get('/')->assertDontSee(url('/terminos-y-condiciones'), false);
});

it('incluye las páginas legales en el sitemap', function () {
    $this->get('/sitemap.xml')->assertSee(url('/aviso-de-privacidad'), false)->assertSee(url('/terminos-y-condiciones'), false);
});

it('las páginas legales no llevan los datos estructurados de la empresa', function () {
    $this->get('/aviso-de-privacidad')->assertDontSee('application/ld+json', false);
});

it('se editan desde el panel pero no se pueden crear ni borrar', function () {
    $this->actingAs(User::factory()->create());
    $page = LegalPage::where('slug', LegalPage::PRIVACY)->first();

    $this->get(LegalPageResource::getUrl('index'))->assertSuccessful();
    $this->get(LegalPageResource::getUrl('edit', ['record' => $page]))->assertSuccessful();

    expect(LegalPageResource::canCreate())->toBeFalse()
        ->and(LegalPageResource::canDelete($page))->toBeFalse();
});
