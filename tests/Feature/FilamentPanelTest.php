<?php

use App\Filament\Resources\Apps\AppResource;
use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\Technologies\TechnologyResource;
use App\Models\App;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use App\Models\User;

it('redirige al login a quien no ha iniciado sesión', function (string $path) {
    $this->get($path)->assertRedirect('/admin/login');
})->with(['/admin', '/admin/leads', '/admin/services', '/admin/projects', '/admin/apps', '/admin/technologies', '/admin/manage-site-settings']);

it('carga las páginas del panel para un administrador', function () {
    $this->actingAs(User::factory()->create());

    $lead = Lead::factory()->create();
    $service = Service::factory()->create();
    $project = Project::factory()->create();
    $app = App::factory()->create();
    $technology = Technology::factory()->create();

    $urls = [
        '/admin',
        '/admin/manage-site-settings',
        LeadResource::getUrl('index'),
        LeadResource::getUrl('view', ['record' => $lead]),
        LeadResource::getUrl('edit', ['record' => $lead]),
        ServiceResource::getUrl('index'),
        ServiceResource::getUrl('create'),
        ServiceResource::getUrl('edit', ['record' => $service]),
        ProjectResource::getUrl('index'),
        ProjectResource::getUrl('create'),
        ProjectResource::getUrl('edit', ['record' => $project]),
        AppResource::getUrl('index'),
        AppResource::getUrl('create'),
        AppResource::getUrl('edit', ['record' => $app]),
        TechnologyResource::getUrl('index'),
        TechnologyResource::getUrl('create'),
        TechnologyResource::getUrl('edit', ['record' => $technology]),
    ];

    foreach ($urls as $url) {
        $this->get($url)->assertSuccessful();
    }
});

it('no permite crear leads desde el panel', function () {
    expect(LeadResource::canCreate())->toBeFalse();
});
