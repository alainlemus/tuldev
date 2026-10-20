<x-layouts.landing :s="$s">
    <x-landing.nav />
    <x-landing.hero :s="$s" />
    <x-landing.phrase :s="$s" />
    <x-landing.services :s="$s" :services="$services" />
    <x-landing.portfolio :s="$s" :projects="$projects" />
    <x-landing.apps :s="$s" :apps="$apps" />
    <x-landing.stack :s="$s" :rows="$techRows" />
    <x-landing.contact :s="$s" />
    <x-landing.footer :s="$s" />
</x-layouts.landing>
