<?php

use App\Enums\LeadStatus;
use App\Livewire\ContactForm;
use App\Mail\NewLeadMail;
use App\Models\Lead;
use App\Settings\SiteSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

function validForm(array $overrides = []): array
{
    return array_merge([
        'name' => 'Ana Pérez',
        'business' => 'Panadería La Espiga',
        'whatsapp' => '775 123 4567',
        'email' => 'ana@example.com',
        'type' => 'pos',
        'message' => 'Necesito un punto de venta.',
    ], $overrides);
}

function fillAndSubmit($component, array $data)
{
    foreach ($data as $key => $value) {
        $component->set($key, $value);
    }

    // Simula que pasó el tiempo mínimo de llenado.
    return $component->set('startedAt', time() - 30)->call('submit');
}

beforeEach(function () {
    RateLimiter::clear('contact-form:127.0.0.1');
    Mail::fake();
});

it('renderiza el formulario en la landing', function () {
    $this->get('/')->assertSeeLivewire(ContactForm::class);
});

it('valida los campos requeridos', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertHasErrors([
            'name' => 'required', 'business' => 'required', 'whatsapp' => 'required',
            'email' => 'required', 'type' => 'required', 'message' => 'required',
        ]);
});

it('exige cada campo por separado', function (string $field) {
    $component = Livewire::test(ContactForm::class);

    fillAndSubmit($component, validForm([$field => '']))->assertHasErrors([$field => 'required']);

    expect(Lead::count())->toBe(0);
})->with(['name', 'business', 'whatsapp', 'email', 'type', 'message']);

it('exige un mensaje de al menos 10 caracteres', function () {
    fillAndSubmit(Livewire::test(ContactForm::class), validForm(['message' => 'Hola']))
        ->assertHasErrors(['message' => 'min']);
});

it('valida cada campo en cuanto se llena, sin esperar al envío', function () {
    Livewire::test(ContactForm::class)
        ->set('email', 'no-es-correo')->assertHasErrors(['email' => 'email'])
        ->set('email', 'ana@example.com')->assertHasNoErrors('email')
        ->set('whatsapp', '123')->assertHasErrors(['whatsapp' => 'regex'])
        ->set('whatsapp', '775 123 4567')->assertHasNoErrors('whatsapp')->assertSet('whatsapp', '7751234567');
});

it('muestra los mensajes de error en español', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertSee('Escribe tu nombre.')
        ->assertSee('Escribe tu correo electrónico.')
        ->assertSee('Cuéntanos brevemente tu proyecto.');
});

it('marca todos los campos como obligatorios en el formulario', function () {
    $html = $this->get('/')->getContent();

    expect(substr_count($html, 'aria-required="true"'))->toBe(6);
});

it('valida el formato del WhatsApp, del correo y del tipo', function () {
    $component = Livewire::test(ContactForm::class);

    fillAndSubmit($component, validForm(['whatsapp' => '12345', 'email' => 'no-es-correo', 'type' => 'otro']))
        ->assertHasErrors(['whatsapp', 'email', 'type']);

    expect(Lead::count())->toBe(0);
});

it('guarda el lead, normaliza el WhatsApp y muestra el éxito', function () {
    $component = Livewire::test(ContactForm::class);

    fillAndSubmit($component, validForm())
        ->assertHasNoErrors()
        ->assertSet('sent', true)
        ->assertSee('¡Recibimos tu mensaje!');

    $lead = Lead::first();
    expect($lead->whatsapp)->toBe('7751234567')
        ->and($lead->status)->toBe(LeadStatus::Nuevo)
        ->and($lead->name)->toBe('Ana Pérez');
});

it('encola el correo al destinatario configurado', function () {
    $settings = app(SiteSettings::class);
    $settings->lead_notification_email = 'leads@tuldev.test';
    $settings->save();

    fillAndSubmit(Livewire::test(ContactForm::class), validForm());

    Mail::assertQueued(NewLeadMail::class, fn (NewLeadMail $mail) => $mail->hasTo('leads@tuldev.test'));
});

it('no envía correo si no hay destinatario configurado', function () {
    fillAndSubmit(Livewire::test(ContactForm::class), validForm());

    Mail::assertNothingQueued();
    expect(Lead::count())->toBe(1);
});

it('guarda los UTM presentes en la URL', function () {
    Livewire::withQueryParams(['utm_source' => 'google', 'utm_medium' => 'cpc', 'utm_campaign' => 'pos'])
        ->test(ContactForm::class)
        ->tap(fn ($c) => fillAndSubmit($c, validForm()));

    expect(Lead::first()->only('utm_source', 'utm_medium', 'utm_campaign'))
        ->toBe(['utm_source' => 'google', 'utm_medium' => 'cpc', 'utm_campaign' => 'pos']);
});

it('descarta en silencio los envíos que llenan el honeypot', function () {
    fillAndSubmit(Livewire::test(ContactForm::class), validForm(['website' => 'http://spam.test']))
        ->assertSet('sent', true);

    expect(Lead::count())->toBe(0);
    Mail::assertNothingQueued();
});

it('rechaza envíos demasiado rápidos', function () {
    $component = Livewire::test(ContactForm::class);

    foreach (validForm() as $key => $value) {
        $component->set($key, $value);
    }

    $component->call('submit')->assertHasErrors('form');

    expect(Lead::count())->toBe(0);
});

it('limita a 5 envíos por minuto por IP', function () {
    foreach (range(1, 5) as $i) {
        fillAndSubmit(Livewire::test(ContactForm::class), validForm(['name' => "Persona {$i}"]))
            ->assertSet('sent', true);
    }

    fillAndSubmit(Livewire::test(ContactForm::class), validForm(['name' => 'Persona 6']))
        ->assertHasErrors('form')
        ->assertSet('sent', false);

    expect(Lead::count())->toBe(5);
});

it('permite enviar otro mensaje después del éxito', function () {
    $component = fillAndSubmit(Livewire::test(ContactForm::class), validForm());

    $component->call('resetForm')->assertSet('sent', false)->assertSet('name', '');
});

it('arma el enlace de WhatsApp del lead', function () {
    $lead = Lead::factory()->create(['whatsapp' => '7751234567']);

    expect($lead->whatsappUrl())->toStartWith('https://wa.me/527751234567?text=');
});

it('renderiza el correo de notificación en español', function () {
    $lead = Lead::factory()->create(['name' => 'Luis Ramírez', 'message' => 'Quiero una tienda en línea.']);

    $html = (new NewLeadMail($lead))->render();

    expect($html)->toContain('Nueva solicitud de contacto', 'Luis Ramírez', 'Quiero una tienda en línea.', 'Abrir WhatsApp');
});
