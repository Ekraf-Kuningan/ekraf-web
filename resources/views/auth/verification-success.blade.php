<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil - EKRAF KUNINGAN</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                <i class="fas fa-check-circle text-4xl text-green-500"></i>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-3">Verifikasi Berhasil!</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Email Anda telah berhasil diverifikasi dan akun Anda sudah aktif.
            </p>
            
            <!-- Info Box -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700">
                    <i class="fas fa-info-circle text-green-500 mr-2"></i>
                    Sekarang Anda dapat login menggunakan akun yang telah didaftarkan.
                </p>
            </div>
            
            <!-- Button -->
            <a href="{{ route('login') }}" class="inline-block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold px-8 py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login Sekarang
            </a>
            
            <!-- Footer Text -->
            <p class="text-sm text-gray-500 mt-6">
                Anda dapat menutup halaman ini.
            </p>
        </div>
    </div>
</body>
</html>
