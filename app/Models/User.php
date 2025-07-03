<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'id_level' => 'integer',
        ];
    }
    
    /**
     * Relasi ke tabel level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }
    
    /**
     * Check if user is superadmin (level 1)
     */
    public function isSuperAdmin()
    {
        return $this->id_level === 1;
    }
    
    /**
     * Check if user is admin (level 2)
     */
    public function isAdmin()
    {
        return $this->id_level === 2;
    }
    
    /**
     * Check if user is member (level 3)
     */
    public function isMember()
    {
        return $this->id_level === 3;
    }
    
    /**
     * Check if user has admin privileges (level 1 or 2)
     */
    public function hasAdminAccess()
    {
        return in_array($this->id_level, [1, 2]);
    }
}
