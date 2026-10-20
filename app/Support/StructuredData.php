<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class StructuredData
{
    /** JSON-LD tipo ProfessionalService; omite los datos que aún no se capturan en Ajustes. */
    public static function professionalService(object $s, Collection $services): array
    {
        $address = array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $s->business_address,
            'addressLocality' => 'Tulancingo de Bravo',
            'addressRegion' => 'Hidalgo',
            'addressCountry' => 'MX',
        ]);

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'Codemida',
            'url' => url('/'),
            'description' => $s->seo_description,
            'image' => $s->seo_image ? url(Storage::disk('public')->url($s->seo_image)) : null,
            'telephone' => $s->business_phone,
            'email' => $s->contact_email,
            'address' => $address,
            'areaServed' => ['@type' => 'Country', 'name' => 'México'],
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
    }
}
