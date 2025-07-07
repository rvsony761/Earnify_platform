<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{   
    public function index()
    {   
        $baseQuery = User::where('is_admin', false);
        $users = (clone $baseQuery)
        ->with(['referrer', 'referrals'])
        ->withcount('referrals')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $total_users=(clone $baseQuery)->count();
        $totalEarnings = (clone $baseQuery)->sum('earnings');
        $totalReferrals = (clone $baseQuery)
                            ->whereNotNull('referred_by')->count();
        $topusers = User::withCount('referrals')
                ->where('is_admin', false)
                ->orderBy('earnings', 'desc')
                ->take(3)
                ->get();
        $newusers=User::where('is_admin', false)
                ->whereDate('created_at', today())
                ->get();
        return view('admin.index',compact('users','total_users','totalEarnings','totalReferrals','topusers','newusers'));

    }
    
}
