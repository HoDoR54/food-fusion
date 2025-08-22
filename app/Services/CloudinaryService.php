<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    public function uploadImage(string|UploadedFile $file, string $folder): BaseResponse {
       try {
           // Handle both string paths and UploadedFile objects
           if ($file instanceof UploadedFile) {
               if (!$file || !$file->isValid()) {
                   return new BaseResponse(false, 'Invalid or missing file', 400, null);
               }
               $filePath = $file->getPathname();
           } else {
               // If it's a string, validate it's not empty
               if (empty($file)) {
                   return new BaseResponse(false, 'File path cannot be empty', 400, null);
               }
               $filePath = $file;
           }
           
           $result = Cloudinary::uploadApi()->upload($filePath, [
               'folder' => 'food-fusion/' . $folder,
               'resource_type' => 'auto',
               'transformation' => [
                            'width' => 800,
                            'height' => 600,
                            'crop' => 'limit',
                            'quality' => 'auto'
                        ]
           ]);
           
           // Extract the relevant data from Cloudinary response
           $responseData = [
               'secure_url' => $result['secure_url'],
               'public_id' => $result['public_id'],
               'width' => $result['width'],
               'height' => $result['height'],
               'format' => $result['format'],
               'resource_type' => $result['resource_type']
           ];
           
           return new BaseResponse(true, 'Image uploaded successfully', 200, (object) $responseData);
       } catch (\Exception $e) {
           Log::error('Cloudinary upload failed', [
               'error' => $e->getMessage(),
               'file' => $file instanceof UploadedFile ? $file->getClientOriginalName() : $file
           ]);
           return new BaseResponse(false, $e->getMessage(), 500, null);
       }
    }
}