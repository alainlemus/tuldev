<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.contact_whatsapp_message', 'Hola, vi su sitio y me gustaría cotizar un proyecto.');
    }
};
