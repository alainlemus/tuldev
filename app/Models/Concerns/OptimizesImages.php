<?php

namespace App\Models\Concerns;

use App\Support\ImageOptimizer;
use App\Support\LandingCache;

/**
 * Convierte a WebP las imágenes que se suben desde Filament y guarda la ruta nueva.
 * El modelo declara las columnas en `$webpColumns`.
 */
trait OptimizesImages
{
    protected static function bootOptimizesImages(): void
    {
        static::saved(function ($model) {
            $changed = [];

            foreach ($model->webpColumns ?? [] as $column) {
                $path = $model->{$column};

                if (ImageOptimizer::isConvertible($path)) {
                    $changed[$column] = ImageOptimizer::convert($path);
                }
            }

            if ($changed && array_diff($changed, $model->only(array_keys($changed)))) {
                $model->forceFill($changed)->saveQuietly();
                LandingCache::forget();
            }
        });
    }
}
