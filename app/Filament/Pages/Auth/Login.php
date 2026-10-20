<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $layout = 'filament.layouts.split';

    public function getHeading(): string|Htmlable
    {
        return 'Iniciar sesión';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Entra para administrar el contenido de tu sitio.';
    }
}
