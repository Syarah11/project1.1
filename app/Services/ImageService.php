<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    /**
     * Upload dan optimasi gambar
     */
    public static function upload(
        UploadedFile $file,
        string $path,
        int $maxKB = 300
    ): ?string {
        try {
            $manager = new ImageManager(new Driver());

            // Generate nama file
            $filename = $path . '/' . Str::uuid() . '.webp';

            // Baca gambar
            $image = $manager->read($file);

            // Resize max width 1200px (aman untuk thumbnail & banner)
            $image->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Encode awal
            $quality = 90;
            $encoded = $image->toWebp($quality);

            // Kompresi sampai < maxKB
            while (strlen($encoded) / 1024 > $maxKB && $quality > 40) {
                $quality -= 10;
                $encoded = $image->toWebp($quality);
            }

            // Simpan
            Storage::disk('public')->put($filename, $encoded);

            return $filename;

        } catch (\Throwable $e) {
            \Log::error('Image upload failed', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Hapus gambar
     */
    public static function delete(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
