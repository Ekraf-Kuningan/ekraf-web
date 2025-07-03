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
        'sub_sectors_id',
        'title',
        'slug',
        'produk',
        'harga',      
        'content',
        'no_hp',      
        'instagram',  
        'shopee',     
        'tokopedia', 
        'lazada',    
    ];

    public function subSektor(): BelongsTo
    {
        return $this->belongsTo(SubSektor::class, 'sub_sectors_id');
    }
}
