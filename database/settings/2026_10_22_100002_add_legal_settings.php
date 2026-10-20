<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.legal_name', null);
        $this->migrator->add('site.privacy_email', null);
    }
};
