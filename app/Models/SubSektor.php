<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubSektor extends Model
{
<<<<<<< HEAD
    use HasFactory;
    
    protected $table = 'sub_sectors';
    
=======
    protected $table = 'sub_sectors';

>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
    ];
<<<<<<< HEAD
    
    public function katalog(): HasMany
    {
        return $this->hasMany(Katalog::class);
=======

    public function katalog()
    {
        return $this->hasMany(Katalog::class, 'sub_sector_id');
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
    }
}
