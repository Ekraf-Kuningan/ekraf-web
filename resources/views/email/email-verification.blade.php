{{-- filepath: resources/views/emails/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email - EKRAF Kuningan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: bold;
            color: #f97316;
        }
        
        .header h1 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }
        
        .header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            margin-top: 8px;
            position: relative;
            z-index: 1;
        }
        
        .email-hero {
            text-align: center;
            padding: 40px 30px;
            background: linear-gradient(180deg, #fff5f0 0%, #ffffff 100%);
        }
        
        .email-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .email-icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }
        
        .content {
            padding: 30px;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, #fff5f0 0%, #ffffff 100%);
            border-left: 4px solid #f97316;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        
        .welcome-card h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .verify-button {
            display: inline-block;
            width: 100%;
            padding: 18px 40px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.4);
            transition: all 0.3s ease;
            margin: 20px 0;
        }
        
        .verify-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.5);
        }
        
        .timeline {
            margin: 30px 0;
        }
        
        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .timeline-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            color: white;
            font-weight: bold;
        }
        
        .timeline-content h3 {
            color: #1f2937;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .timeline-content p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 30px 0;
        }
        
        .info-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            text-align: center;
        }
        
        .info-card-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .info-card h4 {
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .info-card p {
            color: #6b7280;
            font-size: 13px;
        }
        
        .security-notice {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .security-notice p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        
        .alternative-link {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .alternative-link p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .alternative-link code {
            display: block;
            background: white;
            padding: 10px;
            border-radius: 6px;
            color: #f97316;
            font-size: 12px;
            word-break: break-all;
            border: 1px solid #e5e7eb;
        }
        
        .footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 30px;
            text-align: center;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #374151;
            border-radius: 50%;
            margin: 0 5px;
            line-height: 40px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #f97316;
            transform: translateY(-3px);
        }
        
        .footer p {
            font-size: 13px;
            margin: 10px 0;
        }
        
        .footer a {
            color: #f97316;
            text-decoration: none;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <span class="logo-text">🎨</span>
            </div>
            <h1>EKRAF Kuningan</h1>
            <p>Platform Ekonomi Kreatif Kabupaten Kuningan</p>
        </div>

        <!-- Hero Section -->
        <div class="email-hero">
            <div class="email-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Card -->
            <div class="welcome-card">
                <h2>👋 Halo, {{ $userName }}!</h2>
                <p>
                    Selamat datang di <strong>EKRAF Kuningan</strong>! 
                    Terima kasih telah mendaftar. Kami sangat senang Anda bergabung dengan komunitas pelaku ekonomi kreatif di Kabupaten Kuningan.
                </p>
            </div>

            <!-- Main Message -->
            <p style="font-size: 15px; color: #6b7280; margin-bottom: 20px;">
                Untuk melanjutkan dan mengakses semua fitur platform kami, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:
            </p>

            <!-- Verify Button -->
            <a href="{{ $verificationUrl }}" class="verify-button">
                ✉️ Verifikasi Email Sekarang
            </a>

            <!-- Timeline -->
            <div class="timeline">
                <h3 style="color: #1f2937; margin-bottom: 20px; font-size: 18px;">📋 Langkah Selanjutnya:</h3>
                
                <div class="timeline-item">
                    <div class="timeline-icon">1</div>
                    <div class="timeline-content">
                        <h3>Klik Tombol Verifikasi</h3>
                        <p>Klik tombol orange di atas untuk memverifikasi email Anda</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-icon">2</div>
                    <div class="timeline-content">
                        <h3>Email Terverifikasi</h3>
                        <p>Anda akan diarahkan ke halaman konfirmasi</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-icon">3</div>
                    <div class="timeline-content">
                        <h3>Mulai Menggunakan Platform</h3>
                        <p>Akses dashboard dan mulai kelola produk EKRAF Anda</p>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-icon">⏰</div>
                    <h4>Link Berlaku</h4>
                    <p>60 menit sejak email diterima</p>
                </div>
                
                <div class="info-card">
                    <div class="info-card-icon">🔒</div>
                    <h4>Aman & Terpercaya</h4>
                    <p>Verifikasi dilindungi enkripsi SSL</p>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <p>
                    <strong>⚠️ Perhatian Keamanan:</strong> 
                    Jika Anda tidak membuat akun ini, abaikan email ini atau hubungi kami segera. Link verifikasi ini hanya berlaku untuk satu kali penggunaan dan akan kedaluwarsa dalam 60 menit.
                </p>
            </div>

            <!-- Alternative Link -->
            <div class="alternative-link">
                <p><strong>Tombol tidak berfungsi?</strong> Salin dan tempel link berikut ke browser Anda:</p>
                <code>{{ $verificationUrl }}</code>
            </div>

            <!-- Support Info -->
            <div style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 2px solid #e5e7eb;">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 10px;">
                    Butuh bantuan? Tim kami siap membantu!
                </p>
                <p style="font-size: 14px;">
                    📧 <a href="mailto:support@ekrafkuningan.com" style="color: #f97316; text-decoration: none;">support@ekrafkuningan.com</a><br>
                    📱 <a href="https://wa.me/6281234567890" style="color: #f97316; text-decoration: none;">+62 812-3456-7890</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="#" title="Facebook">f</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="Twitter">🐦</a>
                <a href="#" title="WhatsApp">💬</a>
            </div>
            
            <p style="margin-bottom: 15px;">
                <strong style="color: white;">EKRAF Kuningan</strong><br>
                Platform Ekonomi Kreatif Kabupaten Kuningan
            </p>
            
            <p style="font-size: 12px;">
                Dinas Kepemudaan, Olahraga, dan Pariwisata <br>
                Kabupaten Kuningan, Jawa Barat
            </p>
            
            <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #374151; font-size: 12px;">
                © {{ date('Y') }} EKRAF Kuningan. All rights reserved.<br>
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>