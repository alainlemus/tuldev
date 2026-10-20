<?php

namespace App\Models;

use App\Enums\AppStatus;
use App\Models\Concerns\ClearsLandingCache;
use App\Models\Concerns\OptimizesImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class App extends Model
{
    use ClearsLandingCache, HasFactory, OptimizesImages;

    /** @var list<string> */
    protected array $webpColumns = ['image'];

    protected $table = 'apps';

    protected $fillable = [
        'name', 'description', 'image', 'image_alt', 'status', 'app_store_url',
        'google_play_url', 'sort', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'status' => AppStatus::class,
            'is_published' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
