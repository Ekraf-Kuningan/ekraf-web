<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Level;
use App\Models\SubSektor;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\TemporaryUser;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailVerification;
use App\Services\CloudinaryService;

class CustomRegisterController extends Controller
{
    /**
     * Show the registration form - Step 1 (Username, Email, Password)
     */
    public function create()
    {
        return view('auth.register-step1');
    }

    /**
     * Show complete profile form - Step 3
     */
    public function showCompleteProfile($token)
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
     * Handle registration request - Step 1 (Username, Email, Password)
     */
    public function store(Request $request)
    {
        Log::info('=== REGISTRATION ATTEMPT STARTED ===');
        Log::info('Request data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users', 'unique:temporary_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:temporary_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255', 'unique:users', 'unique:temporary_users'],
            'phone_number' => ['required', 'string', 'max:20'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:users,nik', 'unique:temporary_users,nik'],
            'nib' => ['required', 'string', 'size:13', 'regex:/^[0-9]{13}$/', 'unique:users,nib', 'unique:temporary_users,nib'],
            'alamat' => ['required', 'string', 'max:500'],
            'gender' => ['required', 'in:male,female'],
            'business_name' => ['required', 'string', 'max:255', 'unique:mitras,business_name', 'unique:temporary_users,business_name'],
            'business_status' => ['required', 'in:new,existing,BARU,SUDAH_LAMA'],
            'sub_sektor_id' => ['required', 'exists:sub_sectors,id'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // max 2MB
        ],[
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.unique' => 'Nama lengkap sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK harus berupa angka 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nib.required' => 'NIB wajib diisi.',
            'nib.size' => 'NIB harus 13 digit.',
            'nib.regex' => 'NIB harus berupa angka 13 digit.',
            'nib.unique' => 'NIB sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'business_name.unique' => 'Nama usaha sudah terdaftar.',
            'sub_sektor_id.required' => 'Sub sektor harus dipilih.',
            'sub_sektor_id.exists' => 'Sub sektor tidak valid.',
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
        
        $verificationToken = Str::random(65);
        
        // Upload profile image to Cloudinary if provided
        $imageUrl = null;
        $cloudinaryId = null;
        $cloudinaryMeta = null;
        
        if ($request->hasFile('profile_image')) {
            try {
                $cloudinaryService = app(CloudinaryService::class);
                $uploadResult = $cloudinaryService->uploadAvatar(
                    $request->file('profile_image'),
                    $request->username
                );
                
                if ($uploadResult) {
                    $imageUrl = $uploadResult['secure_url'];
                    $cloudinaryId = $uploadResult['public_id'];
                    $cloudinaryMeta = $uploadResult;
                    
                    Log::info('Profile image uploaded to Cloudinary:', [
                        'url' => $imageUrl,
                        'public_id' => $cloudinaryId
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to upload profile image: ' . $e->getMessage());
                // Continue without image, it's optional
            }
        }
        
        Log::info('Creating temporary user with data:', [
            'username' => $request->username,
            'email' => $request->email,
            'business_status' => $request->business_status,
            'has_image' => !empty($imageUrl)
        ]);
        
        $temporaryUser = TemporaryUser::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'level_id' => 3, // Automatically set to Mitra role
            'verificationToken' => $verificationToken,
            'verificationTokenExpiry' => Carbon::now()->addMinutes(10),
            'createdAt' => Carbon::now(),
        ]);

        Log::info('Temporary user created successfully:', [
            'id' => $temporaryUser->id,
            'email' => $temporaryUser->email
        ]);

        // Generate ke verification URL
        $verificationUrl = route('verify.email', ['token' => $verificationToken]);
        
        Log::info('Verification URL generated:', ['url' => $verificationUrl]);

        // Kirim verification ke Email

        try{
            Notification::route('mail', $temporaryUser->email)
                ->notify(new VerifyEmailVerification($verificationUrl, $temporaryUser->name));
            
            Log::info('Verification email sent successfully to: ' . $temporaryUser->email);
            
            return redirect()->back()->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
        }catch(\Exception $e){
            $temporaryUser->delete(); // Hapus temporary user jika gagal kirim email
            Log::error('Failed to send verification email: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['email' => 'Gagal mengirim email verifikasi. Silakan coba lagi.'])
                ->withInput();
        } 

    
    }
    public function verifyEmail($token) {
        $temporaryUser = TemporaryUser::where('verificationToken', $token)
            ->where('verificationTokenExpiry', '>', Carbon::now())
            ->first();

        if (!$temporaryUser) {
            return redirect()
            ->route('register-pelakuekraf')
            ->withErrors(['error' => 'Token verifikasi tidak valid atau telah kedaluwarsa. Silakan daftar ulang.']);
        }

        try{
             $user = User::create([
            'username' => $temporaryUser->username,
            'email' => $temporaryUser->email,
            'password' => $temporaryUser->password, // Password sudah di-hash di temporary user
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

            // Create Mitra (business) record tied to the user
            Mitra::create([
                'user_id' => $user->id,
                'business_name' => $temporaryUser->business_name,
                'business_status' => $temporaryUser->business_status,
                'sub_sektor_id' => $temporaryUser->sub_sektor_id,
            ]);
            // Delete temporary user record
            $temporaryUser->delete();
            
            Log::info('User verified successfully:', ['email' => $user->email]);
            
            return view('auth.verification-success');
        }catch(\Exception $e){
            Log::error('Failed to create user after verification: ' . $e->getMessage());

            return view('auth.verification-failed', [
                'message' => 'Terjadi kesalahan saat membuat akun. Silakan hubungi administrator.'
            ]);
        }
    }
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $temporaryUser = TemporaryUser::where('email', $request->email)->first();

        if (!$temporaryUser) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan dalam sistem.'
            ], 404);
        }

        // Generate new token
        $verificationToken = \Illuminate\Support\Str::random(64);
        $temporaryUser->update([
            'verificationToken' => $verificationToken,
            'verificationTokenExpiry' => Carbon::now()->addMinutes(10),
        ]);

        // Generate verification URL
        $verificationUrl = route('verify.email', ['token' => $verificationToken]);

        // Send verification email
        try {
            Notification::route('mail', $temporaryUser->email)
                ->notify(new VerifyEmailVerification($verificationUrl, $temporaryUser->name));
            
            return response()->json([
                'success' => true,
                'message' => 'Email verifikasi berhasil dikirim ulang. Silakan cek inbox Anda.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to resend verification email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Check availability of registration fields
     */
    public function checkAvailability(Request $request)
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

            case 'name':
                $existsInUsers = User::where('name', $value)->exists();
                $existsInTemp = TemporaryUser::where('name', $value)->exists();
                $available = !$existsInUsers && !$existsInTemp;
                $message = $available ? 'Nama lengkap tersedia' : 'Nama lengkap sudah terdaftar';
                break;

            case 'nik':
                if (strlen($value) === 16) {
                    $existsInUsers = User::where('nik', $value)->exists();
                    $existsInTemp = TemporaryUser::where('nik', $value)->exists();
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
                    $existsInTemp = TemporaryUser::where('nib', $value)->exists();
                    $available = !$existsInUsers && !$existsInTemp;
                    $message = $available ? 'NIB tersedia' : 'NIB sudah terdaftar';
                } else {
                    $available = false;
                    $message = 'NIB harus 13 digit';
                }
                break;

            case 'business_name':
                $existsInMitras = Mitra::where('business_name', $value)->exists();
                $existsInTemp = TemporaryUser::where('business_name', $value)->exists();
                $available = !$existsInMitras && !$existsInTemp;
                $message = $available ? 'Nama usaha tersedia' : 'Nama usaha sudah terdaftar';
                break;

            default:
                $available = true;
                $message = 'Field tidak valid';
        }

        return response()->json([
            'available' => $available,
            'message' => $message
        ]);
    }

       

       
    
}
