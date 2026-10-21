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
            'name' => 'Tuldev',
            'url' => $site,
            'description' => $s->seo_description,
            'logo' => url('android-chrome-512x512.png'),
            'image' => $image,
            'telephone' => $s->business_phone,
            'email' => $s->contact_email,
            'address' => $address,
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Tulancingo de Bravo'],
                ['@type' => 'City', 'name' => 'Pachuca de Soto'],
                ['@type' => 'State', 'name' => 'Hidalgo'],
                ['@type' => 'State', 'name' => 'Querétaro'],
                ['@type' => 'AdministrativeArea', 'name' => 'Ciudad de México'],
                ['@type' => 'Country', 'name' => 'México'],
            ],
            'knowsAbout' => ['Desarrollo de software a la medida', 'Sistemas POS', 'Aplicaciones móviles', 'Páginas web', 'Tiendas en línea', 'Facturación electrónica CFDI', 'Pagos en línea', 'Bases de datos'],
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
            'name' => 'Tuldev',
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
