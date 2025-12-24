<div class="space-y-4">
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-1">
                    Alasan Penolakan
                </h4>
                <p class="text-sm text-red-700 dark:text-red-400 whitespace-pre-wrap">
                    {{ $product->rejection_reason }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Produk</p>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pemilik</p>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->owner_name }}</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ditolak Oleh</p>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $product->verifier?->name ?? '-' }}
            </p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal Penolakan</p>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $product->verified_at?->format('d M Y, H:i') ?? '-' }}
            </p>
        </div>
    </div>

    @if($product->image)
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Preview Produk</p>
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full max-w-md mx-auto rounded-lg shadow-sm">
    </div>
    @endif

    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-xs text-blue-700 dark:text-blue-300">
                <strong>Catatan:</strong> Pelaku ekraf dapat melihat alasan penolakan ini dan melakukan perbaikan pada produk mereka.
            </p>
        </div>
    </div>
</div>
