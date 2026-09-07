<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::orderBy('months')->get();
        return view('superadmin.plans.index', compact('plans'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'label' => 'required|string|max:50',
            'amount' => 'required|numeric|min:1',
        ]);

        PricingPlan::findOrFail($id)->update($data);

        return back()->with('success', 'Plan updated.');
    }
}