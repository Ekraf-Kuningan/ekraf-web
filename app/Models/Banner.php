<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link_url',
        'is_active',
        'sort_order',
        'description',
        'artikel_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    // Scope untuk banner aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
