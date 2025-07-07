@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if(session('rohit'))
<div id="flash-message" class="fixed top-5 right-5 z-50">
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between min-w-64">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('rohit') }}</span>
        </div>
    </div>
</div>

<script>
    // Auto-hide after 3 seconds
    setTimeout(() => {
        dismissFlash();
    }, 3000);

    function dismissFlash() {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => flash.remove(), 500);
        }
    }
</script>
@endif

<div class="space-y-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <!-- New Investment Button -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Welcome, {{ $user->name }}!</h1>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">👥</div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Referrals</p>
                            <p class="text-2xl font-bold text-blue-900">{{$user->total_referrals}}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">💰</div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Total Earnings</p>
                            <p class="text-2xl font-bold text-green-900">₹{{number_format($user->earnings, 2)}}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">🔗</div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Referral Code</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $user->referral_code}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referral Link -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Your Referral Link</h3>
                <div class="flex items-center space-x-2">
                    <input type="text" value="{{ $user->referral_link }}" readonly
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-white text-sm"
                        id="referralLink">
                
                    <button onclick="copyReferralLink(event)" 
                        class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 transition duration-200">
                        Copy
                    </button>
                
                    <div id="flash-message" 
                         class="hidden fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-600 border border-green-600 text-white px-6 py-3 rounded shadow-lg z-50 transition duration-300">
                        Referral Link Copied!
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Share this link to earn ₹100 for each person who registers!</p>
            </div>


            <!-- Recent Referrals -->
            @if($referrals->count() > 0)
            <div class="bg-white">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Referrals</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($referrals as $referral)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $referral->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $referral->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $referral->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">₹100</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <div class="text-4xl mb-4">🎯</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No referrals yet</h3>
                <p class="text-gray-600">Start sharing your referral link to earn money!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyReferralLink(event) {
    const linkInput = document.getElementById('referralLink');
    const referralLink = linkInput.value;

    navigator.clipboard.writeText(referralLink).then(() => {
        const button = event.target;
        const originalText = button.textContent;

        // Button Feedback (Optional)
        button.textContent = 'Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-primary-600');

        //  Show Flash Message (Top of Page)
        const flash = document.getElementById('flash-message');
        flash.classList.remove('hidden');

        setTimeout(() => {
            flash.classList.add('hidden');
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-primary-600');
        }, 2500);

    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}
</script>

@endsection
