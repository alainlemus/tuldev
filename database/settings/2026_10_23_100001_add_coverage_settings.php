<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.coverage_title', 'Clientes en Hidalgo, Querétaro y Ciudad de México');
        $this->migrator->add('site.coverage_places', "Todo Hidalgo\nQuerétaro\nCiudad de México");
        $this->migrator->update('site.contact_area', fn () => 'Tulancingo, Hidalgo · clientes en Hidalgo, Querétaro y CDMX');
    }
};
