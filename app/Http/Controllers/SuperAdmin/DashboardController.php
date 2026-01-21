<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use App\Models\BranchStore;
use App\Models\Product;
use App\Models\Voucher;

class DashboardController extends Controller
{
    public function index()
    {
        $viewsPerDay = News::selectRaw('DATE(created_at) as date, SUM(views) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topNews = News::where('views', '>', 0)->orderByDesc('views')->take(5)->get();

        return view('super-admin.dashboard', [
            'totalUsers' => User::count(),
            'totalBranches' => BranchStore::count(),
            'totalProducts' => Product::count(),
            'totalVouchers' => Voucher::count(),
            'totalNews' => News::count(),
            'publishedNews' => News::where('status','published')->count(),
            'draftNews' => News::where('status','draft')->count(),
            'todayNews' => News::whereDate('created_at', today())->count(),
            'totalViews' => News::sum('views'),
            'viewsPerDay' => $viewsPerDay,
            'topNews' => $topNews
        ]);
    }
}
