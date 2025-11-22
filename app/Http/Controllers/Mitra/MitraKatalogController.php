<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use App\Models\Product;
use App\Models\SubSektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MitraKatalogController extends Controller
{
    /**
     * Display a listing of mitra's katalogs
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get katalogs that have products from this mitra
        $katalogs = Katalog::whereHas('products', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['subSektor', 'products'])
        ->latest()
        ->paginate(12);

        return view('mitra.katalog-management.index', compact('katalogs'));
    }

    /**
     * Show the form for creating a new katalog
     */
    public function create()
    {
        $user = Auth::user();
        
        // Get mitra's approved products only
        $products = Product::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->get();
        
        // Get all sub sectors
        $subSektors = SubSektor::orderBy('title')->get();

        return view('mitra.katalog-management.create', compact('products', 'subSektors'));
    }

    /**
     * Store a newly created katalog
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'sub_sector_id' => 'required|exists:sub_sectors,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'instagram' => 'nullable|url|max:255',
            'shopee' => 'nullable|url|max:255',
            'tokopedia' => 'nullable|url|max:255',
            'lazada' => 'nullable|url|max:255',
        ], [
            'sub_sector_id.required' => 'Sub sektor wajib dipilih.',
            'title.required' => 'Judul katalog wajib diisi.',
            'content.required' => 'Deskripsi katalog wajib diisi.',
            'products.required' => 'Minimal pilih 1 produk.',
            'products.min' => 'Minimal pilih 1 produk.',
            'image.max' => 'Ukuran gambar maksimal 8MB.',
        ]);

        // Verify all products belong to this user
        $productIds = $validated['products'];
        $userProducts = Product::where('user_id', $user->id)
            ->whereIn('id', $productIds)
            ->pluck('id')
            ->toArray();

        if (count($userProducts) !== count($productIds)) {
            return back()->withErrors(['products' => 'Anda hanya bisa memilih produk milik Anda sendiri.'])->withInput();
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('katalogs', 'public');
            $validated['image'] = $path;
        }

        // Create katalog
        $katalog = Katalog::create($validated);

        // Attach products
        $katalog->products()->attach($productIds);

        return redirect()->route('mitra.katalog-management.index')
            ->with('success', 'Katalog berhasil ditambahkan!');
    }

    /**
     * Display the specified katalog
     */
    public function show($id)
    {
        $user = Auth::user();
        
        $katalog = Katalog::whereHas('products', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['subSektor', 'products.user'])
        ->findOrFail($id);

        return view('mitra.katalog-management.show', compact('katalog'));
    }
}
