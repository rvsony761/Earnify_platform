<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showinvestment()
    {
        return view('dashboard.investment');
    }
    public function showRegister(Request $request)
    {   
        $referralCode = $request->query('ref');
        $referralUser = null;
        $user = User::where('referral_code', $referralCode)->first();
        if ($referralCode) 
        {
        $referralUser = User::where('referral_code', $referralCode)->first();
        }
        return view('auth.register', compact('referralCode', 'referralUser'));
    }
    public function checkReferral(Request $request)
    {
        $referralCode = $request->input('referral_code');
        $user = User::where('referral_code', $referralCode)->first();
    
        if ($user) {
            return response()->json(['status' => true, 'name' => $user->name]);
        } else {
            return response()->json(['status' => false, 'message' => 'No User Found']);
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ];
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $referredBy = null;
    
        if (!empty($request->referral_code)) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }
        $newReferralCode = strtoupper(Str::random(8));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $referredBy,
            'referral_code' => $newReferralCode,
        ]);
         if ($referredBy) {
            $referrer = User::find($referredBy);
            $referrer->updateEarnings();
        }

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('rohit', 'Registration successful!');
    }

    public function showlogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials=$request->validate(
        [
            "email"=> "email|required|exists:users,email",
            "password"=> "required",
        ]);
        if(Auth::attempt($credentials, $request->boolean('remember'))) 
        {   
            $request->session()->regenerate();
            $user=auth()->user();
            if ($user->is_admin) 
            {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome SuperUser check your Earnings');
            } 
            else 
            {
                return redirect()->route('user.dashboard')->with('rohit', 'Login Succesfully!');
            }
        } 
        else
        {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',])->onlyInput('email');;
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
