<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('super-admin.dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'totalBranches' => \App\Models\BranchStore::count(),
            'totalProducts' => \App\Models\Product::count(),
            'totalVouchers' => \App\Models\Voucher::count(),
        ]);
    }
}
