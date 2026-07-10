<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function edit()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->first();
        return view('admin.restaurant.edit', compact('restaurant'));
    }

    public function update(Request $request)
{
    $data = $request->validate([
        'name'             => 'required|string|max:255',
        'address'          => 'nullable|string|max:255',
        'phone'            => 'nullable|string|max:20',
        'wifi_password'    => 'nullable|string|max:100',
        'opening_hours'    => 'nullable|string|max:100',
        'facebook_url'     => 'nullable|url',
        'instagram_url'    => 'nullable|url',
        'tripadvisor_url'  => 'nullable|url',
        'logo'             => 'nullable|image|max:2048',
        'cover_image'      => 'nullable|image|max:4096',
    ]);

    $restaurant = Restaurant::where('owner_id', auth()->id())->first();

    if (!$restaurant) {
        $slug = Str::slug($data['name']);
        $original = $slug;
        $i = 1;
        while (Restaurant::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }
        $data['slug'] = $slug;
        $data['owner_id'] = auth()->id();
        $data['is_active'] = true;
    }

    if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store('logos', 'public');
    }
    if ($request->hasFile('cover_image')) {
        $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
    }

    if ($restaurant) {
        $restaurant->update($data);
    } else {
        $restaurant = Restaurant::create($data);
    }

    return redirect()->route('admin.restaurant.edit')
        ->with('success', 'Restaurant profile saved.');
}
}