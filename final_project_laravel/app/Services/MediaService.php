<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Upload and optimize a passport photo.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function uploadPhoto(UploadedFile $file, string $folder = 'passports/photos'): string
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        
        // In a real application, you might use Intervention Image here for optimization.
        // For now, we use the standard Storage facade.
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }

    /**
     * Get a secure/public URL for a photo.
     */
    public function getPhotoUrl(?string $path): ?string
    {
        if (!$path) return null;
        
        return Storage::disk('public')->url($path);
    }

    /**
     * Delete a photo.
     */
    public function deletePhoto(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
