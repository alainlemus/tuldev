<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageOptimizer
{
    private const QUALITY = 80;

    /** Genera `<ruta>.webp` junto a la imagen original del disco público (JPG o PNG). */
    public static function generate(?string $path): void
    {
        if (! $path || ! function_exists('imagewebp')) {
            return;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return;
        }

        $image = match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'jpg', 'jpeg' => @imagecreatefromstring($disk->get($path)),
            'png' => @imagecreatefromstring($disk->get($path)),
            default => false,
        };

        if (! $image) {
            return;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, self::QUALITY);
        $webp = ob_get_clean();

        $disk->put(self::webpPath($path), $webp);
    }

    public static function webpPath(string $path): string
    {
        return $path.'.webp';
    }

    /** URL pública de la variante WebP si existe. */
    public static function webpUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $webp = self::webpPath($path);

        return Storage::disk('public')->exists($webp) ? Storage::disk('public')->url($webp) : null;
    }
}
