<?php

namespace App\Support;

use Illuminate\Support\Collection;

class StructuredData
{
    /** Grafo JSON-LD: sitio web + ProfessionalService. Omite los datos que aún no se capturan en Ajustes. */
    public static function graph(object $s, Collection $services, string $image, ?Collection $faqs = null): array
    {
        $site = url('/');

        $address = array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $s->business_address,
            'addressLocality' => 'Tulancingo de Bravo',
            'addressRegion' => 'Hidalgo',
            'addressCountry' => 'MX',
        ]);

        $business = array_filter([
            '@type' => 'ProfessionalService',
            '@id' => $site.'#organization',
            'name' => 'Codemida',
            'url' => $site,
            'description' => $s->seo_description,
            'logo' => url('icon-512.png'),
            'image' => $image,
            'telephone' => $s->business_phone,
            'email' => $s->contact_email,
            'address' => $address,
            'areaServed' => ['@type' => 'Country', 'name' => 'México'],
            'knowsAbout' => ['Desarrollo de software a la medida', 'Sistemas POS', 'Aplicaciones móviles', 'Tiendas en línea', 'Sitios web', 'Bases de datos'],
            'sameAs' => array_values(array_filter([
                $s->social_facebook, $s->social_instagram, $s->social_linkedin, $s->social_x,
            ])) ?: null,
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Servicios de desarrollo de software',
                'itemListElement' => $services->map(fn ($service) => [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $service->title,
                        'description' => $service->description,
                    ],
                ])->values()->all(),
            ],
        ]);

        $website = [
            '@type' => 'WebSite',
            '@id' => $site.'#website',
            'url' => $site,
            'name' => 'Codemida',
            'inLanguage' => 'es-MX',
            'publisher' => ['@id' => $site.'#organization'],
        ];

        $graph = [$business, $website];

        if ($faqs?->isNotEmpty()) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $site.'#faq',
                'mainEntity' => $faqs->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq->answer],
                ])->values()->all(),
            ];
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }
}
