<?php

namespace App\Livewire;

use App\Enums\LeadType;
use App\Mail\NewLeadMail;
use App\Models\Lead;
use App\Settings\SiteSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    private const MAX_ATTEMPTS_PER_MINUTE = 5;

    private const MIN_SECONDS_TO_FILL = 3;

    public string $name = '';

    public string $business = '';

    public string $whatsapp = '';

    public string $email = '';

    public string $type = '';

    public string $message = '';

    /** Honeypot: los humanos no lo ven ni lo llenan. */
    public string $website = '';

    public int $startedAt = 0;

    public bool $sent = false;

    /** @var array<string, string> */
    public array $utm = [];

    public function mount(): void
    {
        $this->startedAt = time();

        foreach (['utm_source', 'utm_medium', 'utm_campaign'] as $key) {
            if ($value = request()->query($key)) {
                $this->utm[$key] = mb_substr((string) $value, 0, 190);
            }
        }
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'business' => ['required', 'string', 'min:2', 'max:120'],
            'whatsapp' => ['required', 'regex:/^\d{10}$/'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'type' => ['required', Rule::enum(LeadType::class)],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    /** @return array<string, string> */
    protected function validationAttributes(): array
    {
        return [
            'name' => 'nombre',
            'business' => 'negocio',
            'whatsapp' => 'WhatsApp',
            'email' => 'correo',
            'type' => 'tipo de proyecto',
            'message' => 'mensaje',
        ];
    }

    /** @return array<string, string> */
    protected function messages(): array
    {
        return [
            'name.required' => 'Escribe tu nombre.',
            'name.min' => 'Escribe tu nombre completo.',
            'business.required' => 'Escribe el nombre de tu negocio o empresa.',
            'business.min' => 'Escribe el nombre de tu negocio o empresa.',
            'whatsapp.required' => 'Escribe tu número de WhatsApp.',
            'whatsapp.regex' => 'El WhatsApp debe tener 10 dígitos.',
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email' => 'Escribe un correo válido, por ejemplo tu@correo.com.',
            'type.required' => 'Elige qué necesitas.',
            'type.Illuminate\Validation\Rules\Enum' => 'Elige una de las opciones de la lista.',
            'message.required' => 'Cuéntanos brevemente tu proyecto.',
            'message.min' => 'Cuéntanos un poco más (mínimo 10 caracteres).',
        ];
    }

    /** Valida cada campo cuando la persona sale de él, para avisarle antes de enviar. */
    public function updated(string $property): void
    {
        if (! in_array($property, ['name', 'business', 'whatsapp', 'email', 'type', 'message'], true)) {
            return;
        }

        if ($property === 'whatsapp') {
            $this->whatsapp = preg_replace('/\D+/', '', $this->whatsapp) ?? '';
        }

        $this->validateOnly($property);
    }

    public function submit(): void
    {
        $this->whatsapp = preg_replace('/\D+/', '', $this->whatsapp) ?? '';

        $this->validate();

        // Un bot que llena el honeypot cree que todo salió bien, pero no se guarda nada.
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        if (time() - $this->startedAt < self::MIN_SECONDS_TO_FILL) {
            $this->addError('form', 'Revisa tus datos y vuelve a enviar el formulario.');
            $this->startedAt = time() - self::MIN_SECONDS_TO_FILL;

            return;
        }

        $key = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS_PER_MINUTE)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('form', "Enviaste muchos mensajes seguidos. Intenta de nuevo en {$seconds} segundos.");

            return;
        }

        RateLimiter::hit($key, 60);

        $lead = Lead::create([
            'name' => $this->name,
            'business' => $this->business ?: null,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email ?: null,
            'type' => $this->type,
            'message' => $this->message ?: null,
            'ip' => request()->ip(),
            'user_agent' => mb_substr((string) request()->userAgent(), 0, 500),
            ...$this->utm,
        ]);

        if ($to = app(SiteSettings::class)->lead_notification_email) {
            Mail::to($to)->queue(new NewLeadMail($lead));
        }

        $this->sent = true;
    }

    public function resetForm(): void
    {
        $this->reset('name', 'business', 'whatsapp', 'email', 'type', 'message', 'website', 'sent');
        $this->resetValidation();
        $this->startedAt = time();
    }

    public function render(): View
    {
        return view('livewire.contact-form', ['types' => LeadType::cases()]);
    }
}
