<?php

namespace App\Models;

use App\Models\Concerns\ClearsLandingCache;
use App\Settings\SiteSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LegalPage extends Model
{
    use ClearsLandingCache, HasFactory;

    public const PRIVACY = 'aviso-de-privacidad';

    public const TERMS = 'terminos-y-condiciones';

    /** Marcadores que se pueden usar en el contenido y se reemplazan con los datos de Ajustes. */
    public const TOKENS = [
        '{{responsable}}' => 'Nombre o razón social del responsable',
        '{{domicilio}}' => 'Domicilio del responsable',
        '{{correo_privacidad}}' => 'Correo para ejercer derechos ARCO',
        '{{sitio}}' => 'Dirección del sitio web',
        '{{fecha}}' => 'Fecha de la última actualización',
    ];

    protected $fillable = ['slug', 'title', 'meta_description', 'content', 'sort', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderBy('id');
    }

    /** Contenido con los marcadores reemplazados y solo las etiquetas HTML permitidas. */
    public function renderedContent(?SiteSettings $settings = null): string
    {
        $settings ??= app(SiteSettings::class);

        $pending = '<mark class="cm-legal-pending">[dato pendiente: captúralo en Ajustes del sitio]</mark>';

        $values = [
            '{{responsable}}' => e($settings->legal_name ?: '') ?: $pending,
            '{{domicilio}}' => e($settings->business_address ?: '') ?: $pending,
            '{{correo_privacidad}}' => e($settings->privacy_email ?: $settings->contact_email ?: '') ?: $pending,
            '{{sitio}}' => e(url('/')),
            '{{fecha}}' => e(Carbon::parse($this->updated_at ?? now())->locale('es')->translatedFormat('j \d\e F \d\e Y')),
        ];

        $html = strtr($this->content, $values);

        return strip_tags($html, '<p><h2><h3><h4><ul><ol><li><strong><b><em><i><a><br><blockquote><mark><hr>');
    }
}
