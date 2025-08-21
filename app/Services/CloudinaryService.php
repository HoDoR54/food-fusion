<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function uploadImage(string $filePath, string $folder): BaseResponse {
       try {
           return Cloudinary::uploadApi()->upload($filePath, [
               'folder' => 'food-fusion/' . $folder,
               'resource_type' => 'auto',
               'transformation' => [
                            'width' => 800,
                            'height' => 600,
                            'crop' => 'limit',
                            'quality' => 'auto'
                        ]
           ]);
       } catch (\Exception $e) {
           Log::error('Cloudinary upload failed', [
               'error' => $e->getMessage(),
               'file' => $filePath
           ]);
           return new BaseResponse(false, $e->getMessage(), 500, null);
       }
    }
}