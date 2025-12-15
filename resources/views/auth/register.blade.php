<!DOCTYPE html>
<!-- filepath: d:\Kuliah\Rifky\KP\ekraf-web\resources\views\auth\register.blade.php -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - EKRAF KUNINGAN</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .input-group {
            margin-bottom: 1rem;
        }
        
        .input-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-wrapper input,
        .input-wrapper .custom-select {
            width: 100%;
            padding: 0.875rem 0.875rem 0.875rem 3rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            color: #111827;
            background-color: #F9FAFB;
            transition: all 0.2s;
        }
        
        .input-wrapper input:focus,
        .input-wrapper .custom-select:focus {
            outline: none;
            border-color: #F59E0B;
            background-color: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        
        .input-wrapper .icon {
            position: absolute;
            left: 1rem;
            color: #9CA3AF;
            font-size: 1.125rem;
            pointer-events: none;
            z-index: 1;
        }
        
        .input-wrapper .toggle-password {
            position: absolute;
            right: 1rem;
            color: #9CA3AF;
            cursor: pointer;
            font-size: 1.125rem;
            z-index: 1;
        }
        
        .input-wrapper .toggle-password:hover {
            color: #F59E0B;
        }
        
        /* Custom Select */
        .custom-select {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-right: 3rem !important;
        }
        
        .custom-select.placeholder {
            color: #9CA3AF;
        }
        
        .custom-select-arrow {
            position: absolute;
            right: 1rem;
            color: #9CA3AF;
            pointer-events: none;
            z-index: 1;
            transition: transform 0.2s;
        }
        
        .custom-select:focus ~ .custom-select-arrow {
            transform: rotate(180deg);
            color: #F59E0B;
        }
        
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Bottom Sheet Modal */
        .bottom-sheet {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            border-radius: 1.5rem 1.5rem 0 0;
            z-index: 9999;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            max-height: 70vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .bottom-sheet.active {
            transform: translateY(0);
        }
        
        .bottom-sheet-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            text-align: center;
            position: relative;
        }
        
        .bottom-sheet-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }
        
        .bottom-sheet-close {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #9CA3AF;
            cursor: pointer;
            padding: 0.5rem;
            line-height: 1;
        }
        
        .bottom-sheet-close:hover {
            color: #374151;
        }
        
        .bottom-sheet-content {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }
        
        .option-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #F3F4F6;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 0.9375rem;
            color: #374151;
        }
        
        .option-item:hover {
            background-color: #F9FAFB;
        }
        
        .option-item:active {
            background-color: #F3F4F6;
        }
        
        .option-item:last-child {
            border-bottom: none;
        }
        
        .option-item.selected {
            background-color: #FEF3C7;
            color: #92400E;
            font-weight: 600;
        }
        
        /* Radio Group */
        .radio-group {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .radio-group label {
            display: flex;
            align-items: center;
            font-size: 0.9375rem;
            color: #374151;
            cursor: pointer;
            padding: 0.625rem 1rem;
            border: 2px solid #E5E7EB;
            border-radius: 0.5rem;
            flex: 1;
            justify-content: center;
            transition: all 0.2s;
            background-color: #F9FAFB;
        }
        
        .radio-group label:hover {
            border-color: #FCD34D;
            background-color: #FFFBEB;
        }
        
        .radio-group input[type="radio"] {
            display: none;
        }
        
        .radio-group input[type="radio"]:checked + span {
            font-weight: 600;
        }
        
        .radio-group label:has(input[type="radio"]:checked) {
            border-color: #F59E0B;
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            color: #92400E;
        }
        
        /* File Upload */
        .file-upload-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            border: 2px dashed #E5E7EB;
            border-radius: 0.75rem;
            background-color: #F9FAFB;
            transition: all 0.3s;
        }
        
        .file-upload-wrapper:hover {
            border-color: #FCD34D;
            background-color: #FFFBEB;
        }
        
        .file-upload-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F3F4F6;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .file-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .file-upload-preview i {
            color: #D1D5DB;
        }
        
        .file-upload-button {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
        }
        
        .file-upload-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
        }
        
        /* Button */
        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(245, 158, 11, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9375rem;
            color: #6B7280;
        }
        
        .login-link a {
            color: #F59E0B;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .login-link a:hover {
            color: #D97706;
            text-decoration: underline;
        }
        
        .error-message {
            background-color: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #DC2626;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        /* Hidden native select */
        select {
            display: none;
        }

        /* Availability feedback styles */
        .availability-feedback {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-wrapper input.border-green-500 {
            border-color: #10B981 !important;
            background-color: #F0FDF4 !important;
        }

        .input-wrapper input.border-red-500 {
            border-color: #EF4444 !important;
            background-color: #FEF2F2 !important;
        }

        .input-wrapper input.border-green-500:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .input-wrapper input.border-red-500:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header dengan Logo -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 py-6 px-4 text-center">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo" class="w-14 h-14 object-contain">
                </div>
                <h1 class="text-2xl font-bold text-white">EKRAF KUNINGAN</h1>
                <p class="text-orange-100 text-sm mt-1">Daftar Menjadi Mitra UMKM Sekarang</p>
            </div>
        </div>

        <!-- Form Content -->
        <div class="flex-1 px-4 py-6 max-w-md mx-auto w-full">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register-pelakuekraf') }}" id="registerForm" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user icon"></i>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}" 
                               placeholder="Masukkan username"
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan email"
                               required>
                    </div>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan kata sandi"
                               required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi kata sandi Anda"
                               required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="input-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-circle icon"></i>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap Anda"
                               required>
                    </div>
                </div>

                <!-- Foto Profil (Optional) -->
                <div class="input-group">
                    <label for="profile_image">Foto Profil (Opsional)</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-preview" id="imagePreview">
                            <i class="fas fa-user-circle text-6xl text-gray-300"></i>
                            <p class="text-sm text-gray-500 mt-2">Belum ada foto dipilih</p>
                        </div>
                        <input type="file" 
                               id="profile_image" 
                               name="profile_image" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="profile_image" class="file-upload-button">
                            <i class="fas fa-camera mr-2"></i>
                            Pilih Foto
                        </label>
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                    </div>
                </div>

                <!-- Nomor HP -->
                <div class="input-group">
                    <label for="phone_number">Nomor HP</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone icon"></i>
                        <input type="tel" 
                               id="phone_number" 
                               name="phone_number" 
                               value="{{ old('phone_number') }}" 
                               placeholder="Contoh: 08123456789"
                               pattern="[0-9]{10,13}"
                               required>
                    </div>
                </div>

                <!-- NIK (KTP) -->
                <div class="input-group">
                    <label for="nik">NIK (Nomor Induk Kependudukan)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card icon"></i>
                        <input type="text" 
                               id="nik" 
                               name="nik" 
                               value="{{ old('nik') }}" 
                               placeholder="Masukkan 16 digit NIK KTP"
                               pattern="[0-9]{16}"
                               maxlength="16"
                               required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">16 digit sesuai KTP</p>
                </div>

                <!-- NIB (Nomor Izin Berusaha) -->
                <div class="input-group">
                    <label for="nib">NIB (Nomor Izin Berusaha)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-certificate icon"></i>
                        <input type="text" 
                               id="nib" 
                               name="nib" 
                               value="{{ old('nib') }}" 
                               placeholder="Masukkan 13 digit NIB"
                               pattern="[0-9]{13}"
                               maxlength="13"
                               required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">13 digit dari OSS</p>
                </div>

                <!-- Alamat -->
                <div class="input-group">
                    <label for="alamat">Alamat Lengkap</label>
                    
                    <!-- GPS Location Button -->
                    <div class="mb-3 flex gap-2">
                        <button type="button" id="getLocationBtn" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg text-sm font-medium transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Gunakan Lokasi Saya</span>
                        </button>
                        <button type="button" id="clearLocationBtn" class="hidden items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-times"></i>
                            <span>Hapus</span>
                        </button>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div id="locationLoading" class="hidden mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-600 border-t-transparent"></div>
                            <span class="text-sm text-blue-700 font-medium">Mendapatkan lokasi Anda...</span>
                        </div>
                    </div>
                    
                    <!-- Location Success Info -->
                    <div id="locationInfo" class="hidden mb-3 p-3 bg-green-50 border-l-4 border-green-500 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 text-lg"></i>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-800">Lokasi Berhasil Terdeteksi!</p>
                                <p id="locationText" class="text-xs text-green-700 mt-1"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alamat Textarea dengan styling yang lebih baik -->
                    <div class="relative">
                        <div class="absolute left-4 top-4 text-gray-400 z-10">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                        </div>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="5"
                            placeholder="Contoh: Jl. Siliwangi No. 123, Desa Cigugur, Kecamatan Kuningan, Kabupaten Kuningan, Jawa Barat 45511"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none text-sm leading-relaxed"
                            required>{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mt-2 flex items-start gap-2 text-xs text-gray-600 bg-gray-50 p-2 rounded-lg">
                        <i class="fas fa-info-circle mt-0.5 text-blue-500"></i>
                        <p>Klik tombol <strong>"Gunakan Lokasi Saya"</strong> untuk otomatis mengisi alamat berdasarkan GPS, atau ketik manual alamat lengkap Anda</p>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="input-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                            <span>Laki-laki</span>
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }} required>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Nama Usaha -->
                <div class="input-group">
                    <label for="business_name">Nama Usaha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-store icon"></i>
                        <input type="text" 
                               id="business_name" 
                               name="business_name" 
                               value="{{ old('business_name') }}" 
                               placeholder="Masukkan nama usaha Anda"
                               required>
                    </div>
                </div>

                <!-- Jenis Kelamin (Hidden for form submission) -->
                {{-- <div class="input-group">
                    <label>Jenis Kelamin</label>
                    <div class="input-wrapper">
                        <i class="fas fa-venus-mars icon"></i>
                        <div class="custom-select placeholder" data-select="gender" tabindex="0">
                            <span class="selected-text">Pilih Jenis Kelamin</span>
                        </div>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </div>
                    <select id="gender" name="gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div> --}}

                <!-- Status Usaha -->
                <div class="input-group">
                    <label for="business_status">Status Usaha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-building icon"></i>
                        <div class="custom-select placeholder" data-select="business_status" tabindex="0">
                            <span class="selected-text">Pilih Status Usaha</span>
                        </div>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </div>
                    <select id="business_status" name="business_status" required>
                        <option value="">Pilih Status Usaha</option>
                        <option value="new" {{ old('business_status') === 'new' ? 'selected' : '' }}>Usaha Baru</option>
                        <option value="existing" {{ old('business_status') === 'existing' ? 'selected' : '' }}>Usaha Lama</option>
                    </select>
                </div>

                <!-- Kategori Usaha (Sub Sektor) -->
                <div class="input-group">
                    <label for="sub_sektor_id">Kategori Usaha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-tags icon"></i>
                        <div class="custom-select placeholder" data-select="sub_sektor_id" tabindex="0">
                            <span class="selected-text">Pilih Kategori Usaha</span>
                        </div>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </div>
                    <select id="sub_sektor_id" name="sub_sektor_id" required>
                        <option value="">Pilih Kategori Usaha</option>
                        @isset($subSektors)
                            @foreach($subSektors as $subSektor)
                                <option value="{{ $subSektor->id }}" {{ old('sub_sektor_id') == $subSektor->id ? 'selected' : '' }}>
                                    {{ $subSektor->title }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <!-- Hidden Level (Mitra) -->
                <input type="hidden" name="level_id" value="3">

                <!-- Submit Button -->
                <button type="submit" class="btn-primary mt-6" id="registerButton">
                    <span id="registerText">
                        Daftar
                    </span>
                    <span id="loadingText" class="hidden">
                        <i class="fas fa-spinner fa-spin"></i>
                        Memproses...
                    </span>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay"></div>

    <!-- Bottom Sheet Modal -->
    <div class="bottom-sheet" id="bottomSheet">
        <div class="bottom-sheet-header">
            <h3 class="bottom-sheet-title" id="modalTitle">Pilih Opsi</h3>
            <button type="button" class="bottom-sheet-close" onclick="closeModal()">×</button>
        </div>
        <div class="bottom-sheet-content" id="modalContent">
            <!-- Options will be populated here -->
        </div>
    </div>

    <script>
        let currentSelectId = null;

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
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

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            
            if (file) {
                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    input.value = '';
                    return;
                }
                
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `
                    <i class="fas fa-user-circle text-6xl text-gray-300"></i>
                    <p class="text-sm text-gray-500 mt-2">Belum ada foto dipilih</p>
                `;
            }
        }


        function openModal(selectId) {
            currentSelectId = selectId;
            const select = document.getElementById(selectId);
            const options = Array.from(select.options);
            const modalContent = document.getElementById('modalContent');
            const modalTitle = document.getElementById('modalTitle');
            const overlay = document.getElementById('modalOverlay');
            const bottomSheet = document.getElementById('bottomSheet');

            // Set modal title
            const label = select.previousElementSibling?.textContent || 'Pilih Opsi';
            modalTitle.textContent = select.closest('.input-group').querySelector('label')?.textContent || 'Pilih Opsi';

            // Clear previous options
            modalContent.innerHTML = '';

            // Populate options
            options.forEach(option => {
                if (option.value === '') return; // Skip placeholder

                const optionItem = document.createElement('div');
                optionItem.className = 'option-item';
                if (option.selected) {
                    optionItem.classList.add('selected');
                }
                optionItem.textContent = option.textContent;
                optionItem.onclick = () => selectOption(option.value, option.textContent);
                modalContent.appendChild(optionItem);
            });

            // Show modal
            overlay.classList.add('active');
            bottomSheet.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const overlay = document.getElementById('modalOverlay');
            const bottomSheet = document.getElementById('bottomSheet');
            
            overlay.classList.remove('active');
            bottomSheet.classList.remove('active');
            document.body.style.overflow = '';
        }

        function selectOption(value, text) {
            if (!currentSelectId) return;

            const select = document.getElementById(currentSelectId);
            const customSelect = document.querySelector(`[data-select="${currentSelectId}"]`);
            const selectedText = customSelect.querySelector('.selected-text');

            // Update native select
            select.value = value;

            // Update custom select display
            selectedText.textContent = text;
            customSelect.classList.remove('placeholder');

            // Close modal
            closeModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize custom selects
            const customSelects = document.querySelectorAll('.custom-select');
            customSelects.forEach(customSelect => {
                const selectId = customSelect.dataset.select;
                const select = document.getElementById(selectId);

                // Set initial value if exists
                if (select.value) {
                    const selectedOption = select.options[select.selectedIndex];
                    const selectedText = customSelect.querySelector('.selected-text');
                    selectedText.textContent = selectedOption.textContent;
                    customSelect.classList.remove('placeholder');
                }

                // Add click event
                customSelect.addEventListener('click', () => openModal(selectId));
                
                // Add keyboard support
                customSelect.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openModal(selectId);
                    }
                });
            });

            // Close modal on overlay click
            document.getElementById('modalOverlay').addEventListener('click', closeModal);

            // Close modal on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });

            // Form submit handling
            const form = document.getElementById('registerForm');
            const registerButton = document.getElementById('registerButton');
            const registerText = document.getElementById('registerText');
            const loadingText = document.getElementById('loadingText');

            if (form && registerButton) {
                form.addEventListener('submit', function(e) {
                    registerButton.disabled = true;
                    registerText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
                });
            }
        });

        // Real-time availability check
        const fieldsToCheck = {
            'username': {
                element: document.getElementById('username'),
                debounceTimer: null,
                minLength: 3
            },
            'email': {
                element: document.getElementById('email'),
                debounceTimer: null,
                minLength: 5
            },
            'name': {
                element: document.getElementById('name'),
                debounceTimer: null,
                minLength: 3
            },
            'nik': {
                element: document.getElementById('nik'),
                debounceTimer: null,
                minLength: 16
            },
            'nib': {
                element: document.getElementById('nib'),
                debounceTimer: null,
                minLength: 13
            },
            'business_name': {
                element: document.getElementById('business_name'),
                debounceTimer: null,
                minLength: 3
            }
        };

        // Create feedback elements
        Object.keys(fieldsToCheck).forEach(fieldName => {
            const field = fieldsToCheck[fieldName];
            const wrapper = field.element.closest('.input-wrapper') || field.element.closest('.input-group');
            
            // Create feedback div
            const feedbackDiv = document.createElement('div');
            feedbackDiv.id = `${fieldName}-feedback`;
            feedbackDiv.className = 'availability-feedback hidden mt-2 text-sm flex items-center gap-2';
            
            if (wrapper) {
                if (field.element.closest('.input-wrapper')) {
                    wrapper.parentNode.appendChild(feedbackDiv);
                } else {
                    wrapper.appendChild(feedbackDiv);
                }
            }

            // Add event listener
            field.element.addEventListener('input', function() {
                clearTimeout(field.debounceTimer);
                
                const value = this.value.trim();
                const feedbackEl = document.getElementById(`${fieldName}-feedback`);
                
                // Remove existing styles
                this.classList.remove('border-green-500', 'border-red-500');
                feedbackEl.classList.add('hidden');
                
                if (value.length < field.minLength) {
                    return;
                }

                // Show loading state
                feedbackEl.className = 'availability-feedback mt-2 text-sm flex items-center gap-2 text-gray-500';
                feedbackEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memeriksa ketersediaan...</span>';
                
                field.debounceTimer = setTimeout(async () => {
                    try {
                        const response = await fetch('/api/check-availability', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                field: fieldName,
                                value: value
                            })
                        });

                        const data = await response.json();
                        
                        if (data.available) {
                            field.element.classList.add('border-green-500');
                            feedbackEl.className = 'availability-feedback mt-2 text-sm flex items-center gap-2 text-green-600';
                            feedbackEl.innerHTML = `<i class="fas fa-check-circle"></i><span>${data.message}</span>`;
                        } else {
                            field.element.classList.add('border-red-500');
                            feedbackEl.className = 'availability-feedback mt-2 text-sm flex items-center gap-2 text-red-600';
                            feedbackEl.innerHTML = `<i class="fas fa-times-circle"></i><span>${data.message}</span>`;
                        }
                    } catch (error) {
                        console.error('Error checking availability:', error);
                        feedbackEl.classList.add('hidden');
                    }
                }, 500); // 500ms debounce
            });
        });
    </script>

    <!-- Error Toast Notification -->
    @if($errors->any())
    <div id="errorToast" class="fixed top-4 right-4 bg-white rounded-lg shadow-2xl max-w-md z-50 animate-slideIn">
        <div class="flex items-start p-4 border-l-4 border-red-500">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-2xl text-red-500"></i>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Oops! Ada Kesalahan</h3>
                <ul class="mt-2 text-sm text-red-600 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="closeErrorToast()" class="ml-4 text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script>
        function closeErrorToast() {
            const toast = document.getElementById('errorToast');
            if (toast) {
                toast.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        // Auto close error toast after 8 seconds
        setTimeout(() => {
            closeErrorToast();
        }, 8000);
    </script>
    @endif

    <!-- Email Verification Success Modal -->
    @if(session('success'))
    <div id="emailVerificationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all animate-slideIn">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-t-2xl p-6 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <i class="fas fa-envelope-open-text text-4xl text-orange-500"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">Pendaftaran Berhasil!</h2>
            </div>

            <!-- Body -->
            <div class="p-6 text-center">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Silahkan Cek Email untuk Verifikasi</h3>
                
                <p class="text-gray-600 mb-2">
                    {{ session('success') }}
                </p>
                
                <p class="text-sm text-gray-500 mb-6">
                    Link verifikasi akan <strong class="text-orange-600">kedaluwarsa dalam 10 menit</strong>.
                </p>

                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-orange-500 mt-1 mr-3"></i>
                        <p class="text-sm text-gray-700 text-left">
                            Jika email tidak masuk, periksa folder <strong>Spam</strong> atau <strong>Promosi</strong> Anda.
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="space-y-3">
                    <button onclick="openGmail()" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fab fa-google mr-2"></i>
                        Buka Gmail
                    </button>
                    
                    <button onclick="closeEmailModal()" class="w-full bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-300 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out;
        }
    </style>

    <script>
        function openGmail() {
            window.open('https://mail.google.com', '_blank');
        }

        function closeEmailModal() {
            const modal = document.getElementById('emailVerificationModal');
            if (modal) {
                modal.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('emailVerificationModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeEmailModal();
                    }
                });
            }
        });
    </script>
    @endif

    <!-- GPS Location Script -->
    <script>
        // Pastikan DOM sudah loaded
        document.addEventListener('DOMContentLoaded', function() {
            // GPS Location Functionality (Tanpa Koordinat)
            const getLocationBtn = document.getElementById('getLocationBtn');
            const clearLocationBtn = document.getElementById('clearLocationBtn');
            const locationLoading = document.getElementById('locationLoading');
            const locationInfo = document.getElementById('locationInfo');
            const locationText = document.getElementById('locationText');
            const alamatTextarea = document.getElementById('alamat');

            // Check if elements exist
            if (!getLocationBtn || !alamatTextarea) {
                console.error('❌ Element GPS button tidak ditemukan!');
                return;
            }

            // Get Location Button Click
            getLocationBtn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('❌ Geolocation tidak didukung oleh browser Anda.\n\nSilakan ketik alamat secara manual.');
                return;
            }

            // Show loading
            locationLoading.classList.remove('hidden');
            locationInfo.classList.add('hidden');
            getLocationBtn.disabled = true;
            getLocationBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Get current position with high accuracy
            const geoOptions = {
                enableHighAccuracy: true,  // Gunakan GPS hardware untuk akurasi tinggi
                timeout: 30000,            // Timeout 30 detik (lebih lama untuk GPS fix)
                maximumAge: 0              // Jangan gunakan cache lokasi lama
            };

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    console.log('📍 Lokasi terdeteksi:', {
                        latitude: latitude,
                        longitude: longitude,
                        accuracy: accuracy + ' meter'
                    });

                    // Peringatan jika akurasi rendah (lebih dari 500 meter)
                    if (accuracy > 500) {
                        const useAnyway = confirm(
                            `⚠️ Akurasi GPS rendah (±${Math.round(accuracy)} meter)\n\n` +
                            `Kemungkinan lokasi kurang akurat.\n\n` +
                            `Tips untuk akurasi lebih baik:\n` +
                            `• Aktifkan GPS/Location di perangkat\n` +
                            `• Pastikan berada di ruang terbuka (bukan dalam gedung)\n` +
                            `• Tunggu beberapa detik agar GPS mendapat sinyal\n\n` +
                            `Tetap gunakan lokasi ini?`
                        );
                        
                        if (!useAnyway) {
                            locationLoading.classList.add('hidden');
                            getLocationBtn.disabled = false;
                            getLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            return;
                        }
                    }

                    // Validasi koordinat Indonesia (khususnya Jawa Barat/Kuningan)
                    // Indonesia: latitude -11 to 6, longitude 95 to 141
                    // Kuningan area: sekitar -6.8 to -7.1 lat, 108.3 to 108.7 lon
                    if (latitude < -11 || latitude > 6 || longitude < 95 || longitude > 141) {
                        alert(
                            '⚠️ Lokasi GPS terdeteksi di luar Indonesia.\n\n' +
                            `Koordinat: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}\n` +
                            `Akurasi: ±${Math.round(accuracy)} meter\n\n` +
                            `Kemungkinan penyebab:\n` +
                            `• Browser menggunakan lokasi IP (bukan GPS)\n` +
                            `• GPS belum mendapat sinyal satelit\n` +
                            `• Akses lokasi diblokir\n\n` +
                            `Solusi:\n` +
                            `1. Aktifkan GPS/Location di perangkat\n` +
                            `2. Izinkan akses lokasi untuk browser\n` +
                            `3. Coba di ruang terbuka (keluar gedung)\n` +
                            `4. Tunggu 10-30 detik untuk GPS fix\n` +
                            `5. Atau ketik alamat manual`
                        );
                        
                        locationLoading.classList.add('hidden');
                        getLocationBtn.disabled = false;
                        getLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        return;
                    }

                    // Reverse geocoding using OpenStreetMap Nominatim API
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1&accept-language=id`, {
                        headers: {
                            'User-Agent': 'EKRAF-Kuningan-App/1.0'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Hide loading
                            locationLoading.classList.add('hidden');

                            console.log('🗺️ Data alamat:', data);

                            // Build address from API response
                            const address = data.address;
                            let fullAddress = '';

                            // Format address untuk Indonesia
                            const parts = [];
                            
                            if (address.road || address.pedestrian) {
                                parts.push(address.road || address.pedestrian);
                            }
                            if (address.house_number) {
                                parts[0] += ' No. ' + address.house_number;
                            }
                            if (address.village || address.hamlet) {
                                parts.push('Desa/Kel. ' + (address.village || address.hamlet));
                            }
                            if (address.suburb) {
                                parts.push(address.suburb);
                            }
                            if (address.city_district || address.town) {
                                parts.push('Kec. ' + (address.city_district || address.town));
                            }
                            if (address.city || address.county) {
                                parts.push((address.city || address.county));
                            }
                            if (address.state) {
                                parts.push(address.state);
                            }
                            if (address.postcode) {
                                parts.push(address.postcode);
                            }
                            if (address.country) {
                                parts.push(address.country);
                            }

                            fullAddress = parts.join(', ');

                            // Set textarea value
                            alamatTextarea.value = fullAddress || data.display_name;

                            // Show success info with accuracy
                            locationInfo.classList.remove('hidden');
                            let infoText = fullAddress || data.display_name;
                            if (accuracy) {
                                infoText += ` (Akurasi: ${Math.round(accuracy)}m)`;
                            }
                            locationText.textContent = infoText;

                            // Show clear button
                            clearLocationBtn.classList.remove('hidden');
                            clearLocationBtn.classList.add('flex');

                            // Enable get location button
                            getLocationBtn.disabled = false;
                            getLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        })
                        .catch(error => {
                            console.error('Error getting address:', error);
                            
                            // Hide loading
                            locationLoading.classList.add('hidden');

                            alert('⚠️ Tidak dapat mendapatkan alamat dari GPS.\n\nSilakan ketik alamat secara manual.');

                            // Enable button
                            getLocationBtn.disabled = false;
                            getLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        });
                },
                function(error) {
                    // Hide loading
                    locationLoading.classList.add('hidden');
                    
                    // Enable button
                    getLocationBtn.disabled = false;
                    getLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                    // Show error with detailed explanation
                    let errorMessage = '❌ Tidak dapat mendapatkan lokasi GPS.\n\n';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Anda menolak akses lokasi.\n\n' +
                                'Cara mengaktifkan:\n' +
                                '• Chrome Android: Settings > Site settings > Location > Izinkan\n' +
                                '• Chrome Desktop: Klik ikon gembok/lokasi di URL bar > Lokasi > Izinkan\n' +
                                '• Firefox: Klik ikon (i) di URL > Permissions > Location > Izinkan\n' +
                                '• Safari iOS: Settings > Safari > Location > Ask';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'GPS tidak dapat menentukan posisi.\n\n' +
                                'Kemungkinan penyebab:\n' +
                                '• GPS/Location Service belum aktif di perangkat\n' +
                                '• Berada di dalam gedung (sinyal GPS lemah)\n' +
                                '• Perangkat tidak memiliki GPS hardware\n\n' +
                                'Solusi:\n' +
                                '• Aktifkan Location/GPS di pengaturan perangkat\n' +
                                '• Coba di ruang terbuka\n' +
                                '• Tunggu beberapa saat untuk GPS fix';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'GPS membutuhkan waktu terlalu lama (>30 detik).\n\n' +
                                'Tips:\n' +
                                '• Pastikan GPS aktif di perangkat\n' +
                                '• Coba di area terbuka (bukan dalam gedung)\n' +
                                '• Tunggu GPS mendapat sinyal satelit\n' +
                                '• Tutup aplikasi lain yang menggunakan GPS\n' +
                                '• Restart GPS atau perangkat';
                            break;
                        default:
                            errorMessage += 'Terjadi kesalahan tidak diketahui.\n' +
                                'Error code: ' + error.code;
                    }
                    errorMessage += '\n\n💡 Alternatif: Ketik alamat lengkap secara manual.';
                    alert(errorMessage);
                },
                geoOptions  // Tambahkan options untuk high accuracy
            );
            });

            // Clear Location Button
            clearLocationBtn.addEventListener('click', function() {
                alamatTextarea.value = '';
                locationInfo.classList.add('hidden');
                clearLocationBtn.classList.add('hidden');
                clearLocationBtn.classList.remove('flex');
                alamatTextarea.focus();
            });
        }); // End DOMContentLoaded
    </script>
                      
</body>
</html>