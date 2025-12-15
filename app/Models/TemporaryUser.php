<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TemporaryUser extends Model
{   

    protected $table = 'temporary_users';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'phone_number',
        'nik',
        'nib',
        'alamat',
        'image',
        'cloudinary_id',
        'cloudinary_meta',
        'verificationToken',
        'resetPasswordToken',
        'resetPasswordTokenExpiry',
        'verificationTokenExpiry',
        'business_name',
        'business_status',
        'level_id',
        'sub_sektor_id',
        'createdAt',
        'is_verified',
        'profile_completed',
    ];

    // Cast tipe data
    protected $casts = [
        'resetPasswordTokenExpiry' => 'datetime',
        'verificationTokenExpiry' => 'datetime',
        'createdAt' => 'datetime',
        'cloudinary_meta' => 'array',
    ];

    public static function generateVerificationToken()
    {
        return Str::random(64);
    }

    public function isTokenExpired()
    {
        return $this->verificationTokenExpiry && Carbon::now()->greaterThan($this->verificationTokenExpiry);
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }
}