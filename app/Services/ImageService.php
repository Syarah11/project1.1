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

            // Resize max width 1200px
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

            // Simpan ke storage
            Storage::disk('public')->put($filename, $encoded);

            return $filename;

        } catch (\Throwable $e) {
            \Log::error('Image upload failed', [
                'error' => $e->getMessage(),
                'file'  => $file->getClientOriginalName()
            ]);

            throw new \Exception('Failed to upload image: ' . $e->getMessage());
        }
    }

    /**
     * Hapus gambar dari storage
     */
    public static function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
