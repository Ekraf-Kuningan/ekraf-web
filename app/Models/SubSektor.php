<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubSektor extends Model
{
    use HasFactory;
    
    protected $table = 'sub_sectors';
    
    protected $fillable = [
        'title',
        'slug',
    ];
    
    public function katalog(): HasMany
    {
        return $this->hasMany(Katalog::class);
    }
}
