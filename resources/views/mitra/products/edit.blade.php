@extends('layouts.mitra')

@section('title', 'Edit Produk')
@section('page_title', 'Edit Produk Pelaku Ekraf')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('mitra.products') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-orange-600 mb-4 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Produk
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Produk</h1>
            <p class="mt-2 text-gray-600">Perbarui informasi produk Anda dengan detail yang jelas</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <form action="{{ route('mitra.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-red-800 font-semibold">Terdapat kesalahan pada form</h3>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Informasi Produk -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Produk
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Produk -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name', $product->name) }}"
                                    maxlength="50"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('name') border-red-500 @enderror"
                                    placeholder="Contoh: Kerajinan Batik Tulis Premium"
                                    required
                                >
                                <p class="mt-1 text-xs text-gray-500">Maksimal 50 karakter. Nama produk harus unik.</p>
                                <div id="name-validation-message" class="mt-1 text-sm hidden"></div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="sub_sektor_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sub Sektor <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="sub_sektor_id" 
                                    id="sub_sektor_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('sub_sektor_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Sub Sektor</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('sub_sektor_id', $product->sub_sektor_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_sektor_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Business Category -->
                            <div>
                                <label for="business_category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Business Category
                                </label>
                                <select 
                                    name="business_category_id" 
                                    id="business_category_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('business_category_id') border-red-500 @enderror"
                                    disabled
                                >
                                    <option value="">Pilih Sub Sektor terlebih dahulu</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Akan muncul setelah memilih Sub Sektor</p>
                                @error('business_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Harga (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    value="{{ old('price', $product->price) }}"
                                    min="0"
                                    step="1000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('price') border-red-500 @enderror"
                                    placeholder="50000"
                                    required
                                >
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="stock" 
                                    id="stock" 
                                    value="{{ old('stock', $product->stock) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('stock') border-red-500 @enderror"
                                    placeholder="10"
                                    required
                                >
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi Produk <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="5"
                                    maxlength="500"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('description') border-red-500 @enderror"
                                    placeholder="Jelaskan produk Anda dengan detail (bahan, ukuran, keunggulan, dll)"
                                    required
                                >{{ old('description', $product->description) }}</textarea>
                                <div class="flex justify-between mt-1">
                                    <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                                    <p id="charCount" class="text-xs text-gray-500">{{ strlen($product->description ?? '') }}/500</p>
                                </div>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gambar Produk
                        </h2>

                        <div class="space-y-4">
                            <!-- Current Image -->
                            @if($product->image_url)
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Saat Ini</label>
                                <div class="relative inline-block">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-xl border-4 border-gray-200" onerror="this.src='https://via.placeholder.com/400?text=No+Image'">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Upload gambar baru untuk mengubah</p>
                            </div>
                            @endif

                            <!-- Image Preview -->
                            <div id="imagePreview" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Baru</label>
                                <div class="relative inline-block">
                                    <img id="previewImage" src="" alt="Preview" class="w-48 h-48 object-cover rounded-xl border-4 border-orange-200">
                                    <button 
                                        type="button" 
                                        id="removeImage" 
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-colors shadow-lg"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-orange-500 transition-colors cursor-pointer bg-gray-50">
                                <input 
                                    type="file" 
                                    name="image" 
                                    id="image" 
                                    accept="image/jpeg,image/jpg,image/png,image/webp"
                                    class="hidden"
                                >
                                <label for="image" class="cursor-pointer">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-700 mb-2">Klik untuk upload gambar</p>
                                    <p class="text-sm text-gray-500 mb-1">atau drag & drop gambar di sini</p>
                                    <p class="text-xs text-gray-400">PNG, JPG, JPEG, WEBP (Maks. 2MB)</p>
                                </label>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Informasi Penting:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Perubahan produk akan melalui proses verifikasi oleh admin</li>
                                    <li>Pastikan semua informasi yang diisi sudah benar dan lengkap</li>
                                    <li>Gambar produk akan di-upload ke Cloudinary untuk performa optimal</li>
                                    <li>Status produk dapat dilihat di halaman Daftar Produk</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 focus:ring-4 focus:ring-orange-300 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Produk
                    </button>
                    <a 
                        href="{{ route('mitra.products') }}" 
                        class="flex-1 sm:flex-none bg-gray-100 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 transition-all duration-200 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Character counter for description
    const descriptionTextarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    descriptionTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length}/500`;
        
        if (length > 450) {
            charCount.classList.add('text-orange-600', 'font-semibold');
        } else {
            charCount.classList.remove('text-orange-600', 'font-semibold');
        }
    });

    // Business Category Dynamic Loading
    const subSektorSelect = document.getElementById('sub_sektor_id');
    const businessCategorySelect = document.getElementById('business_category_id');
    const oldBusinessCategory = "{{ old('business_category_id', $product->business_category_id) }}";

    subSektorSelect.addEventListener('change', function() {
        const subSektorId = this.value;
        
        // Reset business category
        businessCategorySelect.innerHTML = '<option value="">Loading...</option>';
        businessCategorySelect.disabled = true;

        if (!subSektorId) {
            businessCategorySelect.innerHTML = '<option value="">Pilih Sub Sektor terlebih dahulu</option>';
            return;
        }

        // Fetch business categories
        fetch(`/api/business-categories/${subSektorId}`)
            .then(response => response.json())
            .then(data => {
                businessCategorySelect.innerHTML = '<option value="">Pilih Business Category (Opsional)</option>';
                
                if (data.length > 0) {
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        
                        // Keep old value if exists
                        if (oldBusinessCategory && oldBusinessCategory == category.id) {
                            option.selected = true;
                        }
                        
                        businessCategorySelect.appendChild(option);
                    });
                    businessCategorySelect.disabled = false;
                } else {
                    businessCategorySelect.innerHTML = '<option value="">Tidak ada Business Category untuk Sub Sektor ini</option>';
                }
            })
            .catch(error => {
                console.error('Error fetching business categories:', error);
                businessCategorySelect.innerHTML = '<option value="">Error loading categories</option>';
            });
    });

    // Trigger change on page load if there's an old value
    if (subSektorSelect.value) {
        subSektorSelect.dispatchEvent(new Event('change'));
    }

    // Image preview functionality
    const imageInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const removeImageBtn = document.getElementById('removeImage');

    // Click to upload
    uploadArea.addEventListener('click', () => imageInput.click());

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-orange-500', 'bg-orange-50');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImageSelect(files[0]);
        }
    });

    // Handle image selection
    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            handleImageSelect(this.files[0]);
        }
    });

    function handleImageSelect(file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            uploadArea.classList.add('hidden');
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    // Remove image
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        uploadArea.classList.remove('hidden');
        imagePreview.classList.add('hidden');
        previewImage.src = '';
    });

    // Format price input
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Real-time validation for product name
    const nameInput = document.getElementById('name');
    const nameValidationMessage = document.getElementById('name-validation-message');
    const originalName = '{{ $product->name }}';
    const productId = '{{ $product->id }}';
    let nameCheckTimeout;

    nameInput.addEventListener('blur', function() {
        const productName = this.value.trim();
        
        // Don't check if name hasn't changed
        if (productName === originalName) {
            nameValidationMessage.classList.add('hidden');
            nameInput.classList.remove('border-red-500', 'border-green-500');
            nameInput.classList.add('border-gray-300');
            return;
        }

        if (productName.length < 3) {
            return; // Don't check if name is too short
        }

        // Clear previous timeout
        clearTimeout(nameCheckTimeout);

        // Show loading state
        nameValidationMessage.textContent = 'Memeriksa ketersediaan nama...';
        nameValidationMessage.className = 'mt-1 text-sm text-gray-500';
        nameValidationMessage.classList.remove('hidden');

        // Check after delay
        nameCheckTimeout = setTimeout(() => {
            fetch('{{ route("mitra.products.check-name") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    name: productName,
                    product_id: productId 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    nameInput.classList.add('border-red-500');
                    nameInput.classList.remove('border-gray-300');
                    nameValidationMessage.textContent = 'Nama produk "' + productName + '" sudah digunakan. Silakan gunakan nama yang berbeda.';
                    nameValidationMessage.className = 'mt-1 text-sm text-red-600';
                    nameValidationMessage.classList.remove('hidden');
                } else {
                    nameInput.classList.remove('border-red-500');
                    nameInput.classList.add('border-green-500');
                    nameValidationMessage.textContent = 'Nama produk tersedia ✓';
                    nameValidationMessage.className = 'mt-1 text-sm text-green-600';
                    nameValidationMessage.classList.remove('hidden');
                    
                    // Hide success message after 2 seconds
                    setTimeout(() => {
                        nameValidationMessage.classList.add('hidden');
                        nameInput.classList.remove('border-green-500');
                        nameInput.classList.add('border-gray-300');
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error checking product name:', error);
                nameValidationMessage.classList.add('hidden');
            });
        }, 500);
    });

    // Clear validation message when user types
    nameInput.addEventListener('input', function() {
        clearTimeout(nameCheckTimeout);
        nameValidationMessage.classList.add('hidden');
        this.classList.remove('border-red-500', 'border-green-500');
        this.classList.add('border-gray-300');
    });
</script>
@endsection
