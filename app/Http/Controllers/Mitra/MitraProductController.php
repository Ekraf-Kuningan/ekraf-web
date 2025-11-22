<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubSektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MitraProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Query produk milik user yang sedang login
        $query = Product::where('user_id', $user->id)
            ->with(['subSektor', 'businessCategory']);
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan kategori (sub_sektor_id)
        if ($request->filled('category')) {
            $query->where('sub_sektor_id', $request->category);
        }
        
        // Search berdasarkan nama produk atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'uploaded_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        // Pagination
        $products = $query->paginate(12)->withQueryString();
        
        // Get all categories for filter dropdown
        $categories = SubSektor::orderBy('title')->get();
        
        // Statistics
        $stats = [
            'total' => Product::where('user_id', $user->id)->count(),
            'active' => Product::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending' => Product::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Product::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];
        
        return view('mitra.products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = SubSektor::orderBy('title')->get();
        return view('mitra.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sub_sektor_id' => 'required|exists:sub_sectors,id',
            'business_category_id' => 'nullable|exists:business_categories,id',
            'image' => 'nullable|image|max:2048|mimes:jpeg,jpg,png,webp',
        ]);

        $user = Auth::user();
        
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        $validated['uploaded_at'] = now();

        // Upload image ke Cloudinary jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $imageFile = $request->file('image');
                $cloudinaryService = app(\App\Services\CloudinaryService::class);
                $result = $cloudinaryService->uploadProductImage($imageFile);
                
                Log::info('Cloudinary upload result', [
                    'secure_url' => $result['secure_url'] ?? null,
                    'public_id' => $result['public_id'] ?? null,
                ]);
                
                $validated['image'] = $result['secure_url'];
                $validated['cloudinary_id'] = $result['public_id'];
                $validated['cloudinary_meta'] = [
                    'width' => $result['width'] ?? null,
                    'height' => $result['height'] ?? null,
                    'format' => $result['format'] ?? null,
                    'bytes' => $result['bytes'] ?? null,
                ];

               
            } catch (\Exception $e) {
                Log::error('Product image upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
               
                return redirect()->back()
                    ->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        Product::create($validated);

        return redirect()->route('mitra.products')
            ->with('success', 'Produk berhasil ditambahkan dan menunggu verifikasi admin.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('mitra.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        $categories = SubSektor::orderBy('title')->get();
        return view('mitra.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sub_sektor_id' => 'required|exists:sub_sectors,id',
            'business_category_id' => 'nullable|exists:business_categories,id',
            'image' => 'nullable|image|max:2048|mimes:jpeg,jpg,png,webp',
        ]);

        // Upload image ke Cloudinary jika ada file baru
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $imageFile = $request->file('image');
                $cloudinaryService = app(\App\Services\CloudinaryService::class);
                
                // Hapus gambar lama dari Cloudinary jika ada
                if ($product->cloudinary_id) {
                    try {
                        $cloudinaryService->deleteFile($product->cloudinary_id);
                    } catch (\Exception $e) {
                        // Log error but continue with update
                        Log::warning('Failed to delete old image: ' . $e->getMessage());
                    }
                }
                
                // Upload gambar baru
                $result = $cloudinaryService->uploadProductImage($imageFile);
                
                $validated['image'] = $result['secure_url'];
                $validated['cloudinary_id'] = $result['public_id'];
                $validated['cloudinary_meta'] = [
                    'width' => $result['width'] ?? null,
                    'height' => $result['height'] ?? null,
                    'format' => $result['format'] ?? null,
                    'bytes' => $result['bytes'] ?? null,
                ];

            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['image' => 'Gagal mengupload gambar. Silakan coba lagi.'])
                    ->withInput();
            }
        }

        // Set status ke pending jika produk sebelumnya sudah approved
        // Karena perubahan perlu diverifikasi ulang
        if ($product->status === 'approved') {
            $validated['status'] = 'pending';
        }

        $product->update($validated);

        return redirect()->route('mitra.products')
            ->with('success', 'Produk berhasil diperbarui. Silahkan menunggu verifikasi dari admin.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        $product->delete();
        
        return redirect()->route('mitra.products')
            ->with('success', 'Produk berhasil dihapus');
    }
}
