<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactSubmitRequest;
use App\Models\ContactFormSubmission;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    public function submitContactForm(ContactSubmitRequest $request)
    {
        Log::info('Request: '.json_encode($request->all()));

        try {
            $validated = $request->validated();
            $isAnonymous = $validated['is_anonymous'] ?? false;

            if ($isAnonymous) {
                $validated['user_id'] = null;
            } else {
                $validated['user_id'] = auth()->id();
            }
            Log::info('Contact form submission: '.json_encode($validated));

            $createdRow = ContactFormSubmission::create($validated);

            return response()->json([
                'message' => 'Contact form submitted successfully.',
                'data' => $createdRow,
                'success' => true,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error submitting contact form: '.$e->getMessage());

            return response()->json(['error' => 'Failed to submit contact form.'], 500);
        }
    }
}
