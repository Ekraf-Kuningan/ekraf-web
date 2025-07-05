<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'owner_name',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'phone_number',
        'uploaded_at',
        'user_id',
        'business_category_id',
        'status'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
                    ->orderBy('sort_order');
    }
}
