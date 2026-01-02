<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSektor extends Model
{
    protected $table = 'sub_sectors';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
    ];

    public function katalog()
    {
        return $this->hasMany(Katalog::class, 'sub_sector_id');
    }

    public function katalogs()
    {
        return $this->hasMany(Katalog::class, 'sub_sector_id');
    }

    public function businessCategories()
    {
        return $this->hasMany(BusinessCategory::class, 'sub_sector_id');
    }

    public function mitras()
    {
        return $this->hasMany(PelakuEkraf::class, 'sub_sektor_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_sektor_id');
    }
}
