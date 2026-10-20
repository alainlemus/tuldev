<?php

namespace App\Models;

use App\Models\Concerns\ClearsLandingCache;
use App\Models\Concerns\OptimizesImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use ClearsLandingCache, HasFactory, OptimizesImages;

    protected $table = 'testimonials';

    protected $fillable = ['author', 'role', 'quote', 'photo', 'sort', 'is_published'];

    /** @var list<string> */
    protected array $webpColumns = ['photo'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderBy('id');
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo) : null;
    }
}
