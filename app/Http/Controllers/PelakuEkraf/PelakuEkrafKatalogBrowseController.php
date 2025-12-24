<?php

namespace App\Http\Controllers\PelakuEkraf;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use App\Models\SubSektor;
use Illuminate\Http\Request;

class PelakuEkrafKatalogBrowseController extends Controller
{
    public function index(Request $request)
    {
        $subSektorId = $request->get('sub_sektor');
        $search = $request->get('search');
        
        // Get all sub sectors for filter
        $subSektors = SubSektor::withCount('katalogs')->orderBy('title')->get();
        
        // Build query for KATALOG (not products)
        $query = Katalog::with(['subSektor', 'products'])
            ->withCount('views');
        
        // Filter by sub sektor
        if ($subSektorId) {
            $query->where('sub_sector_id', $subSektorId);
        }
        
        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Paginate katalogs
        $katalogs = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get selected sub sektor name
        $selectedSubSektor = $subSektorId ? SubSektor::find($subSektorId) : null;
        
        return view('pelaku-ekraf.katalog.index', compact('katalogs', 'subSektors', 'selectedSubSektor', 'search'));
    }
    
    public function show($slug)
    {
        // Redirect to public katalog detail page
        return redirect()->route('katalog.show', $slug);
    }
}
