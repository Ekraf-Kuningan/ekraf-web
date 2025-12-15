<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - EKRAF KUNINGAN</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo-container {
            background: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .logo-container img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }
        
        .email-header h1 {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .email-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 15px;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 20px;
            color: #111827;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .greeting .wave {
            display: inline-block;
            animation: wave 1s ease-in-out infinite;
        }
        
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-20deg); }
        }
        
        .message {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 30px;
        }
        
        .verify-button-container {
            text-align: center;
            margin: 35px 0;
        }
        
        .verify-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
        }
        
        .verify-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5);
        }
        
        .info-box {
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            border-left: 4px solid #F59E0B;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .info-box p {
            color: #92400E;
            font-size: 14px;
            margin: 0;
        }
        
        .info-box strong {
            color: #78350F;
        }
        
        .alternative-link {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
        }
        
        .alternative-link p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
        }
        
        .alternative-link a {
            color: #F59E0B;
            word-break: break-all;
            font-size: 12px;
            text-decoration: none;
        }
        
        .alternative-link a:hover {
            text-decoration: underline;
        }
        
        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .email-footer .brand {
            color: #F59E0B;
            font-weight: 600;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 12px;
        }
        
        .social-links a:hover {
            color: #F59E0B;
        }
        
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .email-body {
                padding: 30px 20px;
            }
            
            .email-footer {
                padding: 20px;
            }
            
            .verify-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo-container">
                <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo">
            </div>
            <h1>EKRAF KUNINGAN</h1>
            <p>Ekonomi Kreatif Kabupaten Kuningan</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Halo, {{ $userName }} <span class="wave">👋</span>
            </div>
            
            <div class="message">
                <p style="margin-bottom: 15px;">
                    Terima kasih telah mendaftar sebagai <strong>Pelaku EKRAF</strong> di platform EKRAF Kuningan!
                </p>
                <p style="margin-bottom: 15px;">
                    Untuk melanjutkan proses registrasi dan melengkapi profil Anda, silakan verifikasi email Anda dengan menekan tombol di bawah ini:
                </p>
            </div>
            
            <div class="verify-button-container">
                <a href="{{ $verificationUrl }}" class="verify-button">
                    ✓ Verifikasi Email Sekarang
                </a>
            </div>
            
            <div class="info-box">
                <p>
                    <strong>⏰ Penting:</strong> Link verifikasi ini hanya berlaku selama <strong>10 menit</strong>. 
                    Jika sudah kedaluwarsa, Anda bisa meminta link verifikasi baru dari halaman registrasi.
                </p>
            </div>
            
            <div class="message">
                <p>
                    Setelah email terverifikasi, Anda akan diarahkan untuk melengkapi profil dan data usaha Anda.
                </p>
            </div>
            
            <div class="alternative-link">
                <p>Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:</p>
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </div>
            
            <div class="message" style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #e5e7eb;">
                <p style="color: #9ca3af; font-size: 14px;">
                    Jika Anda tidak membuat akun ini, abaikan saja email ini. Tidak ada perubahan yang akan terjadi pada akun Anda.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>
                Salam hangat,<br>
                <span class="brand">Tim EKRAF KUNINGAN</span>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                Dinas Koperasi, UKM, Perindustrian dan Perdagangan<br>
                Kabupaten Kuningan
            </p>
            <div class="social-links">
                <a href="#">Website</a> • 
                <a href="#">Instagram</a> • 
                <a href="#">Facebook</a>
            </div>
            <p style="margin-top: 20px; font-size: 11px; color: #9ca3af;">
                © {{ date('Y') }} EKRAF Kuningan. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
