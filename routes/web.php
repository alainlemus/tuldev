<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\SeoController;
use App\Models\LegalPage;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('home');

Route::get('/{slug}', LegalPageController::class)
    ->whereIn('slug', [LegalPage::PRIVACY, LegalPage::TERMS])
    ->name('legal');

Route::get('/robots.txt', [SeoController::class, 'robots']);
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
