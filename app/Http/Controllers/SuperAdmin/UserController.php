<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();

        $restaurants = Restaurant::whereIn('owner_id', $admins->pluck('_id'))
            ->get()
            ->keyBy(fn($r) => (string) $r->owner_id);

        return view('superadmin.users.index', compact('admins', 'restaurants'));
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            return back()->with('error', 'Cannot reset password for this account type.');
        }

        $tempPassword = Str::random(10);
        $user->update(['password' => Hash::make($tempPassword)]);

        return back()->with('success', "Password reset for {$user->email}. New temporary password: {$tempPassword} (share this with the user directly — it won't be shown again).");
    }

    public function toggleBan($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            return back()->with('error', 'Cannot ban this account type.');
        }

        $user->update(['is_banned' => !$user->is_banned]);

        return back()->with('success', $user->is_banned ? 'Account banned.' : 'Account unbanned.');
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            return back()->with('error', 'Can only impersonate restaurant admins.');
        }

        // Remember who the real super-admin is, so we can switch back later
        session(['impersonator_id' => auth()->id()]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', "Now viewing as {$user->name}.");
    }

    public function stopImpersonating()
    {
        $impersonatorId = session('impersonator_id');

        if (!$impersonatorId) {
            return redirect()->route('login');
        }

        $superAdmin = User::findOrFail($impersonatorId);
        session()->forget('impersonator_id');

        Auth::login($superAdmin);

        return redirect()->route('superadmin.users')->with('success', 'Returned to your super-admin account.');
    }
}