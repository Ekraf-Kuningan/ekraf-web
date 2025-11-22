<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Gagal - EKRAF KUNINGAN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">
            <!-- Error Icon -->
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-times-circle text-4xl text-red-500"></i>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-3">Verifikasi Gagal</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                {{ $message ?? 'Token verifikasi tidak valid atau telah kedaluwarsa.' }}
            </p>
            
            <!-- Info Box -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    Silakan daftar ulang untuk mendapatkan link verifikasi baru.
                </p>
            </div>
            
            <!-- Button -->
            <a href="{{ route('register') }}" class="inline-block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold px-8 py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Ulang
            </a>
            
            <!-- Secondary Button -->
            <a href="{{ route('landing') }}" class="inline-block w-full mt-3 bg-gray-200 text-gray-700 font-semibold px-8 py-3 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
