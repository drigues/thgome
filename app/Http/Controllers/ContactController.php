<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        // Honeypot
        if ($request->filled('website')) {
            return response()->json(['success' => true]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        try {
            Mail::to(Setting::get('contact_email', 'hello@thgo.me'))
                ->send(new ContactMessageReceived($validated));
        } catch (\Exception $e) {
            logger()->error('Mail failed: '.$e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
    }
}
