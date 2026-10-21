<?php

namespace App\Models;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'business', 'whatsapp', 'email', 'type', 'message', 'status', 'notes',
        'ip', 'user_agent', 'utm_source', 'utm_medium', 'utm_campaign',
    ];

    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
            'status' => LeadStatus::class,
        ];
    }

    /** Enlace de WhatsApp al número del lead (México, +52). */
    public function whatsappUrl(): string
    {
        $digits = preg_replace('/\D+/', '', $this->whatsapp);
        $text = rawurlencode("Hola {$this->name}, te escribimos de Tuldev sobre tu solicitud de {$this->type->getLabel()}.");

        return "https://wa.me/52{$digits}?text={$text}";
    }
}
