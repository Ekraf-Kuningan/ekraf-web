<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_featured',
        'author_id',
        'artikel_kategori_id'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function artikelKategori()
    {
        return $this->belongsTo(ArtikelKategori::class, 'artikel_kategori_id');
    }

    // Relasi ke banner (one-to-many, satu artikel bisa muncul di beberapa banner)
    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    // Scope untuk artikel featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope untuk artikel berdasarkan kategori
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('artikel_kategori_id', $kategoriId);
    }
}
