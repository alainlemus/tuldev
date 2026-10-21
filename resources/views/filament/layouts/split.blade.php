@php
    $livewire ??= null;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    <style>
        .cm-login{display:grid;grid-template-columns:1fr;min-height:100vh;min-height:100dvh}
        .cm-login-brand{display:none}
        .cm-login-form{display:flex;align-items:center;justify-content:center;padding:32px 24px}
        .cm-login-form .fi-simple-main{width:100%;max-width:26rem}
        @media (min-width:1024px){
            .cm-login{grid-template-columns:1.05fr 1fr}
            .cm-login-brand{display:flex}
        }
        @media (min-width:1024px){
            .cm-login-form .fi-simple-main{background:transparent!important;box-shadow:none!important;--tw-ring-shadow:0 0 #0000!important;border:0!important;padding:0!important}
            .cm-login-form .fi-logo{display:none}
        }
        .cm-login-brand{position:relative;overflow:hidden;flex-direction:column;justify-content:space-between;padding:56px;background:#08090B;color:#F1F4F6;font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif}
        .cm-login-brand::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(31,191,169,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(31,191,169,.07) 1px,transparent 1px);background-size:56px 56px;-webkit-mask-image:radial-gradient(ellipse 90% 80% at 70% 35%,#000 20%,transparent 75%);mask-image:radial-gradient(ellipse 90% 80% at 70% 35%,#000 20%,transparent 75%)}
        .cm-login-brand::after{content:"";position:absolute;width:640px;height:640px;right:-180px;top:-200px;border-radius:50%;background:radial-gradient(closest-side,rgba(31,191,169,.35),transparent)}
        .cm-login-brand>*{position:relative;z-index:1}
        .cm-login-brand h2{margin:0;font-size:clamp(34px,3.4vw,52px);font-weight:800;letter-spacing:-.04em;line-height:1.05}
        .cm-login-brand p{margin:16px 0 0;max-width:420px;font-size:17px;line-height:1.6;color:#B7C0C9}
        .cm-login-term{max-width:420px;border-radius:16px;border:1px solid #232B33;background:#0E1215;padding:22px;font-family:'JetBrains Mono',ui-monospace,monospace;font-size:14px;line-height:1.9;color:#B7C0C9}
        .cm-login-term b{font-weight:500;color:#1FBFA9}.cm-login-term u{text-decoration:none;color:#F1F4F6}.cm-login-term i{font-style:normal;color:#5FE0CC}
    </style>

    <div class="cm-login">
        <aside class="cm-login-brand" aria-hidden="true">
            <img src="{{ asset('brand/svg/nombre-solo-para-fondo-oscuro.svg') }}" alt="" height="36" style="height:36px;width:auto;align-self:flex-start">

            <div>
                <h2>Tu sitio, bajo tu control.</h2>
                <p>Administra servicios, portafolio, apps, preguntas frecuentes y los leads que llegan desde la landing.</p>
            </div>

            <div class="cm-login-term">
                <u>$ tuldev panel</u><br>
                <b>✓</b> contenido sincronizado<br>
                <b>✓</b> leads al día<br>
                <i>→ listo para vender</i>
            </div>
        </aside>

        <div class="cm-login-form">
            <main id="fi-main-content" tabindex="-1" class="fi-simple-main">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-filament-panels::layout.base>
