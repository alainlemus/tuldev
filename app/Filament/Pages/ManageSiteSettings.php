<?php

namespace App\Filament\Pages;

use App\Enums\HeroBackground;
use App\Settings\SiteSettings;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSiteSettings extends SettingsPage
{
    protected static string $settings = SiteSettings::class;

    protected static ?string $title = 'Ajustes del sitio';

    protected static ?string $navigationLabel = 'Ajustes del sitio';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Sitio';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->persistTabInQueryString()->tabs([
                Tab::make('Portada')->schema([
                    TextInput::make('hero_eyebrow')->label('Texto pequeño superior')->required(),
                    TextInput::make('hero_title')->label('Título')->required(),
                    Textarea::make('hero_subtitle')->label('Subtítulo')->rows(3)->required(),
                    TextInput::make('hero_primary_label')->label('Botón principal')->required(),
                    TextInput::make('hero_secondary_label')->label('Botón secundario')->required(),
                    Select::make('hero_background')->label('Fondo animado')->options(HeroBackground::class)->required()->native(false),
                ]),
                Tab::make('Frase')->schema([
                    Textarea::make('phrase')->label('Frase animada')->rows(3)->required(),
                    TextInput::make('phrase_accent')->label('Parte final resaltada en verde')->required(),
                ]),
                Tab::make('Secciones')->columns(2)->schema([
                    TextInput::make('services_title')->label('Servicios · título')->required(),
                    Textarea::make('services_intro')->label('Servicios · introducción')->rows(2)->required(),
                    TextInput::make('portfolio_title')->label('Portafolio · título')->required(),
                    Textarea::make('portfolio_intro')->label('Portafolio · introducción')->rows(2)->required(),
                    TextInput::make('apps_title')->label('Apps · título')->required()->columnSpanFull(),
                    TextInput::make('stack_title')->label('Tecnologías · título')->required(),
                    Textarea::make('stack_intro')->label('Tecnologías · introducción')->rows(2)->required(),
                    TextInput::make('contact_title')->label('Contacto · título')->required(),
                    Textarea::make('contact_intro')->label('Contacto · introducción')->rows(2)->required(),
                    TextInput::make('stats_title')->label('Cifras · título (uso interno)')->required()->columnSpanFull(),
                    TextInput::make('coverage_title')->label('Cobertura · título')->required(),
                    Textarea::make('coverage_places')->label('Cobertura · lugares')->helperText('Uno por línea. Si lo dejas vacío, la franja no se muestra.')->rows(3),
                    TextInput::make('process_title')->label('Proceso · título')->required(),
                    Textarea::make('process_intro')->label('Proceso · introducción')->rows(2)->required(),
                    TextInput::make('testimonials_title')->label('Testimonios · título')->required(),
                    Textarea::make('testimonials_intro')->label('Testimonios · introducción')->rows(2)->required(),
                    TextInput::make('faq_title')->label('Preguntas frecuentes · título')->required(),
                    Textarea::make('faq_intro')->label('Preguntas frecuentes · introducción')->rows(2)->required(),
                    TextInput::make('footer_text')->label('Texto del pie de página')->required()->columnSpanFull(),
                ]),
                Tab::make('Llamada final')->schema([
                    TextInput::make('cta_title')->label('Título')->required(),
                    Textarea::make('cta_text')->label('Texto')->rows(2)->required(),
                    TextInput::make('cta_primary_label')->label('Botón de WhatsApp')->helperText('Solo aparece si capturas tu WhatsApp en la pestaña Contacto.')->required(),
                    TextInput::make('cta_secondary_label')->label('Botón al formulario')->required(),
                ]),
                Tab::make('Contacto')->columns(2)->schema([
                    TextInput::make('contact_whatsapp')->label('WhatsApp')->tel()->helperText('10 dígitos; los botones generan el enlace wa.me/52…'),
                    TextInput::make('contact_email')->label('Correo de contacto')->email(),
                    TextInput::make('contact_whatsapp_message')->label('Mensaje inicial del botón flotante de WhatsApp')->required()->maxLength(200)->columnSpanFull(),
                    TextInput::make('contact_area')->label('Ciudad / zona de cobertura')->required(),
                    TextInput::make('lead_notification_email')->label('Correo que recibe los prospectos')->email(),
                    TextInput::make('business_phone')->label('Teléfono (datos estructurados)')->tel(),
                    TextInput::make('business_address')->label('Domicilio fiscal')->helperText('Solo se muestra en el aviso de privacidad y en los términos. Para buscadores, el negocio se ubica en Tulancingo.'),
                    TextInput::make('legal_name')->label('Nombre o razón social del responsable')->helperText('Persona física o moral que figura en el aviso de privacidad y en los términos.'),
                    TextInput::make('privacy_email')->label('Correo para derechos ARCO (privacidad)')->email()->helperText('Si lo dejas vacío se usa el correo de contacto.'),
                ]),
                Tab::make('SEO')->schema([
                    TextInput::make('seo_title')->label('Título')->required()->maxLength(70),
                    Textarea::make('seo_description')->label('Descripción')->rows(3)->required()->maxLength(180),
                    FileUpload::make('seo_image')
                        ->label('Imagen para compartir en redes')
                        ->helperText('JPG o PNG de 1200×630 px. Si la dejas vacía se usa la imagen de Tuldev por defecto. No uses WebP: WhatsApp, LinkedIn y otras redes no lo leen bien.')
                        ->acceptedFileTypes(['image/jpeg', 'image/png'])
                        ->image()->disk('public')->directory('seo')->visibility('public'),
                    Section::make('Redes sociales')->columns(2)->schema([
                        TextInput::make('social_facebook')->label('Facebook')->url(),
                        TextInput::make('social_instagram')->label('Instagram')->url(),
                        TextInput::make('social_linkedin')->label('LinkedIn')->url(),
                        TextInput::make('social_x')->label('X')->url(),
                    ]),
                ]),
            ]),
        ]);
    }
}
