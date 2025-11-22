<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Product extends Model
{
    public $timestamps = false;
    
    // String-based primary key (custom ID format: PEK001)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'cloudinary_id',
        'cloudinary_meta',
        'uploaded_at',
        'user_id',
        'sub_sektor_id',
        'business_category_id',
        'status'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'price' => 'decimal:2',
        'cloudinary_meta' => 'array',
    ];

    /**
     * Boot method to auto-generate custom ID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->id)) {
                $product->id = $product->generateCustomId();
            }
        });
    }

    /**
     * Generate custom ID in format: PEX### (P=Produk, E=Ekraf, X=SubSektor initial, ###=number)
     */
    protected function generateCustomId(): string
    {
        // Get sub sektor title
        $subSektor = \App\Models\SubSektor::find($this->sub_sektor_id);
        $firstLetter = $subSektor ? strtoupper(substr($subSektor->title, 0, 1)) : 'X';
        
        // Get count of products with same sub sektor initial
        $lastProduct = self::where('id', 'LIKE', "PE{$firstLetter}%")
                          ->orderBy('id', 'desc')
                          ->first();
        
        $nextNumber = 1;
        if ($lastProduct) {
            // Extract number from last ID (e.g., PEK005 -> 005)
            $lastNumber = (int) substr($lastProduct->id, 3);
            $nextNumber = $lastNumber + 1;
        }
        
        return 'PE' . $firstLetter . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subSektor()
    {
        return $this->belongsTo(SubSektor::class, 'sub_sektor_id');
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function onlineStoreLinks()
    {
        return $this->hasMany(OnlineStoreLink::class, 'product_id');
    }

    /**
     * Many-to-Many relationship with Katalog
     * Satu produk bisa ditampilkan di banyak katalog,
     * dan satu katalog bisa memiliki banyak produk
     */
    public function katalogs()
    {
        return $this->belongsToMany(Katalog::class, 'catalog_product', 'product_id', 'catalog_id')
                    ->withTimestamps()
                    ->withPivot(['sort_order', 'is_featured'])
                    ->orderByPivot('sort_order', 'asc');
    }

    /**
     * Get image URL with smart detection and fallback
     */
    public function getImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from Cloudinary or external service
        // Check if image field contains full URL (starts with http:// or https://)
        if (!empty($this->attributes['image']) && (str_starts_with($this->attributes['image'], 'http://') || str_starts_with($this->attributes['image'], 'https://'))) {
            return $this->attributes['image'];
        }

        // 2. FALLBACK: If we have a Cloudinary ID, use it to generate URL
        if (!empty($this->attributes['cloudinary_id'])) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->attributes['cloudinary_id'], 500, 500);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 3. FALLBACK: Local storage if image path exists
        if (!empty($this->attributes['image']) && file_exists(public_path('storage/' . $this->attributes['image']))) {
            return asset('storage/' . $this->attributes['image']);
        }

        // 4. Final fallback to placeholder
        return asset('assets/img/placeholder-product.svg');
    }

    /**
     * Get optimized image for different sizes
     */
    public function getImageUrl(int $width = 300, int $height = 300): string
    {
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, $width, $height);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
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
        
        return 'Default Fallback';
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, 'product_id', 'id');
    }

    public function getViewsCountAttribute(): int
    {
        return $this->productViews()->count();
    }
    public function getRecentViewsAttribute()
    {
        return $this->productViews()->where('viewed_at', '>=', now()->subDays(30))->count();
    }
}
