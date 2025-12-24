<?php

namespace App\Http\Controllers\PelakuEkraf;

use App\Http\Controllers\Controller;
use App\Models\PelakuEkraf;
use App\Models\Product;
use App\Models\SubSektor;
use App\Models\ProductView;
use App\Models\Katalog;
use App\Models\KatalogView;
use Illuminate\Support\Facades\Auth;

class PelakuEkrafDashboardController extends Controller
{
	/**
	 * Dashboard utama untuk Pelaku Ekraf (UMKM)
	 */
	public function index()
	{
		$user = Auth::user();

		// Ambil profil pelaku ekraf jika ada (untuk ucapan selamat datang)
		$pelakuEkraf = PelakuEkraf::where('user_id', $user->id)->first();
		
		// Statistik Track view klik katalog (KATALOG, BUKAN PRODUCT)
		// Get all katalogs that contain products from this user
		$userKatalogIds = Katalog::whereHas('products', function($query) use ($user) {
			$query->where('user_id', $user->id);
		})->pluck('id');

		// Initialize stats with defaults if no katalogs found
		if ($userKatalogIds->isEmpty()) {
			$totalViews = 0;
			$viewsThisMonth = 0;
			$viewsToday = 0;
			$topViewedKatalogs = collect([]);
			$deviceStats = [];
			$dailyViews = collect([]);
		} else {
			$totalViews = KatalogView::whereIn('katalog_id', $userKatalogIds)->count();

			$viewsThisMonth = KatalogView::whereIn('katalog_id', $userKatalogIds)
				->where('viewed_at', '>=', now()->startOfMonth())
				->count();

			$viewsToday = KatalogView::whereIn('katalog_id', $userKatalogIds)
				->whereDate('viewed_at', today())
				->count();

			// Top viewed katalogs that contain this user's products
			$topViewedKatalogs = Katalog::whereIn('id', $userKatalogIds)
				->withCount('views')
				->orderBy('views_count', 'desc')
				->take(5)
				->get();

			// Views by device
			$deviceStats = KatalogView::whereIn('katalog_id', $userKatalogIds)
				->selectRaw('device_type, COUNT(*) as count')
				->groupBy('device_type')
				->pluck('count', 'device_type')
				->toArray();

			// Daily views untuk chart (7 hari terakhir)
			$dailyViews = KatalogView::whereIn('katalog_id', $userKatalogIds)
				->where('viewed_at', '>=', now()->subDays(7))
				->selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
				->groupBy('date')
				->orderBy('date')
				->get();
		}

		// Statistik produk berdasarkan status
		$stats = [
			'active' => Product::where('user_id', $user->id)->where('status', 'approved')->count(),
			'pending' => Product::where('user_id', $user->id)->where('status', 'pending')->count(),
			'rejected' => Product::where('user_id', $user->id)->where('status', 'rejected')->count(),
			'total' => Product::where('user_id', $user->id)->count(),
		];

		// 17 kategori (Sub Sektor) -> kolom menggunakan 'title'
		$categories = SubSektor::orderBy('title')->take(17)->get();

		// Produk terbaru milik mitra (maks 5 untuk list kecil)
		$latestProducts = Product::where('user_id', $user->id)
			->orderBy('uploaded_at', 'desc')
			->take(5)
			->get();

		// Semua produk untuk grid (maks 8)
		$products = Product::where('user_id', $user->id)
			->orderBy('uploaded_at', 'desc')
			->take(8)
			->get();

		// Notifikasi status terbaru (produk yang baru saja diupdate statusnya dalam 7 hari terakhir)
		// Gunakan uploaded_at karena products tidak punya updated_at
		$notifications = Product::where('user_id', $user->id)
			->whereIn('status', ['approved', 'rejected'])
			->where('uploaded_at', '>=', now()->subDays(30)) // 30 hari untuk lebih banyak notifikasi
			->orderBy('uploaded_at', 'desc')
			->take(5)
			->get();

		// Katalog berdasarkan sub sektor (semua katalog dari semua user)
		$katalogsBySubSektor = SubSektor::whereHas('katalogs')
			->with(['katalogs' => function($query) {
				$query->with(['products', 'subSektor'])
					  ->withCount('views')
					  ->orderBy('created_at', 'desc')
					  ->take(4); // 4 katalog per sub sektor
			}])
			->take(3) // Show 3 sub sektors on dashboard
			->get();

		return view('pelaku-ekraf.dashboard', compact('pelakuEkraf', 'stats', 'categories', 'products', 'latestProducts', 'notifications', 'katalogsBySubSektor','totalViews',
        'viewsThisMonth',
        'viewsToday',
        'topViewedKatalogs',
        'deviceStats',
        'dailyViews'));
	}
}

