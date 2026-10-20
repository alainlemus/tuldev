<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\LegalPage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $body = "User-agent: *\nDisallow: /admin\nDisallow: /livewire\n\nSitemap: ".url('/sitemap.xml')."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
            .'  <url><loc>'.e(url('/')).'</loc><lastmod>'.$this->lastModified()->toAtomString().'</lastmod><changefreq>monthly</changefreq><priority>1.0</priority></url>'."\n"
            .$this->legalUrls()
            .'</urlset>'."\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /** Fecha del último cambio de contenido público, para el <lastmod> del sitemap. */
    private function lastModified(): Carbon
    {
        $dates = collect([Service::class, Project::class, App::class, Technology::class])
            ->map(fn (string $model) => $model::max('updated_at'))
            ->filter()
            ->map(fn ($date) => Carbon::parse($date));

        return $dates->max() ?? now();
    }

    private function legalUrls(): string
    {
        return LegalPage::visible()->get()->map(fn (LegalPage $page) => '  <url><loc>'.e(route('legal', $page->slug)).'</loc><lastmod>'
            .$page->updated_at->toAtomString().'</lastmod><changefreq>yearly</changefreq><priority>0.3</priority></url>'."\n")->implode('');
    }
}
