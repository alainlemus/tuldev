<?php

namespace App\Http\Controllers;

use App\Support\LandingContent;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        return view('landing', LandingContent::get());
    }
}
