<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $defaults = [
            'hero_eyebrow' => '{ software a la medida }',
            'hero_title' => 'Escribimos el software que tu negocio necesita.',
            'hero_subtitle' => 'Sistemas POS, apps móviles, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia, desde Tulancingo, Hidalgo.',
            'hero_primary_label' => 'Cotiza tu proyecto',
            'hero_secondary_label' => 'Ver proyectos',
            'hero_background' => 'puntos',

            'phrase' => 'Tu negocio no funciona como los demás. Por eso no usamos plantillas: escuchamos, diseñamos y programamos cada sistema',
            'phrase_accent' => 'alrededor de cómo trabajas tú.',

            'services_title' => 'Todo el software de tu negocio, con un solo equipo',
            'services_intro' => 'Desde el punto de venta hasta la app que usan tus clientes. Nada de plantillas: cada sistema se diseña a partir de cómo opera tu empresa.',
            'portfolio_title' => 'Proyectos reales, negocios reales',
            'portfolio_intro' => 'Restaurantes, farmacias, gimnasios, despachos e importadoras de Hidalgo que ya trabajan con software hecho por nosotros.',
            'apps_title' => 'Apps que viven en el bolsillo de tus clientes y tu equipo',
            'stack_title' => 'Tecnologías con las que construimos',
            'stack_intro' => 'Herramientas probadas en producción, elegidas según lo que tu proyecto necesita: del servidor a la tienda de apps.',
            'contact_title' => 'Cuéntanos de tu negocio',
            'contact_intro' => 'Déjanos tus datos y qué necesitas. Te contactamos para entender cómo trabajas y proponerte una solución, sin compromiso.',
            'footer_text' => 'Software a la medida · Tulancingo, Hidalgo · © 2026 Codemida',

            'contact_whatsapp' => null,
            'contact_email' => null,
            'contact_area' => 'Tulancingo, Hidalgo · proyectos en todo México',
            'lead_notification_email' => null,
            'business_phone' => null,
            'business_address' => null,

            'seo_title' => 'Codemida · Software a la medida en Tulancingo, Hidalgo',
            'seo_description' => 'Desarrollo de software a la medida: sistemas POS, apps móviles, tiendas en línea, sitios web y bases de datos. Más de 15 años de experiencia, desde Tulancingo, Hidalgo.',
            'seo_image' => null,
            'social_facebook' => null,
            'social_instagram' => null,
            'social_linkedin' => null,
            'social_x' => null,
        ];

        foreach ($defaults as $name => $value) {
            $this->migrator->add("site.{$name}", $value);
        }
    }
};
