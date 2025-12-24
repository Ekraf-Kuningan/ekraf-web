<?php

namespace App\Http\Controllers\PelakuEkraf;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use App\Models\Product;
use App\Models\SubSektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PelakuEkrafKatalogController extends Controller
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

        return view('pelaku-ekraf.katalog-management.index', compact('katalogs'));
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

        return view('pelaku-ekraf.katalog-management.show', compact('katalog'));
    }
}
