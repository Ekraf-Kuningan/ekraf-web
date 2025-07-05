<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = [
<<<<<<< HEAD
        'sub_sectors_id',
=======
        'sub_sector_id',
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
        'title',
        'slug',
        'image',
        'product_name',
        'price',      
        'content',
        'contact',
        'phone_number',      
        'email',
        'instagram',  
        'shopee',     
        'tokopedia', 
        'lazada',    
    ];

<<<<<<< HEAD
    public function subSektor(): BelongsTo
    {
        return $this->belongsTo(SubSektor::class, 'sub_sectors_id');
=======
    protected $casts = [
        'price' => 'decimal:2'
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
                    ->orderBy('sort_order');
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
    }
}
