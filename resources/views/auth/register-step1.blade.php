<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - EKRAF KUNINGAN</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: white;
            min-height: 100vh;
            margin: 0;
            padding: 0;
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
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1rem;
            flex: 1;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
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

        .input-wrapper input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #E5E7EB;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #F59E0B;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .input-wrapper .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 1.125rem;
        }

        .input-wrapper .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            cursor: pointer;
            font-size: 1.125rem;
        }

        .input-wrapper .toggle-password:hover {
            color: #F59E0B;
        }

        .validation-message {
            font-size: 0.8rem;
            margin-top: 0.375rem;
        }

        .validation-message.error {
            color: #EF4444;
        }

        .validation-message.success {
            color: #10B981;
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background-color: #F59E0B;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #D97706;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-primary:disabled {
            background-color: #9CA3AF;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6B7280;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #F59E0B;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: #D97706;
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

        @media (max-width: 640px) {
            .register-container {
                padding: 1.5rem 1rem;
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
                <h2>Daftar Akun Pelaku EKRAF</h2>
                <p>Tahap 1: Buat akun Anda</p>
            </div>

        <div class="step-indicator">
            <div class="step active">1</div>
            <div class="step-line"></div>
            <div class="step inactive">2</div>
            <div class="step-line"></div>
            <div class="step inactive">3</div>
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

        <form method="POST" action="{{ route('register-pelakuekraf') }}" id="registerForm">
            @csrf

            <div class="input-group">
                <label for="username">Username <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-user icon"></i>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}"
                        placeholder="Masukkan username" 
                        required
                        autocomplete="username">
                </div>
                <div id="username-validation" class="validation-message"></div>
            </div>

            <div class="input-group">
                <label for="email">Email <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope icon"></i>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Masukkan email" 
                        required
                        autocomplete="email">
                </div>
                <div id="email-validation" class="validation-message"></div>
            </div>

            <div class="input-group">
                <label for="password">Password <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock icon"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 8 karakter" 
                        required
                        autocomplete="new-password">
                    <i class="fas fa-eye toggle-password" data-target="password"></i>
                </div>
                <div id="password-validation" class="validation-message"></div>
            </div>

            <div class="input-group">
                <label for="password_confirmation">Konfirmasi Password <span style="color: #EF4444;">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock icon"></i>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ulangi password" 
                        required
                        autocomplete="new-password">
                    <i class="fas fa-eye toggle-password" data-target="password_confirmation"></i>
                </div>
                <div id="password-confirmation-validation" class="validation-message"></div>
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                Lanjut ke Verifikasi Email
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const target = this.dataset.target;
                const input = document.getElementById(target);
                
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Real-time validation
        let validationTimeout;

        function validateField(field, value) {
            clearTimeout(validationTimeout);
            
            if (!value) return;

            validationTimeout = setTimeout(() => {
                fetch('/api/check-availability-step1', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ field, value })
                })
                .then(response => response.json())
                .then(data => {
                    const validationDiv = document.getElementById(`${field}-validation`);
                    if (data.available) {
                        validationDiv.className = 'validation-message success';
                        validationDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${data.message}`;
                    } else {
                        validationDiv.className = 'validation-message error';
                        validationDiv.innerHTML = `<i class="fas fa-times-circle"></i> ${data.message}`;
                    }
                })
                .catch(error => console.error('Error:', error));
            }, 500);
        }

        document.getElementById('username').addEventListener('input', function() {
            validateField('username', this.value);
        });

        document.getElementById('email').addEventListener('input', function() {
            validateField('email', this.value);
        });

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            const validationDiv = document.getElementById('password-confirmation-validation');

            if (confirmation && password !== confirmation) {
                validationDiv.className = 'validation-message error';
                validationDiv.innerHTML = '<i class="fas fa-times-circle"></i> Password tidak cocok';
            } else if (confirmation && password === confirmation) {
                validationDiv.className = 'validation-message success';
                validationDiv.innerHTML = '<i class="fas fa-check-circle"></i> Password cocok';
            } else {
                validationDiv.innerHTML = '';
            }
        });

        // Password strength validation
        document.getElementById('password').addEventListener('input', function() {
            const validationDiv = document.getElementById('password-validation');
            const password = this.value;

            if (password.length < 8) {
                validationDiv.className = 'validation-message error';
                validationDiv.innerHTML = '<i class="fas fa-times-circle"></i> Password minimal 8 karakter';
            } else {
                validationDiv.className = 'validation-message success';
                validationDiv.innerHTML = '<i class="fas fa-check-circle"></i> Password kuat';
            }
        });
    </script>
</body>
</html>
