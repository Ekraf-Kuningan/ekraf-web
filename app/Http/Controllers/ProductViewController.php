<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    public function trackAndShow (Request $request, $id)
    {
        $product = Product::findOrFail($id);
        ProductView::trackView($product->id, $request);

        return view('mitra.products.index', compact('product'));
    }
    public function track(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        ProductView::trackView($id, $request);

        return response()->json([
            'success' => true,
            'total_views' => ProductView::getProductViewCount($id),
        ]);
    }
}
