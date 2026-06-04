<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagerController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders.items']);

        $totalSpending = $user->orders()
            ->where('status', 'paid')
            ->sum('total');

        $totalOrders = $user->orders()->count();

        return view('admin.users.show', compact('user', 'totalSpending', 'totalOrders'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
