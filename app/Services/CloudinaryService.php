<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CloudinaryService
{
    public function uploadImage(string|UploadedFile $file, string $folder): BaseResponse {
       try {
           if ($file instanceof UploadedFile) {
               if (!$file || !$file->isValid()) {
                   return new BaseResponse(false, 'Invalid or missing file', 400, null);
               }
               $filePath = $file->getPathname();
               $fileName = $file->getClientOriginalName();
           } else {
               if (empty($file)) {
                   return new BaseResponse(false, 'File path cannot be empty', 400, null);
               }
               $filePath = $file;
               $fileName = basename($file);
           }
           
           $maxRetries = 3;
           $retryDelay = 1;
           $lastException = null;
           
           for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
               try {
                   Log::info("Cloudinary upload attempt {$attempt}/{$maxRetries}", [
                       'file' => $fileName,
                       'folder' => $folder
                   ]);
                   
                   $result = Cloudinary::uploadApi()->upload($filePath, [
                       'folder' => 'food-fusion/' . $folder,
                       'resource_type' => 'auto',
                       'timeout' => 60,
                       'transformation' => [
                           'width' => 800,
                           'height' => 600,
                           'crop' => 'limit',
                           'quality' => 'auto'
                       ]
                   ]);
                   
                   Log::info("Cloudinary upload successful on attempt {$attempt}", [
                       'file' => $fileName,
                       'public_id' => $result['public_id']
                   ]);
                   
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
                   $lastException = $e;
                   $errorMessage = $e->getMessage();
                   
                   Log::warning("Cloudinary upload attempt {$attempt} failed", [
                       'file' => $fileName,
                       'error' => $errorMessage,
                       'attempt' => $attempt,
                       'max_retries' => $maxRetries
                   ]);
                   
                   if ($this->shouldRetryUpload($errorMessage) && $attempt < $maxRetries) {
                       Log::info("Retrying upload in {$retryDelay} seconds...", [
                           'file' => $fileName,
                           'next_attempt' => $attempt + 1
                       ]);
                       sleep($retryDelay);
                       $retryDelay *= 2;
                       continue;
                   }
                   
                   break;
               }
           }
           
           $finalErrorMessage = $this->getFriendlyErrorMessage($lastException->getMessage());
           
           Log::error('Cloudinary upload failed after all retries', [
               'error' => $lastException->getMessage(),
               'file' => $fileName,
               'attempts' => $maxRetries
           ]);
           
           if (env('CLOUDINARY_FALLBACK_LOCAL', false)) {
               Log::info('Attempting fallback to local storage', ['file' => $fileName]);
               return $this->uploadToLocalStorage($file, $folder, $fileName);
           }
           
           return new BaseResponse(false, $finalErrorMessage, 500, null);
           
       } catch (\Exception $e) {
           Log::error('Unexpected error during Cloudinary upload', [
               'error' => $e->getMessage(),
               'file' => $file instanceof UploadedFile ? $file->getClientOriginalName() : $file
           ]);
           return new BaseResponse(false, 'An unexpected error occurred during upload. Please try again.', 500, null);
       }
    }
    
    private function shouldRetryUpload(string $errorMessage): bool
    {
        $retryableErrors = [
            'cURL error 35',
            'cURL error 7',
            'cURL error 28',
            'cURL error 56',
            'Connection timed out',
            'Connection reset',
            'Network is unreachable',
            'Temporary failure'
        ];
        
        foreach ($retryableErrors as $retryableError) {
            if (stripos($errorMessage, $retryableError) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function getFriendlyErrorMessage(string $errorMessage): string
    {
        if (stripos($errorMessage, 'cURL error 35') !== false ||
            stripos($errorMessage, 'Connection reset') !== false) {
            return 'Upload failed due to network connectivity issues. Please check your internet connection and try again.';
        }
        
        if (stripos($errorMessage, 'cURL error 28') !== false ||
            stripos($errorMessage, 'timeout') !== false) {
            return 'Upload timed out. The file might be too large or your connection is slow. Please try again.';
        }
        
        if (stripos($errorMessage, 'cURL error 7') !== false) {
            return 'Unable to connect to upload service. Please check your internet connection.';
        }
        
        if (stripos($errorMessage, 'cURL error') !== false) {
            return 'Network error occurred during upload. Please try again in a moment.';
        }
        
        return 'Upload failed. Please try again or contact support if the problem persists.';
    }
    
    private function uploadToLocalStorage(string|UploadedFile $file, string $folder, string $fileName): BaseResponse
    {
        try {
            if ($file instanceof UploadedFile) {
                $extension = $file->getClientOriginalExtension();
                $uniqueName = time() . '_' . uniqid() . '.' . $extension;
                $path = $file->storeAs("public/{$folder}", $uniqueName);
                
                if (!$path) {
                    throw new \Exception('Failed to store file locally');
                }
                
                $responseData = [
                    'secure_url' => Storage::url($path),
                    'public_id' => "local/{$folder}/" . pathinfo($uniqueName, PATHINFO_FILENAME),
                    'width' => null,
                    'height' => null,
                    'format' => $extension,
                    'resource_type' => 'image'
                ];
                
                Log::info('File uploaded to local storage as fallback', [
                    'original_file' => $fileName,
                    'stored_path' => $path,
                    'url' => $responseData['secure_url']
                ]);
                
                return new BaseResponse(true, 'Image uploaded successfully (local storage)', 200, (object) $responseData);
            }
            
            throw new \Exception('Local storage fallback only supports UploadedFile objects');
            
        } catch (\Exception $e) {
            Log::error('Local storage fallback failed', [
                'error' => $e->getMessage(),
                'file' => $fileName
            ]);
            return new BaseResponse(false, 'Upload failed completely. Please try again later.', 500, null);
        }
    }
}