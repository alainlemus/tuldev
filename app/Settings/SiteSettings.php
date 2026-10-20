<?php

namespace App\Settings;

use App\Enums\HeroBackground;
use App\Support\LandingCache;
use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $hero_eyebrow;
    public string $hero_title;
    public string $hero_subtitle;
    public string $hero_primary_label;
    public string $hero_secondary_label;
    public HeroBackground $hero_background;

    public string $phrase;
    public string $phrase_accent;

    public string $services_title;
    public string $services_intro;
    public string $portfolio_title;
    public string $portfolio_intro;
    public string $apps_title;
    public string $stack_title;
    public string $stack_intro;
    public string $contact_title;
    public string $contact_intro;
    public string $footer_text;

    public string $stats_title;
    public string $process_title;
    public string $process_intro;
    public string $testimonials_title;
    public string $testimonials_intro;
    public string $faq_title;
    public string $faq_intro;
    public string $cta_title;
    public string $cta_text;
    public string $cta_primary_label;
    public string $cta_secondary_label;

    public ?string $contact_whatsapp;
    public string $contact_whatsapp_message;
    public ?string $contact_email;
    public string $contact_area;
    public ?string $lead_notification_email;
    public ?string $business_phone;
    public ?string $business_address;

    public string $seo_title;
    public string $seo_description;
    public ?string $seo_image;
    public ?string $social_facebook;
    public ?string $social_instagram;
    public ?string $social_linkedin;
    public ?string $social_x;

    public static function group(): string
    {
        return 'site';
    }

    public function whatsappUrl(?string $text = null): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->contact_whatsapp);

        if ($digits === '') {
            return null;
        }

        $digits = strlen($digits) === 10 ? "52{$digits}" : $digits;

        return "https://wa.me/{$digits}".($text ? '?text='.rawurlencode($text) : '');
    }

    public function save(): static
    {
        parent::save();
        LandingCache::forget();

        return $this;
    }
}
