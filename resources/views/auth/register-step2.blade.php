<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - EKRAF KUNINGAN</title>

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

        .verify-container {
            max-width: 540px;
            width: 100%;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .verify-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #F59E0B, #D97706);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }

        .verify-icon i {
            font-size: 3rem;
            color: white;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(245, 158, 11, 0);
            }
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

        .step.completed {
            background-color: #10B981;
            color: white;
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

        .verify-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .verify-content {
            color: #6B7280;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .email-display {
            background-color: #F3F4F6;
            padding: 0.875rem;
            border-radius: 0.5rem;
            font-weight: 600;
            color: #111827;
            margin: 1.5rem 0;
            word-break: break-all;
        }

        .instructions {
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: left;
            margin: 1.5rem 0;
        }

        .instructions h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #92400E;
            margin-bottom: 0.5rem;
        }

        .instructions ul {
            margin: 0;
            padding-left: 1.25rem;
            color: #92400E;
            font-size: 0.9rem;
        }

        .instructions li {
            margin-bottom: 0.375rem;
        }

        .resend-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #E5E7EB;
        }

        .resend-text {
            color: #6B7280;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .btn-resend {
            background-color: white;
            color: #F59E0B;
            border: 2px solid #F59E0B;
            padding: 0.875rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-resend:hover {
            background-color: #F59E0B;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-resend:disabled {
            background-color: #F3F4F6;
            color: #9CA3AF;
            border-color: #E5E7EB;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            margin-top: 1.5rem;
            color: #6B7280;
            font-size: 0.95rem;
        }

        .back-link a {
            color: #F59E0B;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 0.875rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border: 1px solid #6EE7B7;
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FCA5A5;
        }

        @media (max-width: 640px) {
            .verify-container {
                padding: 2rem 1.5rem;
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

        <!-- Verification Container -->
        <div class="verify-container">
        <div class="step-indicator">
            <div class="step completed"><i class="fas fa-check" style="font-size: 0.75rem;"></i></div>
            <div class="step-line completed"></div>
            <div class="step active">2</div>
            <div class="step-line"></div>
            <div class="step inactive">3</div>
        </div>

        <div class="verify-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <div class="verify-header">
            <h1>Cek Email Anda</h1>
        </div>

        <div class="verify-content">
            <p>Email verifikasi telah dikirim ke:</p>
            <div class="email-display">
                {{ $email }}
            </div>
        </div>

        <div class="instructions">
            <h3><i class="fas fa-info-circle"></i> Langkah Selanjutnya:</h3>
            <ul>
                <li>Buka inbox email Anda</li>
                <li>Klik link verifikasi dalam email</li>
                <li>Setelah verifikasi, Anda akan melanjutkan ke tahap pengisian profil</li>
            </ul>
        </div>

        <div id="alert-container"></div>

        <div class="resend-section">
            <p class="resend-text">Tidak menerima email?</p>
            <button type="button" class="btn-resend" id="resendBtn" onclick="resendVerification()">
                <i class="fas fa-paper-plane"></i> Kirim Ulang Email
            </button>
            <p id="countdown" style="color: #6B7280; font-size: 0.875rem; margin-top: 0.75rem;"></p>
        </div>

        <div class="back-link">
            <a href="{{ route('register-pelakuekraf') }}">
                <i class="fas fa-arrow-left"></i> Kembali ke halaman registrasi
            </a>
        </div>
    </div>
    </div>

    <script>
        let resendCooldown = 60;
        let countdownInterval;

        function startCountdown() {
            const btn = document.getElementById('resendBtn');
            const countdownEl = document.getElementById('countdown');
            btn.disabled = true;

            countdownInterval = setInterval(() => {
                countdownEl.textContent = `Dapat kirim ulang dalam ${resendCooldown} detik`;
                resendCooldown--;

                if (resendCooldown < 0) {
                    clearInterval(countdownInterval);
                    btn.disabled = false;
                    countdownEl.textContent = '';
                    resendCooldown = 60;
                }
            }, 1000);
        }

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}
                </div>
            `;

            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        function resendVerification() {
            const btn = document.getElementById('resendBtn');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

            fetch('/resend-verification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    email: '{{ $email }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    startCountdown();
                } else {
                    showAlert(data.message, 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan. Silakan coba lagi.', 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        // Auto-check email every 10 seconds (optional)
        let checkInterval = setInterval(() => {
            console.log('Checking for verification...');
            // You can add logic here to check if email is verified
        }, 10000);

        // Clear interval when page is closed
        window.addEventListener('beforeunload', () => {
            clearInterval(checkInterval);
        });
    </script>
</body>
</html>
