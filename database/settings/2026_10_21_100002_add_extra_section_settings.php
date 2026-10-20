<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $defaults = [
            'stats_title' => 'Software que ya trabaja en negocios reales',
            'process_title' => 'Así trabajamos, de la idea al sistema funcionando',
            'process_intro' => 'Un proceso claro y sin sorpresas: entendemos tu negocio antes de escribir una línea de código.',
            'testimonials_title' => 'Lo que dicen quienes ya trabajan con nosotros',
            'testimonials_intro' => 'Negocios de Hidalgo y de todo México que confían su operación a software hecho a su medida.',
            'faq_title' => 'Preguntas frecuentes',
            'faq_intro' => 'Lo que más nos preguntan antes de empezar un proyecto.',
            'cta_title' => '¿Hablamos de tu proyecto?',
            'cta_text' => 'Cuéntanos qué necesita tu negocio y te decimos cómo podemos ayudarte, sin compromiso.',
            'cta_primary_label' => 'Escríbenos por WhatsApp',
            'cta_secondary_label' => 'Dejar mis datos',
        ];

        foreach ($defaults as $name => $value) {
            $this->migrator->add("site.{$name}", $value);
        }
    }
};
