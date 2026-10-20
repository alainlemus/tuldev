<?php

namespace App\Models;

use App\Enums\ServiceIcon;
use App\Models\Concerns\ClearsLandingCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use ClearsLandingCache, HasFactory;

    protected $fillable = ['title', 'description', 'tag', 'icon', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'icon' => ServiceIcon::class,
            'is_active' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort')->orderBy('id');
    }
}
