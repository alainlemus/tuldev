<?php

namespace App\Support;

use App\Models\App;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Technology;
use App\Settings\SiteSettings;
use Illuminate\Support\Facades\Cache;

class LandingContent
{
    /**
     * Todo el contenido público de la landing, en caché hasta que se guarde algo desde Filament.
     *
     * @return array{s: object, services: \Illuminate\Support\Collection, projects: \Illuminate\Support\Collection, apps: \Illuminate\Support\Collection, techRows: array<int, \Illuminate\Support\Collection>}
     */
    public static function get(): array
    {
        return Cache::rememberForever(LandingCache::KEY, function () {
            $settings = app(SiteSettings::class);
            $technologies = Technology::visible()->get();

            return [
                's' => (object) [
                    ...$settings->toArray(),
                    'whatsapp_url' => $settings->whatsappUrl(),
                ],
                'services' => Service::visible()->get(),
                'projects' => Project::visible()->get(),
                'apps' => App::visible()->get(),
                'steps' => ProcessStep::visible()->get(),
                'faqs' => Faq::visible()->get(),
                'stats' => Stat::visible()->get(),
                'testimonials' => Testimonial::visible()->get(),
                'techRows' => [
                    1 => $technologies->where('row', 1)->values(),
                    2 => $technologies->where('row', 2)->values(),
                ],
            ];
        });
    }
}
