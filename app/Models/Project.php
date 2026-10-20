<?php

namespace App\Models;

use App\Models\Concerns\ClearsLandingCache;
use App\Models\Concerns\OptimizesImages;
use App\Support\ImageOptimizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use ClearsLandingCache, HasFactory, OptimizesImages;

    /** @var list<string> */
    protected array $webpColumns = ['scroll_image'];

    protected $fillable = [
        'name', 'slug', 'description', 'tags', 'badge', 'scroll_image', 'scroll_alt',
        'scroll_duration', 'scroll_delay', 'url', 'sort', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderBy('id');
    }

    public function scrollImageUrl(): ?string
    {
        return $this->scroll_image ? Storage::disk('public')->url($this->scroll_image) : null;
    }

    public function altText(): string
    {
        return $this->scroll_alt ?: "Recorrido por el sitio de {$this->name}";
    }

    public function isOwnProduct(): bool
    {
        return $this->badge === 'Producto propio';
    }

    public function webpUrl(): ?string
    {
        return ImageOptimizer::webpUrl($this->scroll_image);
    }
}
