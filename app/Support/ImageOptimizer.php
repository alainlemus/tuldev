<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageOptimizer
{
    private const QUALITY = 82;

    private const MAX_WIDTH = 1600;

    public static function isConvertible(?string $path): bool
    {
        return $path !== null && preg_match('/\.(jpe?g|png)$/i', $path) === 1;
    }

    /**
     * Convierte una imagen JPG/PNG del disco público a WebP, borra el original
     * y devuelve la nueva ruta. Si no puede convertirla, devuelve la ruta original.
     */
    public static function convert(?string $path): ?string
    {
        if (! self::isConvertible($path) || ! function_exists('imagewebp')) {
            return $path;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return $path;
        }

        $image = @imagecreatefromstring($disk->get($path));

        if (! $image) {
            return $path;
        }

        if (imagesx($image) > self::MAX_WIDTH) {
            $image = imagescale($image, self::MAX_WIDTH, -1, IMG_BICUBIC);
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, self::QUALITY);
        $webp = ob_get_clean();

        $new = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);

        $disk->put($new, $webp);
        $disk->delete($path);

        return $new;
    }
}
