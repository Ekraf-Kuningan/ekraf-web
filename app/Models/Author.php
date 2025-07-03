<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'username',
        'avatar',
        'bio'
    ];

    /**
     * Get the avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Jika avatar sudah memiliki path lengkap (dimulai dengan http)
            if (str_starts_with($this->avatar, 'http')) {
                return $this->avatar;
            }
            
            // Cek apakah file benar-benar ada
            $fullPath = storage_path('app/public/' . $this->avatar);
            if (file_exists($fullPath)) {
                return asset('storage/' . $this->avatar);
            }
            
            // Jika file tidak ada, coba cari di public/assets/img
            $publicPath = public_path('assets/img/' . $this->avatar);
            if (file_exists($publicPath)) {
                return asset('assets/img/' . $this->avatar);
            }
        }
        
        // Default avatar jika tidak ada
        return asset('assets/img/User.png');
    }

    public function artikel(){
        return $this->hasMany(Artikel::class);
    }
}
