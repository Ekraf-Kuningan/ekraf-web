<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - EKRAF KUNINGAN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body class="bg-gradient-to-br from-yellow-300 via-orange-400 to-orange-500 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 text-center">
                    <h2 class="text-xl font-bold text-white">Permintaan Reset Kata Sandi</h2>
                </div>

                <div class="p-8">
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-green-600 text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:border-orange-400 focus:bg-white transition-all duration-200 font-medium" placeholder="Masukkan alamat email Anda">
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-3 px-6 rounded-lg">Kirim Link Reset</button>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('login') }}" class="text-sm text-orange-600 hover:text-orange-700">Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-6">
                <p class="text-white/80 text-sm font-medium">© {{ date('Y') }} EKRAF KUNINGAN</p>
            </div>
        </div>
    </div>
</body>
</html>
