<x-layouts.landing :s="$s" :services="$services" :faqs="$faqs">
    <x-landing.nav />
    <main>
        <x-landing.hero :s="$s" />
        <x-landing.phrase :s="$s" />
        <x-landing.stats :s="$s" :stats="$stats" />
        <x-landing.services :s="$s" :services="$services" />
        <x-landing.process :s="$s" :steps="$steps" />
        <x-landing.portfolio :s="$s" :projects="$projects" />
        <x-landing.testimonials :s="$s" :testimonials="$testimonials" />
        <x-landing.apps :s="$s" :apps="$apps" />
        <x-landing.stack :s="$s" :rows="$techRows" />
        <x-landing.faq :s="$s" :faqs="$faqs" />
        <x-landing.cta :s="$s" />
        <x-landing.contact :s="$s" />
    </main>
    <x-landing.footer :s="$s" />
    <x-landing.whatsapp-float :s="$s" />
</x-layouts.landing>
