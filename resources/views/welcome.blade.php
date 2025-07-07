@extends('layouts.app')

@section('title', 'Welcome to Earning Platform')

@section('content')
<div class="text-center py-20">
    <h1 class="text-4xl font-bold text-primary-600 mb-4">Welcome to Earning Platform</h1>
    <p class="text-gray-600 mb-8 text-lg max-w-2xl mx-auto">Invite friends, refer others, and start earning ₹100 for every successful referral you make. It's fast, secure, and rewarding!</p>

    <div class="flex justify-center space-x-4 mb-12">
        <a href="{{ route('user.login') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">Login</a>
        <a href="{{ route('user.register') }}" class="border border-primary-600 text-primary-600 px-6 py-3 rounded-lg hover:bg-primary-600 hover:text-white transition">Register</a>
    </div>

    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-primary-600 mb-2">Earn ₹100/Referral</h3>
            <p class="text-gray-600 text-sm">Every time your friend signs up using your referral link, you earn ₹100 directly.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-primary-600 mb-2">Quick Registration</h3>
            <p class="text-gray-600 text-sm">Sign up and get started within minutes. Share your referral link instantly!</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-primary-600 mb-2">Secure & Transparent</h3>
            <p class="text-gray-600 text-sm">Your data is safe. Track your referrals and earnings anytime.</p>
        </div>
    </div>
</div>
@endsection

