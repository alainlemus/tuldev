<?php

namespace App\Models\Concerns;

use App\Support\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

/**
 * Genera una versión WebP de las imágenes que se suben desde Filament.
 * El modelo declara las columnas en `$webpColumns`.
 */
trait OptimizesImages
{
    protected static function bootOptimizesImages(): void
    {
        static::saved(function ($model) {
            foreach ($model->webpColumns ?? [] as $column) {
                if ($model->wasRecentlyCreated || $model->wasChanged($column)) {
                    ImageOptimizer::generate($model->{$column});
                }
            }
        });

        static::updated(function ($model) {
            foreach ($model->webpColumns ?? [] as $column) {
                $old = $model->getOriginal($column);

                if ($model->wasChanged($column) && $old) {
                    Storage::disk('public')->delete(ImageOptimizer::webpPath($old));
                }
            }
        });
    }
}
