<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = [
        'sub_sector_id',
        'title',
        'slug',
        'image',
        'image_url',        // URL langsung dari Next.js backend
        'cloudinary_id',
        'cloudinary_meta',
        'image_meta',
        'product_name',
        'price',      
        'content',
        'phone_number',      
        'email',
        'instagram',  
        'shopee',     
        'tokopedia', 
        'lazada',    
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image_meta' => 'array',
        'cloudinary_meta' => 'array',
    ];

    public function subSektor()
    {
        return $this->belongsTo(SubSektor::class, 'sub_sector_id');
    }

    /**
     * Many-to-Many relationship with Product
     * Satu katalog bisa memiliki banyak produk, 
     * dan satu produk bisa ditampilkan di banyak katalog
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'catalog_product', 'catalog_id', 'product_id')
                    ->withTimestamps()
                    ->withPivot(['sort_order', 'is_featured'])
                    ->orderByPivot('sort_order', 'asc');
    }

    /**
     * Relationship to KatalogView (tracking)
     */
    public function views()
    {
        return $this->hasMany(KatalogView::class);
    }

    /**
     * Get total view count for this katalog
     */
    public function getViewCountAttribute()
    {
        return $this->views()->count();
    }

    /**
     * Get recent views (last 30 days)
     */
    public function getRecentViewsAttribute()
    {
        return $this->views()->where('viewed_at', '>', now()->subDays(30))->count();
    }

    /**
     * Get today's views
     */
    public function getTodayViewsAttribute()
    {
        return $this->views()->whereDate('viewed_at', today())->count();
    }

    /**
     * Get image URL with fallback (supports External service, Next.js URL, Cloudinary, and local)
     */
    public function getImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If image_url field contains full URL, use it directly
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // 2. PRIORITY: Direct URL in image field (from external service)
        if (!empty($this->image) && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'))) {
            return $this->image;
        }

        // 3. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 800, 600);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 4. FALLBACK: Local storage if image exists (legacy)
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // 5. NEW FALLBACK: Use first product's image if no catalog image exists
        $firstProduct = $this->products()->first();
        if ($firstProduct && !empty($firstProduct->image)) {
            // Check if product image is a URL
            if (str_starts_with($firstProduct->image, 'http://') || str_starts_with($firstProduct->image, 'https://')) {
                return $firstProduct->image;
            }
            // Check if product image exists in storage
            if (file_exists(public_path('storage/' . $firstProduct->image))) {
                return asset('storage/' . $firstProduct->image);
            }
        }

        // 6. Final fallback to placeholder
        return asset('assets/img/placeholder-catalog.svg');
    }

    /**
     * Get optimized image for different sizes
     */
    public function getImageUrl(int $width = 400, int $height = 300): string
    {
        // For Next.js URLs, return as-is (assume they're already optimized)
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // For Cloudinary, get optimized version
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, $width, $height);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // Fallback to first product's image
        $firstProduct = $this->products()->first();
        if ($firstProduct && !empty($firstProduct->image)) {
            if (str_starts_with($firstProduct->image, 'http://') || str_starts_with($firstProduct->image, 'https://')) {
                return $firstProduct->image;
            }
            if (file_exists(public_path('storage/' . $firstProduct->image))) {
                return asset('storage/' . $firstProduct->image);
            }
        }

        return $this->image_url;
    }

    /**
     * Get the source type of the current image for debugging
     */
    public function getImageSource(): string
    {
        // Check in priority order
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return 'Next.js URL';
        }
        
        if (!empty($this->cloudinary_id)) {
            return 'Cloudinary';
        }
        
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return 'Local Storage';
        }

        // Check if using product image
        $firstProduct = $this->products()->first();
        if ($firstProduct && !empty($firstProduct->image)) {
            return 'Product Image (Auto)';
        }
        
        return 'Default Fallback';
    }
}
