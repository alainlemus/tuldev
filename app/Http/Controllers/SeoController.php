<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

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
            .'  <url><loc>'.e(url('/')).'</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>'."\n"
            .'</urlset>'."\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
