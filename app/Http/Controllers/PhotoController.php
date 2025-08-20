<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create()
    {
        return view('photo-upload');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Photo upload request received', [
                'file' => $request->hasFile('photo') ? $request->file('photo')->getClientOriginalName() : 'No file'
            ]);

            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);
            Log::info('Photo upload validation passed');

            $uploadedFile = $request->file('photo');
            if (!$uploadedFile) {
                Log::error('No file uploaded');
                return back()->withErrors(['photo' => 'No file uploaded']);
            }

            Log::info('File uploaded', [
                'file' => $uploadedFile->getClientOriginalName()
            ]);

            Log::info('Path Name', [
                'file' => $uploadedFile->getPathname()
            ]);

            // ✅ Use Cloudinary uploadApi method
            try {
                $result = Cloudinary::uploadApi()->upload(
                    $uploadedFile->getPathname(),
                    [
                        'folder' => 'food-fusion-uploads',
                        'resource_type' => 'auto',
                        'transformation' => [
                            'width' => 800,
                            'height' => 600,
                            'crop' => 'limit',
                            'quality' => 'auto'
                        ]
                    ]
                );

                Log::info('Cloudinary upload successful', [
                    'result' => $result
                ]);

                $imageUrl = $result['secure_url'] ?? $result['url'] ?? null;
                $publicId = $result['public_id'] ?? null;

                if (!$imageUrl || !$publicId) {
                    throw new \Exception('Missing image URL or public ID in Cloudinary response');
                }

            } catch (\Exception $cloudinaryException) {
                Log::error('Cloudinary upload exception', [
                    'error' => $cloudinaryException->getMessage(),
                    'trace' => $cloudinaryException->getTraceAsString()
                ]);
                throw $cloudinaryException;
            }

            Log::info('Photo uploaded successfully', [
                'public_id' => $publicId,
                'url' => $imageUrl,
                'original_name' => $uploadedFile->getClientOriginalName()
            ]);

            return back()->with([
                'success' => 'Photo uploaded successfully!',
                'image_url' => $imageUrl,
                'public_id' => $publicId,
                'original_name' => $uploadedFile->getClientOriginalName()
            ]);

        } catch (\Exception $e) {
            Log::error('Photo upload failed', [
                'error' => $e->getMessage(),
                'file' => $request->hasFile('photo') ? $request->file('photo')->getClientOriginalName() : 'No file'
            ]);

            return back()->withErrors(['photo' => 'Failed to upload photo: ' . $e->getMessage()]);
        }
    }

    public function destroy($publicId)
    {
        try {
            if ($publicId) {
                $result = Cloudinary::uploadApi()->destroy($publicId);

                return response()->json([
                    'success' => true,
                    'message' => 'Photo deleted successfully',
                    'result' => $result
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Public ID is required'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Photo deletion failed', [
                'error' => $e->getMessage(),
                'public_id' => $publicId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete photo: ' . $e->getMessage()
            ], 500);
        }
    }
}
