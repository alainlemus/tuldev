<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use App\Support\LandingContent;
use Illuminate\Contracts\View\View;

class LegalPageController extends Controller
{
    public function __invoke(string $slug): View
    {
        $page = LegalPage::visible()->where('slug', $slug)->firstOrFail();

        return view('legal', [...LandingContent::get(), 'page' => $page]);
    }
}
