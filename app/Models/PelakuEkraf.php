<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelakuEkraf extends Model
{
    use HasFactory;

    protected $table = 'pelaku_ekrafs';

    protected $fillable = [
        'user_id',
        'business_name',
        'business_status',
        'sub_sektor_id',
        'description',
    ];

    /**
     * The user that owns the mitra record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subSektor()
    {
        return $this->belongsTo(SubSektor::class, 'sub_sektor_id');
    }
}
