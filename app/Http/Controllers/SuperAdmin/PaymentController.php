<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Restaurant;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();

        // Build a quick lookup so we don't hit the DB once per row in the view
        $restaurantIds = $payments->pluck('restaurant_id')->unique()->values();
        $restaurants = Restaurant::whereIn('_id', $restaurantIds)->get()->keyBy(fn($r) => (string) $r->_id);

        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $revenueThisMonth = Payment::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('amount');
        $totalTransactions = Payment::count();
        $completedCount = Payment::where('status', 'completed')->count();
        $failedCount = Payment::where('status', 'failed')->count();
        $pendingCount = Payment::where('status', 'pending')->count();

        return view('superadmin.payments.index', compact(
            'payments', 'restaurants', 'totalRevenue', 'revenueThisMonth',
            'totalTransactions', 'completedCount', 'failedCount', 'pendingCount'
        ));
    }
}