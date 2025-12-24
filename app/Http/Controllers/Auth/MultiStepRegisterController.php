<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Level;
use App\Models\SubSektor;
use App\Models\PelakuEkraf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\TemporaryUser;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailVerification;
use App\Services\CloudinaryService;

class MultiStepRegisterController extends Controller
{
    /**
     * STEP 1: Show basic registration form (username, email, password)
     */
    public function showStep1()
    {
        return view('auth.register-step1');
    }

    /**
     * STEP 1: Handle basic registration (username, email, password)
     */
    public function storeStep1(Request $request)
    {
        Log::info('=== STEP 1: BASIC REGISTRATION STARTED ===');
        
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users', 'unique:temporary_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:temporary_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.same'=>'Konfirmasi password harus sama dengan passaword '
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $verificationToken = Str::random(65);
        
        $temporaryUser = TemporaryUser::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level_id' => 3, // Mitra role
            'verificationToken' => $verificationToken,
            'verificationTokenExpiry' => Carbon::now()->addMinutes(10),
            'is_verified' => false,
            'profile_completed' => false,
            'createdAt' => Carbon::now(),
        ]);

        Log::info('Step 1 completed - Temporary user created:', ['id' => $temporaryUser->id]);

        // Generate verification URL
        $verificationUrl = route('verify.email', ['token' => $verificationToken]);

        // Send verification email
        try {
            Notification::route('mail', $temporaryUser->email)
                ->notify(new VerifyEmailVerification($verificationUrl, $temporaryUser->username));
            
            Log::info('Verification email sent to: ' . $temporaryUser->email);
            
            return view('auth.register-step2', ['email' => $temporaryUser->email]);
        } catch (\Exception $e) {
            $temporaryUser->delete();
            Log::error('Failed to send verification email: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['email' => 'Gagal mengirim email verifikasi. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * STEP 2: Verify email (handled by verifyEmail method)
     */
    public function verifyEmail($token)
    {
        $temporaryUser = TemporaryUser::where('verificationToken', $token)
            ->where('verificationTokenExpiry', '>', Carbon::now())
            ->where('is_verified', false)
            ->first();

        if (!$temporaryUser) {
            return redirect()->route('register-pelakuekraf')
                ->withErrors(['error' => 'Token verifikasi tidak valid atau telah kedaluwarsa.']);
        }

        // Mark as verified
        $temporaryUser->update([
            'is_verified' => true,
            'verificationTokenExpiry' => Carbon::now()->addHours(24), // Extend token for profile completion
        ]);

        Log::info('Email verified for user:', ['email' => $temporaryUser->email]);

        // Redirect to Step 3 - Complete Profile
        return redirect()->route('register.step3', ['token' => $token]);
    }

    /**
     * STEP 3: Show complete profile form
     */
    public function showStep3($token)
    {
        $temporaryUser = TemporaryUser::where('verificationToken', $token)
            ->where('is_verified', true)
            ->where('profile_completed', false)
            ->first();

        if (!$temporaryUser) {
            return redirect()->route('register-pelakuekraf')
                ->withErrors(['error' => 'Token tidak valid atau profil sudah dilengkapi.']);
        }

        $levels = Level::all();
        $subSektors = SubSektor::all();
        
        return view('auth.register-step3', compact('temporaryUser', 'levels', 'subSektors', 'token'));
    }

    /**
     * STEP 3: Handle complete profile
     */
    public function storeStep3(Request $request, $token)
    {
        Log::info('=== STEP 3: COMPLETE PROFILE STARTED ===');
        
        $temporaryUser = TemporaryUser::where('verificationToken', $token)
            ->where('is_verified', true)
            ->where('profile_completed', false)
            ->first();

        if (!$temporaryUser) {
            return redirect()->route('register-pelakuekraf')
                ->withErrors(['error' => 'Token tidak valid atau profil sudah dilengkapi.']);
        }

        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users', 'unique:temporary_users,name,' . $temporaryUser->id],
            'phone_number' => ['required', 'string', 'max:20'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:users,nik', 'unique:temporary_users,nik,' . $temporaryUser->id],
            'nib' => ['nullable', 'string', 'size:13', 'regex:/^[0-9]{13}$/', 'unique:users,nib', 'unique:temporary_users,nib,' . $temporaryUser->id],
            'alamat' => ['required', 'string', 'max:500'],
            'gender' => ['required', 'in:male,female'],
            'business_name' => ['required', 'string', 'max:255', 'unique:mitras,business_name', 'unique:temporary_users,business_name,' . $temporaryUser->id],
            'business_status' => ['required', 'in:new,existing,BARU,SUDAH_LAMA'],
            'sub_sektor_id' => ['required', 'exists:sub_sectors,id'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ],[
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.unique' => 'Nama lengkap sudah terdaftar.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK harus berupa angka 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nib.size' => 'NIB harus 13 digit.',
            'nib.regex' => 'NIB harus berupa angka 13 digit.',
            'nib.unique' => 'NIB sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'business_name.required' => 'Nama usaha wajib diisi.',
            'business_name.unique' => 'Nama usaha sudah terdaftar.',
            'business_status.required' => 'Status usaha wajib dipilih.',
            'sub_sektor_id.required' => 'Sub sektor wajib dipilih.',
            'profile_image.image' => 'File harus berupa gambar.',
            'profile_image.mimes' => 'Format gambar harus JPEG, JPG, atau PNG.',
            'profile_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $businessStatusMap = [
            'new' => 'BARU',
            'existing' => 'SUDAH_LAMA',
            'BARU' => 'BARU',
            'SUDAH_LAMA' => 'SUDAH_LAMA',
        ];

        // Upload profile image to Cloudinary if provided
        $imageUrl = null;
        $cloudinaryId = null;
        $cloudinaryMeta = null;
        
        if ($request->hasFile('profile_image')) {
            try {
                $cloudinaryService = app(CloudinaryService::class);
                $uploadResult = $cloudinaryService->uploadAvatar(
                    $request->file('profile_image'),
                    $temporaryUser->username
                );
                
                if ($uploadResult) {
                    $imageUrl = $uploadResult['secure_url'];
                    $cloudinaryId = $uploadResult['public_id'];
                    $cloudinaryMeta = $uploadResult;
                    
                    Log::info('Profile image uploaded:', ['url' => $imageUrl]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to upload profile image: ' . $e->getMessage());
            }
        }

        // Update temporary user with profile data
        $temporaryUser->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'nik' => $request->nik,
            'nib' => $request->nib,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'image' => $imageUrl,
            'cloudinary_id' => $cloudinaryId,
            'cloudinary_meta' => $cloudinaryMeta,
            'business_name' => $request->business_name,
            'business_status' => $businessStatusMap[$request->business_status] ?? $request->business_status,
            'sub_sektor_id' => $request->sub_sektor_id,
            'profile_completed' => true,
        ]);

        Log::info('Step 3 completed - Profile data saved');

        // Create actual user account
        try {
            $user = User::create([
                'username' => $temporaryUser->username,
                'email' => $temporaryUser->email,
                'password' => $temporaryUser->password,
                'name' => $temporaryUser->name,
                'phone_number' => $temporaryUser->phone_number,
                'nik' => $temporaryUser->nik,
                'nib' => $temporaryUser->nib,
                'alamat' => $temporaryUser->alamat,
                'gender' => $temporaryUser->gender,
                'image' => $temporaryUser->image,
                'cloudinary_id' => $temporaryUser->cloudinary_id,
                'cloudinary_meta' => $temporaryUser->cloudinary_meta,
                'level_id' => 3,
                'email_verified_at' => now()
            ]);

            // Create Pelaku Ekraf record
            PelakuEkraf::create([
                'user_id' => $user->id,
                'business_name' => $temporaryUser->business_name,
                'business_status' => $temporaryUser->business_status,
                'sub_sektor_id' => $temporaryUser->sub_sektor_id,
            ]);

            // Delete temporary user
            $temporaryUser->delete();
            
            Log::info('Registration completed successfully:', ['email' => $user->email]);
            
            return view('auth.verification-success');
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            return view('auth.verification-failed', [
                'message' => 'Terjadi kesalahan saat membuat akun. Silakan hubungi administrator.'
            ]);
        }
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $temporaryUser = TemporaryUser::where('email', $request->email)
            ->where('is_verified', false)
            ->first();

        if (!$temporaryUser) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan atau sudah diverifikasi.'
            ], 404);
        }

        // Generate new token
        $verificationToken = Str::random(64);
        $temporaryUser->update([
            'verificationToken' => $verificationToken,
            'verificationTokenExpiry' => Carbon::now()->addMinutes(10),
        ]);

        $verificationUrl = route('verify.email', ['token' => $verificationToken]);

        try {
            Notification::route('mail', $temporaryUser->email)
                ->notify(new VerifyEmailVerification($verificationUrl, $temporaryUser->username));
            
            return response()->json([
                'success' => true,
                'message' => 'Email verifikasi berhasil dikirim ulang.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to resend verification: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Check availability for step 1 fields (username, email)
     */
    public function checkAvailabilityStep1(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        if (!$field || !$value) {
            return response()->json(['available' => true]);
        }

        $available = true;
        $message = '';

        switch ($field) {
            case 'username':
                $existsInUsers = User::where('username', $value)->exists();
                $existsInTemp = TemporaryUser::where('username', $value)->exists();
                $available = !$existsInUsers && !$existsInTemp;
                $message = $available ? 'Username tersedia' : 'Username sudah digunakan';
                break;

            case 'email':
                $existsInUsers = User::where('email', $value)->exists();
                $existsInTemp = TemporaryUser::where('email', $value)->exists();
                $available = !$existsInUsers && !$existsInTemp;
                $message = $available ? 'Email tersedia' : 'Email sudah terdaftar';
                break;
        }

        return response()->json([
            'available' => $available,
            'message' => $message
        ]);
    }

    /**
     * Check availability for step 3 fields
     */
    public function checkAvailabilityStep3(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $tempUserId = $request->input('temp_user_id');

        if (!$field || !$value) {
            return response()->json(['available' => true]);
        }

        $available = true;
        $message = '';

        switch ($field) {
            case 'name':
                $existsInUsers = User::where('name', $value)->exists();
                $existsInTemp = TemporaryUser::where('name', $value)
                    ->where('id', '!=', $tempUserId)
                    ->exists();
                $available = !$existsInUsers && !$existsInTemp;
                $message = $available ? 'Nama lengkap tersedia' : 'Nama lengkap sudah terdaftar';
                break;

            case 'nik':
                if (strlen($value) === 16) {
                    $existsInUsers = User::where('nik', $value)->exists();
                    $existsInTemp = TemporaryUser::where('nik', $value)
                        ->where('id', '!=', $tempUserId)
                        ->exists();
                    $available = !$existsInUsers && !$existsInTemp;
                    $message = $available ? 'NIK tersedia' : 'NIK sudah terdaftar';
                } else {
                    $available = false;
                    $message = 'NIK harus 16 digit';
                }
                break;

            case 'nib':
                if (strlen($value) === 13) {
                    $existsInUsers = User::where('nib', $value)->exists();
                    $existsInTemp = TemporaryUser::where('nib', $value)
                        ->where('id', '!=', $tempUserId)
                        ->exists();
                    $available = !$existsInUsers && !$existsInTemp;
                    $message = $available ? 'NIB tersedia' : 'NIB sudah terdaftar';
                } else {
                    $available = false;
                    $message = 'NIB harus 13 digit';
                }
                break;

            case 'business_name':
                $existsInPelakuEkrafs = PelakuEkraf::where('business_name', $value)->exists();
                $existsInTemp = TemporaryUser::where('business_name', $value)
                    ->where('id', '!=', $tempUserId)
                    ->exists();
                $available = !$existsInPelakuEkrafs && !$existsInTemp;
                $message = $available ? 'Nama usaha tersedia' : 'Nama usaha sudah terdaftar';
                break;
        }

        return response()->json([
            'available' => $available,
            'message' => $message
        ]);
    }
}
