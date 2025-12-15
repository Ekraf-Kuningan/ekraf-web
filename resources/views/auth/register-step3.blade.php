<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lengkapi Profil - EKRAF KUNINGAN</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-section {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            background: white;
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .logo-container img {
            width: 3.5rem;
            height: 3.5rem;
            object-fit: contain;
        }

        .header-section h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .header-section p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        .register-container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .register-header p {
            color: #6B7280;
            font-size: 0.95rem;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
            gap: 0.5rem;
        }

        .step {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            position: relative;
        }

        .step.completed {
            background-color: #10B981;
            color: white;
        }

        .step.completed svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .step.active {
            background-color: #F59E0B;
            color: white;
        }

        .step.inactive {
            background-color: #E5E7EB;
            color: #9CA3AF;
        }

        .step-line {
            width: 2rem;
            height: 2px;
            background-color: #E5E7EB;
        }

        .step-line.completed {
            background-color: #10B981;
        }

        .user-info-box {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            padding: 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            color: white;
        }

        .user-info-box h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-info-box h3 svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .user-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .user-info-item:last-child {
            margin-bottom: 0;
        }

        .user-info-item svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .input-group {
            margin-bottom: 1.25rem;
        }

        .input-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input,
        .input-wrapper textarea,
        .input-wrapper .custom-select {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #E5E7EB;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            background-color: #F9FAFB;
        }

        .input-wrapper textarea {
            resize: vertical;
            min-height: 100px;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus,
        .input-wrapper .custom-select:focus {
            outline: none;
            border-color: #F59E0B;
            background-color: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .input-wrapper .icon {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: #9CA3AF;
            pointer-events: none;
            z-index: 1;
        }

        .input-wrapper .icon svg {
            width: 1.125rem;
            height: 1.125rem;
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

        .custom-select-arrow svg {
            width: 1.125rem;
            height: 1.125rem;
        }
        
        .custom-select:focus ~ .custom-select-arrow {
            transform: rotate(180deg);
            color: #F59E0B;
        }

        /* Hidden native select */
        select {
            display: none;
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
            margin: 0;
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
        
        .file-upload-preview svg {
            color: #D1D5DB;
            width: 4rem;
            height: 4rem;
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

        .file-upload-button svg {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }
        
        .file-upload-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
        }

        .file-upload-text {
            font-size: 0.875rem;
            color: #6B7280;
            margin-top: 0.5rem;
        }

        input[type="file"] {
            display: none;
        }


        .validation-message {
            font-size: 0.8rem;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .validation-message svg {
            width: 0.875rem;
            height: 0.875rem;
        }

        .validation-message.error {
            color: #EF4444;
        }

        .validation-message.success {
            color: #10B981;
        }

        .validation-message.info {
            color: #6B7280;
        }

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
            margin-top: 1rem;
        }

        .btn-primary svg {
            width: 1.25rem;
            height: 1.25rem;
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

        .alert {
            padding: 0.875rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            font-size: 0.95rem;
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FCA5A5;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .register-container {
                padding: 1.5rem 1rem;
            }

            .register-header h1 {
                font-size: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
                gap: 1rem;
            }

            .header-section {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-container">
                <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo">
            </div>
            <h1>EKRAF KUNINGAN</h1>
            <p>Daftar Menjadi Mitra UMKM Sekarang</p>
        </div>

        <!-- Form Container -->
        <div class="register-container">
            <div class="register-header">
                <h1>Lengkapi Profil Anda</h1>
                <p>Tahap 3: Informasi profil dan bisnis</p>
            </div>

        <div class="step-indicator">
            <div class="step completed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <div class="step-line completed"></div>
            <div class="step completed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <div class="step-line completed"></div>
            <div class="step active">3</div>
        </div>

        <div class="user-info-box">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                Informasi Akun
            </h3>
            <div class="user-info-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span><strong>Username:</strong> {{ $temporaryUser->username }}</span>
            </div>
            <div class="user-info-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <span><strong>Email:</strong> {{ $temporaryUser->email }}</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.step3', ['token' => $token]) }}" id="registerForm" enctype="multipart/form-data">
            @csrf

            <div class="input-group">
                <label for="name">Nama Lengkap <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap" 
                        required
                        autocomplete="name">
                </div>
                <div id="name-validation" class="validation-message"></div>
            </div>

            <div class="input-group">
                <label for="phone_number">Nomor Telepon <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="phone_number" 
                        name="phone_number" 
                        value="{{ old('phone_number') }}"
                        placeholder="Contoh: 081234567890" 
                        required
                        pattern="[0-9]{10,13}"
                        autocomplete="tel">
                </div>
                <div id="phone-validation" class="validation-message info">Format: 10-13 digit angka</div>
            </div>
            
                

            <div class="form-row">
                <div class="input-group">
                    <label for="nik">NIK <span style="color: #EF4444;">*</span></label>
                    <div class="input-wrapper">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nik" 
                            name="nik" 
                            value="{{ old('nik') }}"
                            placeholder="16 digit NIK" 
                            required
                            pattern="[0-9]{16}"
                            maxlength="16"
                            autocomplete="off">
                    </div>
                    <div id="nik-validation" class="validation-message info">16 digit</div>
                </div>

                <div class="input-group">
                    <label for="nib">NIB (Nomor Induk Berusaha) <span style="color: #9CA3AF; font-size: 0.85rem;">(Opsional)</span></label>
                    <div class="input-wrapper">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nib" 
                            name="nib" 
                            value="{{ old('nib') }}"
                            placeholder="Masukkan NIB 13 digit (opsional)" 
                            pattern="[0-9]{13}"
                            maxlength="13"
                            autocomplete="off">
                    </div>
                    <div id="nib-validation" class="validation-message info">Opsional - 13 digit jika diisi</div>
                </div>
            </div>

            <div class="input-group">
                <label for="alamat">Alamat <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        placeholder="Masukkan alamat lengkap" 
                        required
                        autocomplete="street-address">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <div class="input-group">
                <label>Jenis Kelamin <span style="color: #EF4444;">*</span></label>
                <div class="radio-group">
                    <label>
                        <input 
                            type="radio" 
                            name="gender" 
                            value="male" 
                            {{ old('gender') === 'male' ? 'checked' : '' }}
                            required>
                        <span>Laki-laki</span>
                    </label>
                    <label>
                        <input 
                            type="radio" 
                            name="gender" 
                            value="female"
                            {{ old('gender') === 'female' ? 'checked' : '' }}
                            required>
                        <span>Perempuan</span>
                    </label>
                </div>
            </div>

            <div class="input-group">
                <label for="profile_image">Foto Profil</label>
                <div class="file-upload-wrapper">
                    <div class="file-upload-preview" id="imagePreview">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <input 
                        type="file" 
                        id="profile_image" 
                        name="profile_image"
                        accept="image/*"
                        onchange="previewImage(this)">
                    <label for="profile_image" class="file-upload-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                        Pilih Foto
                    </label>
                    <p class="file-upload-text">Format: JPG, PNG. Maksimal 2MB</p>
                </div>
            </div>

            <div class="input-group">
                <label for="business_name">Nama Usaha <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l4.318-5.586a2.25 2.25 0 0 1 1.79-.88h7.507a2.25 2.25 0 0 1 1.79.88l4.318 5.586a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="business_name" 
                        name="business_name" 
                        value="{{ old('business_name') }}"
                        placeholder="Masukkan nama usaha" 
                        required
                        autocomplete="organization">
                </div>
                <div id="business-name-validation" class="validation-message"></div>
            </div>

            <div class="input-group">
                <label for="business_status">Status Usaha <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <div class="custom-select placeholder" data-select="business_status" tabindex="0">
                        <span class="selected-text">Pilih status usaha</span>
                    </div>
                    <div class="custom-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <select id="business_status" name="business_status" required>
                    <option value="">Pilih status usaha</option>
                    <option value="new" {{ old('business_status') === 'new' ? 'selected' : '' }}>Usaha Baru</option>
                    <option value="existing" {{ old('business_status') === 'existing' ? 'selected' : '' }}>Usaha yang Sudah Berjalan</option>
                </select>
            </div>

            <div class="input-group">
                <label for="sub_sektor_id">Sub Sektor EKRAF <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                    <div class="custom-select placeholder" data-select="sub_sektor_id" tabindex="0">
                        <span class="selected-text">Pilih sub sektor</span>
                    </div>
                    <div class="custom-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <select id="sub_sektor_id" name="sub_sektor_id" required>
                    <option value="">Pilih sub sektor</option>
                    @foreach($subSektors as $subSektor)
                        <option value="{{ $subSektor->id }}" {{ old('sub_sektor_id') == $subSektor->id ? 'selected' : '' }}>
                            {{ $subSektor->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Selesaikan Registrasi
            </button>
        </form>
    </div>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>

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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
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

            // Close modal on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });

        // Real-time validation for unique fields
        let validationTimeout;

        function validateField(field, value) {
            clearTimeout(validationTimeout);
            
            if (!value) return;

            // Skip validation if field doesn't meet minimum requirements
            if (field === 'nik' && value.length !== 16) return;
            if (field === 'nib' && value.length !== 13) return;

            validationTimeout = setTimeout(() => {
                fetch('/api/check-availability-step3', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        field, 
                        value,
                        token: '{{ $token }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    let validationDiv;
                    if (field === 'business_name') {
                        validationDiv = document.getElementById('business-name-validation');
                    } else {
                        validationDiv = document.getElementById(`${field}-validation`);
                    }
                    
                    if (data.available) {
                        validationDiv.className = 'validation-message success';
                        validationDiv.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>${data.message}</span>
                        `;
                    } else {
                        validationDiv.className = 'validation-message error';
                        validationDiv.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>${data.message}</span>
                        `;
                    }
                })
                .catch(error => console.error('Error:', error));
            }, 500);
        }

        // Validate name
        document.getElementById('name').addEventListener('input', function() {
            validateField('name', this.value);
        });

        // Validate NIK
        document.getElementById('nik').addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            const validationDiv = document.getElementById('nik-validation');
            if (this.value.length === 16) {
                validateField('nik', this.value);
            } else if (this.value.length > 0) {
                validationDiv.className = 'validation-message info';
                validationDiv.innerHTML = `16 digit (${this.value.length}/16)`;
            }
        });

        // Validate NIB (optional)
        document.getElementById('nib').addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            const validationDiv = document.getElementById('nib-validation');
            if (this.value.length === 0) {
                validationDiv.className = 'validation-message info';
                validationDiv.innerHTML = 'Opsional - 13 digit jika diisi';
            } else if (this.value.length === 13) {
                validateField('nib', this.value);
            } else if (this.value.length > 0) {
                validationDiv.className = 'validation-message info';
                validationDiv.innerHTML = `13 digit (${this.value.length}/13)`;
            }
        });

        // Validate business name
        document.getElementById('business_name').addEventListener('input', function() {
            validateField('business_name', this.value);
        });

        // Validate phone number format
        document.getElementById('phone_number').addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            const validationDiv = document.getElementById('phone-validation');
            if (this.value.length >= 10 && this.value.length <= 13) {
                validationDiv.className = 'validation-message success';
                validationDiv.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Format nomor valid</span>
                `;
            } else if (this.value.length > 0) {
                validationDiv.className = 'validation-message info';
                validationDiv.innerHTML = `Format: 10-13 digit angka (${this.value.length})`;
            }
        });

        // Form submission validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const nik = document.getElementById('nik').value;
            const nib = document.getElementById('nib').value;
            const phone = document.getElementById('phone_number').value;

            if (nik.length !== 16) {
                e.preventDefault();
                alert('NIK harus 16 digit');
                document.getElementById('nik').focus();
                return;
            }

            // NIB is optional, but if filled must be 13 digits
            if (nib && nib.length !== 13) {
                e.preventDefault();
                alert('NIB harus 13 digit (atau kosongkan jika tidak punya)');
                document.getElementById('nib').focus();
                return;
            }

            if (phone.length < 10 || phone.length > 13) {
                e.preventDefault();
                alert('Nomor telepon harus 10-13 digit');
                document.getElementById('phone_number').focus();
                return;
            }

            // Disable submit button to prevent double submission
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>
