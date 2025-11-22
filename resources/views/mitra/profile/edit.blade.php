@extends('layouts.mitra')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('mitra.dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-orange-600 mb-4 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Profil</h1>
            <p class="mt-2 text-gray-600">Perbarui informasi profil dan akun Anda</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Profile Photo -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Foto Profil</h2>
                    
                    <!-- Current Photo -->
                    <div class="flex flex-col items-center mb-4">
                        @if($user->profile_image_url)
                            <img id="currentPhoto" src="{{ $user->profile_image_url }}" alt="Profile Photo" class="w-40 h-40 rounded-full object-cover border-4 border-orange-100 shadow-lg mb-4">
                        @else
                            <div id="currentPhoto" class="w-40 h-40 rounded-full bg-gradient-to-br from-orange-400 to-orange-500 flex items-center justify-center border-4 border-orange-100 shadow-lg mb-4">
                                <span class="text-5xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        
                      
                    </div>

                    <!-- Delete Photo Button -->
                    @if($user->image)
                    <form action="{{ route('mitra.profile.deleteImage') }}" method="POST" class="mb-4" onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Foto
                        </button>
                    </form>
                    @endif

                    <!-- Business Info -->
                    @if($mitra)
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Bisnis</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-600">
                                <span class="font-medium">Nama Usaha:</span><br>
                                {{ $mitra->business_name ?? '-' }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Sub Sektor:</span><br>
                                {{ $mitra->subSektor->title ?? '-' }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Status:</span><br>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($mitra->status === 'active') bg-green-100 text-green-800
                                    @elseif($mitra->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($mitra->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Information Form -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <form action="{{ route('mitra.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                        @csrf

                        <!-- Error Alert -->
                        @if ($errors->updateProfile->any())
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <h3 class="text-red-800 font-semibold">Terdapat kesalahan pada form</h3>
                                </div>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->updateProfile->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pribadi
                        </h2>

                        <!-- Informasi yang Tidak Bisa Diedit -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Data Identitas (Tidak dapat diubah)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 mb-1">Nama Lengkap</p>
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Jenis Kelamin</p>
                                    <p class="font-semibold text-gray-900">{{ $user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">NIK</p>
                                    <p class="font-semibold text-gray-900">{{ $user->nik }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">NIB</p>
                                    <p class="font-semibold text-gray-900">{{ $user->nib }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-gray-500 mb-1">Alamat</p>
                                    <p class="font-semibold text-gray-900">{{ $user->alamat }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3 italic">
                                <i class="fas fa-info-circle mr-1"></i>
                                Untuk mengubah data identitas, silakan hubungi administrator
                            </p>
                        </div>

                        <div class="space-y-6">
                            <!-- Upload New Photo -->
                            <div>
                                <label for="profile_image" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Upload Foto Baru
                                </label>
                                <div class="flex items-center space-x-4">
                                    <label class="flex-1 cursor-pointer">
                                        <div class="flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-orange-400 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-600" id="fileName">Pilih foto profil baru</span>
                                        </div>
                                        <input 
                                            type="file" 
                                            name="profile_image" 
                                            id="profile_image" 
                                            accept="image/jpeg,image/jpg,image/png,image/webp"
                                            class="hidden"
                                            onchange="previewImage(this)"
                                        >
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto</p>
                                @error('profile_image', 'updateProfile')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preview New Photo -->
                            <div id="previewContainer" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Preview Foto Baru</label>
                                <div class="flex items-center space-x-4">
                                    <img id="previewImage" src="" alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-orange-100 shadow-lg">
                                    <button type="button" onclick="clearPreview()" class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                        Batal
                                    </button>
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('email', 'updateProfile') border-red-500 @enderror"
                                        required
                                    >
                                </div>
                                @error('email', 'updateProfile')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor HP <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="phone_number" 
                                        id="phone_number" 
                                        value="{{ old('phone_number', $user->phone_number) }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('phone_number', 'updateProfile') border-red-500 @enderror"
                                        placeholder="08123456789"
                                        pattern="[0-9]{10,15}"
                                        required
                                    >
                                </div>
                                @error('phone_number', 'updateProfile')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                       

                        <!-- Submit Button -->
                        <div class="mt-8 flex items-center justify-end space-x-4">
                            <a href="{{ route('mitra.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <form action="{{ route('mitra.profile.updatePassword') }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        <!-- Error Alert -->
                        @if ($errors->updatePassword->any())
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <h3 class="text-red-800 font-semibold">Terdapat kesalahan pada form password</h3>
                                </div>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->updatePassword->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Ubah Password
                        </h2>

                        <div class="space-y-6">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Saat Ini <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        name="current_password" 
                                        id="current_password" 
                                        class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('current_password', 'updatePassword') border-red-500 @enderror"
                                        required
                                    >
                                    <button 
                                        type="button"
                                        onclick="togglePassword('current_password')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-eye" id="current_password-icon"></i>
                                    </button>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Baru <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        name="new_password" 
                                        id="new_password" 
                                        class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('new_password', 'updatePassword') border-red-500 @enderror"
                                        required
                                    >
                                    <button 
                                        type="button"
                                        onclick="togglePassword('new_password')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-eye" id="new_password-icon"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                                @error('new_password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        name="new_password_confirmation" 
                                        id="new_password_confirmation" 
                                        class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                        required
                                    >
                                    <button 
                                        type="button"
                                        onclick="togglePassword('new_password_confirmation')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-eye" id="new_password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex items-center justify-end">
                            <button 
                                type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            >
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Logout Button (Mobile Only) -->
                <div class="md:hidden bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar dari Akun
                        </h2>
                        <p class="text-sm text-gray-600 mb-4">
                            Anda akan keluar dari akun ini dan kembali ke halaman login.
                        </p>
                        <button 
                            type="button"
                            onclick="showLogoutConfirmation()"
                            class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeLogoutModal()"></div>

        <!-- Modal positioning -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900">
                            Konfirmasi Keluar
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin keluar dari akun? Anda akan diarahkan kembali ke halaman login.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                    >
                        Ya, Keluar
                    </button>
                </form>
                <button 
                    type="button" 
                    onclick="closeLogoutModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors"
                >
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Preview Image before upload
function previewImage(input) {
    const previewContainer = document.getElementById('previewContainer');
    const previewImg = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('flex');
            fileName.textContent = input.files[0].name;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear Preview
function clearPreview() {
    const input = document.getElementById('profile_image');
    const previewContainer = document.getElementById('previewContainer');
    const fileName = document.getElementById('fileName');
    
    input.value = '';
    previewContainer.classList.add('hidden');
    previewContainer.classList.remove('flex');
    fileName.textContent = 'Pilih foto profil baru';
}

// Show Logout Confirmation Modal
function showLogoutConfirmation() {
    const modal = document.getElementById('logoutModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

// Close Logout Confirmation Modal
function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Auto-hide success messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.bg-green-50');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }
});
</script>
@endsection
