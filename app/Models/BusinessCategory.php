<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'sub_sector_id',
        'description',
        'image'
    ];

    /**
     * Get the sub sector that owns the business category
     */
    public function subSektor()
    {
        return $this->belongsTo(SubSektor::class, 'sub_sector_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'business_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_category_id');
    }
}
