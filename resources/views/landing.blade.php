<x-layouts.landing :s="$s" :services="$services">
    <x-landing.nav />
    <main>
        <x-landing.hero :s="$s" />
        <x-landing.phrase :s="$s" />
        <x-landing.services :s="$s" :services="$services" />
        <x-landing.portfolio :s="$s" :projects="$projects" />
        <x-landing.apps :s="$s" :apps="$apps" />
        <x-landing.stack :s="$s" :rows="$techRows" />
        <x-landing.contact :s="$s" />
    </main>
    <x-landing.footer :s="$s" />
</x-layouts.landing>
