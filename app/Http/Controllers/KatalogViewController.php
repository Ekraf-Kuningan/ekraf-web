<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\KatalogView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KatalogViewController extends Controller
{
    /**
     * Track a view for a katalog
     */
    public function track(Request $request, $slug)
    {
        try {
            $katalog = Katalog::where('slug', $slug)->firstOrFail();
            
            $tracked = KatalogView::trackView($katalog->id, $request);
            
            // Get updated statistics
            $viewCount = KatalogView::getKatalogViewCount($katalog->id);
            $todayViews = $katalog->today_views;
            $recentViews = $katalog->recent_views;
            
            return response()->json([
                'success' => true,
                'tracked' => $tracked,
                'message' => $tracked ? 'View tracked successfully' : 'Already tracked recently',
                'statistics' => [
                    'total_views' => $viewCount,
                    'today_views' => $todayViews,
                    'recent_views' => $recentViews,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to track katalog view: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to track view'
            ], 500);
        }
    }

    /**
     * Get detailed statistics for a katalog
     */
    public function statistics($slug)
    {
        try {
            $katalog = Katalog::where('slug', $slug)->firstOrFail();
            
            $totalViews = KatalogView::getKatalogViewCount($katalog->id);
            $last30Days = KatalogView::getKatalogViewsByPeriod($katalog->id, 30);
            $last7Days = KatalogView::getKatalogViewsByPeriod($katalog->id, 7);
            $today = $katalog->today_views;
            $deviceBreakdown = KatalogView::getDeviceBreakdown($katalog->id);
            
            return response()->json([
                'success' => true,
                'katalog' => [
                    'id' => $katalog->id,
                    'title' => $katalog->title,
                    'slug' => $katalog->slug,
                ],
                'statistics' => [
                    'total_views' => $totalViews,
                    'today' => $today,
                    'last_7_days' => $last7Days,
                    'last_30_days' => $last30Days,
                    'device_breakdown' => $deviceBreakdown,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get katalog statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics'
            ], 500);
        }
    }
}
