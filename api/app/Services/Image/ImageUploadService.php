<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    public function upload(
        UploadedFile $file,
        string $folder,
        ?string $filename = null
    ): string
    {
        if ($filename) {
            $extension = $file->getClientOriginalExtension();
            return $file->storeAs($folder, "{$filename}.{$extension}", 'public');
        }
        return $file->store($folder, 'public');
    }
}