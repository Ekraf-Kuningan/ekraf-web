<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KatalogView extends Model
{
    use HasFactory;

    protected $fillable = [
        'katalog_id',
        'ip_address',
        'user_agent',
        'referrer',
        'device_type',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Relationship to Katalog
     */
    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }

    /**
     * Track a view for a katalog
     * 
     * @param int $katalogId
     * @param Request $request
     * @return bool Returns true if view was tracked, false if already tracked recently
     */
    public static function trackView($katalogId, Request $request)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $referrer = $request->header('referer');
        
        // Check if this IP has viewed this katalog in the last hour (anti-spam)
        $recentView = self::where('katalog_id', $katalogId)
            ->where('ip_address', $ipAddress)
            ->where('viewed_at', '>', Carbon::now()->subHour())
            ->first();

        if ($recentView) {
            return false; // Already tracked recently
        }

        // Detect device type
        $deviceType = self::detectDeviceType($userAgent);

        // Create new view record
        self::create([
            'katalog_id' => $katalogId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'device_type' => $deviceType,
            'viewed_at' => Carbon::now(),
        ]);

        return true;
    }

    /**
     * Detect device type from user agent
     */
    private static function detectDeviceType($userAgent)
    {
        if (preg_match('/mobile|android|iphone|ipod|blackberry|windows phone/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad|playbook|kindle/i', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Get total view count for a katalog
     */
    public static function getKatalogViewCount($katalogId)
    {
        return self::where('katalog_id', $katalogId)->count();
    }

    /**
     * Get view count for a katalog within a specific period
     * 
     * @param int $katalogId
     * @param int $days Number of days to look back
     */
    public static function getKatalogViewsByPeriod($katalogId, $days = 30)
    {
        return self::where('katalog_id', $katalogId)
            ->where('viewed_at', '>', Carbon::now()->subDays($days))
            ->count();
    }

    /**
     * Get device breakdown for a katalog
     */
    public static function getDeviceBreakdown($katalogId)
    {
        $total = self::where('katalog_id', $katalogId)->count();
        
        if ($total === 0) {
            return [
                'mobile' => 0,
                'tablet' => 0,
                'desktop' => 0,
            ];
        }

        $mobile = self::where('katalog_id', $katalogId)->where('device_type', 'mobile')->count();
        $tablet = self::where('katalog_id', $katalogId)->where('device_type', 'tablet')->count();
        $desktop = self::where('katalog_id', $katalogId)->where('device_type', 'desktop')->count();

        return [
            'mobile' => $mobile,
            'tablet' => $tablet,
            'desktop' => $desktop,
        ];
    }
}
