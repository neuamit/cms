<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;

class HomeController extends Controller
{
    public function index(SubscriptionService $service)
    {
        $plans = $service->allPlans();
        return view('home', compact('plans'));
    }
}