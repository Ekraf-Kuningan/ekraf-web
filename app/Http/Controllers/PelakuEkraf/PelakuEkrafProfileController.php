<?php

namespace App\Http\Controllers\PelakuEkraf;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PelakuEkraf;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PelakuEkrafProfileController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $pelakuEkraf = PelakuEkraf::where('user_id', $user->id)->first();
        $testimonial = \App\Models\Testimonial::where('user_id', $user->id)->first();

        return view('pelaku-ekraf.profile.edit', compact('user', 'pelakuEkraf', 'testimonial'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validateWithBag('updateProfile', [
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'phone_number.required' => 'Nomor HP wajib diisi.',
            'profile_image.image' => 'File harus berupa gambar.',
            'profile_image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'profile_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            try {
                // Delete old image from Cloudinary if exists
                if ($user->cloudinary_id) {
                    $this->cloudinaryService->deleteFile($user->cloudinary_id);
                    Log::info('Old profile image deleted from Cloudinary', [
                        'cloudinary_id' => $user->cloudinary_id
                    ]);
                }

                // Upload new image
                $uploadResult = $this->cloudinaryService->uploadAvatar(
                    $request->file('profile_image'),
                    $user->username
                );

                if ($uploadResult) {
                    $validated['image'] = $uploadResult['secure_url'];
                    $validated['cloudinary_id'] = $uploadResult['public_id'];
                    $validated['cloudinary_meta'] = $uploadResult;

                    Log::info('New profile image uploaded to Cloudinary', [
                        'url' => $validated['image'],
                        'public_id' => $validated['cloudinary_id']
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to upload profile image: ' . $e->getMessage());
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Gagal mengupload foto profil. Silakan coba lagi.'], 'updateProfile')
                    ->withInput();
            }
        }

        // Update user data
        $user->update($validated);

        return redirect()->route('pelaku-ekraf.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'], 'updatePassword')
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('pelaku-ekraf.profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete profile image
     */
    public function deleteImage()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->cloudinary_id) {
            try {
                $this->cloudinaryService->deleteFile($user->cloudinary_id);
                Log::info('Profile image deleted from Cloudinary', [
                    'user_id' => $user->id,
                    'cloudinary_id' => $user->cloudinary_id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to delete profile image from Cloudinary', [
                    'user_id' => $user->id,
                    'cloudinary_id' => $user->cloudinary_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Update user attributes
        $user->image = null;
        $user->cloudinary_id = null;
        $user->cloudinary_meta = null;
        $user->save();

        return redirect()->route('pelaku-ekraf.profile.edit')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}
