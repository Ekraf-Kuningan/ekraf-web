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
<<<<<<< HEAD
        'id_level',
=======
        'username',
        'gender',
        'phone_number',
        'image',
        'business_name',
        'business_status',
        'level_id',
        'business_category_id',
        'resetPasswordToken',
        'resetPasswordTokenExpiry',
        'verifiedAt'
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'resetPasswordToken',
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
<<<<<<< HEAD
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
=======
            'resetPasswordTokenExpiry' => 'datetime',
            'verifiedAt' => 'datetime',
        ];
    }

    /**
     * Get the level that owns the user.
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    /**
     * Get the business category that owns the user.
     */
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->level_id === 1;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->level_id === 2;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->level_id === 3;
    }

    /**
     * Check if user has admin or superadmin access
     */
    public function hasAdminAccess(): bool
    {
        return $this->level_id === 1 || $this->level_id === 2;
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
    }
}
