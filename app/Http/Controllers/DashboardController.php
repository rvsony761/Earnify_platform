<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $referrals = $user->referrals()->latest()->get();
        return view('dashboard.index', compact('user', 'referrals'));
    }
}
