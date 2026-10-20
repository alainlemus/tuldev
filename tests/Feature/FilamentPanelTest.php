<?php

use App\Filament\Resources\Apps\AppResource;
use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\Technologies\TechnologyResource;
use App\Filament\Resources\Faqs\FaqResource;
use App\Filament\Resources\ProcessSteps\ProcessStepResource;
use App\Filament\Resources\Stats\StatResource;
use App\Filament\Resources\Testimonials\TestimonialResource;
use App\Models\App;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use App\Models\User;

/** Texto visible de una página: contenido más atributos de accesibilidad. */
function visibleText(string $html): string
{
    preg_match_all('/(?:placeholder|aria-label|title|alt)="([^"]*)"/', $html, $attributes);
    $text = strip_tags(preg_replace('#<(script|style)\b.*?</\1>#is', ' ', $html));

    return $text.' '.implode(' ', $attributes[1]);
}

it('redirige al login a quien no ha iniciado sesión', function (string $path) {
    $this->get($path)->assertRedirect('/admin/login');
})->with(['/admin', '/admin/leads', '/admin/services', '/admin/projects', '/admin/apps', '/admin/technologies', '/admin/process-steps', '/admin/faqs', '/admin/stats', '/admin/testimonials', '/admin/manage-site-settings']);

it('carga las páginas del panel para un administrador', function () {
    $this->actingAs(User::factory()->create());

    $lead = Lead::factory()->create();
    $service = Service::factory()->create();
    $project = Project::factory()->create();
    $app = App::factory()->create();
    $technology = Technology::factory()->create();
    $step = ProcessStep::factory()->create();
    $faq = Faq::factory()->create();
    $stat = Stat::factory()->create();
    $testimonial = Testimonial::factory()->create();

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
        ProcessStepResource::getUrl('index'),
        ProcessStepResource::getUrl('create'),
        ProcessStepResource::getUrl('edit', ['record' => $step]),
        FaqResource::getUrl('index'),
        FaqResource::getUrl('create'),
        FaqResource::getUrl('edit', ['record' => $faq]),
        StatResource::getUrl('index'),
        StatResource::getUrl('create'),
        StatResource::getUrl('edit', ['record' => $stat]),
        TestimonialResource::getUrl('index'),
        TestimonialResource::getUrl('create'),
        TestimonialResource::getUrl('edit', ['record' => $testimonial]),
    ];

    foreach ($urls as $url) {
        $html = $this->get($url)->assertSuccessful()->getContent();

        // Si aparece una clave cruda (p. ej. filament-panels::...) es que falta una traducción al español.
        expect(visibleText($html))->not->toMatch('/filament-[a-z]+::[a-z0-9_.-]+/', $url);
    }
});

it('no permite crear leads desde el panel', function () {
    expect(LeadResource::canCreate())->toBeFalse();
});
