<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'business_name',
        'message',
        'rating',
        'type',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk testimonial yang approved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk filter by type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
