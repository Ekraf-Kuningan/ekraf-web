<?php
// filepath: app/Models/ProductView.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'ip_address',
        'user_agent',
        'referrer',
        'device_type',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Track view untuk product
     */
    public static function trackView($productId, $request)
    {
        // Deteksi device type
        $userAgent = $request->userAgent();
        $deviceType = 'desktop';
        
        if (preg_match('/mobile/i', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            $deviceType = 'tablet';
        }

        // Cek apakah IP sudah view produk ini dalam 1 jam terakhir (anti spam)
        $recentView = self::where('product_id', $productId)
            ->where('ip_address', $request->ip())
            ->where('viewed_at', '>', now()->subHour())
            ->exists();

        if (!$recentView) {
            self::create([
                'product_id' => $productId,
                'ip_address' => $request->ip(),
                'user_agent' => substr($userAgent, 0, 255),
                'referrer' => $request->header('referer') ? substr($request->header('referer'), 0, 255) : null,
                'device_type' => $deviceType,
                'viewed_at' => now(),
            ]);
        }
    }

    /**
     * Get total views untuk product
     */
    public static function getProductViewCount($productId)
    {
        return self::where('product_id', $productId)->count();
    }

    /**
     * Get views dalam periode tertentu
     */
    public static function getProductViewsByPeriod($productId, $days = 30)
    {
        return self::where('product_id', $productId)
            ->where('viewed_at', '>=', now()->subDays($days))
            ->count();
    }

    /**
     * Get breakdown by device
     */
    public static function getDeviceBreakdown($productId)
    {
        return self::where('product_id', $productId)
            ->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();
    }
}