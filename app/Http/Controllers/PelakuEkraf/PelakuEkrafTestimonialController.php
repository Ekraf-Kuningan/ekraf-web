<?php

namespace App\Http\Controllers\PelakuEkraf;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\TestimonialReceived;
use Illuminate\Support\Facades\Mail;

class PelakuEkrafTestimonialController extends Controller
{
    public function index()
    {
        $testimonial = Testimonial::where('user_id', Auth::id())->first();
        
        return view('pelaku-ekraf.testimonial.index', compact('testimonial'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:testimoni,saran,masukan',
            'business_name' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();

        // Cek apakah user sudah pernah submit testimoni
        $testimonial = Testimonial::where('user_id', $user->id)->first();

        if ($testimonial) {
            // Update existing
            $testimonial->update([
                'message' => $validated['message'],
                'rating' => $validated['rating'],
                'type' => $validated['type'],
                'business_name' => $validated['business_name'] ?? null,
                'status' => 'pending' // Reset ke pending untuk review ulang
            ]);
            
            $message = 'Testimoni Anda berhasil diperbarui dan menunggu persetujuan admin.';
        } else {
            // Create new
            $testimonial = Testimonial::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'business_name' => $validated['business_name'] ?? null,
                'message' => $validated['message'],
                'rating' => $validated['rating'],
                'type' => $validated['type'],
                'status' => 'pending'
            ]);
            
            $message = 'Testimoni Anda berhasil dikirim dan menunggu persetujuan admin.';
        }

        // Kirim email notifikasi ke user
        try {
            Mail::to($user->email)->send(new TestimonialReceived($testimonial));
        } catch (\Exception $e) {
            // Log error tapi tetap berhasil save
            
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy()
    {
        $testimonial = Testimonial::where('user_id', Auth::id())->first();
        
        if ($testimonial) {
            $testimonial->delete();
            return redirect()->back()->with('success', 'Testimoni berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Testimoni tidak ditemukan.');
    }
}
