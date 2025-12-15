<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestimonialReceived;
use Illuminate\Support\Facades\Log;


class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:testimoni,saran,masukan'
        ]);

        // Simpan ke database
        $testimonial = Testimonial::create($validated);

        // Kirim email ke user sebagai konfirmasi
        try {
            Mail::to($validated['email'])->send(new TestimonialReceived($testimonial));
        } catch (\Exception $e) {
            // Log error tapi tetap lanjut
            Log::error('Failed to send testimonial email: ' . $e->getMessage());}

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! ' . ucfirst($validated['type']) . ' Anda telah kami terima dan konfirmasi telah dikirim ke email Anda.'
        ]);
    }

    public function index()
    {
        $testimonials = Testimonial::approved()
            ->byType('testimoni')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.testimonials', compact('testimonials'));
    }
}
