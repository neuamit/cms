<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'admin')->count();
        $totalActiveMenus = Restaurant::where('is_active', true)->count();
        $totalRestaurants = Restaurant::count();

        return view('superadmin.dashboard', compact('totalUsers', 'totalActiveMenus', 'totalRestaurants'));
    }
}