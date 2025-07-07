@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">👥</div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Users</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $total_users}}</p>
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
                            <p class="text-2xl font-bold text-green-900">₹{{ number_format($totalEarnings, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-2xl">🔗</div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Total Referrals</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $totalReferrals }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">All Users</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referred By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrals</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">{{ $user->referral_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($user->referrer)
                                        <div>
                                            <div class="font-medium">{{ $user->referrer->name }}</div>
                                            <div class="text-xs">{{ $user->referrer->referral_code }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Direct signup</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->referrals_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">₹{{ number_format($user->earnings, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- Top Earners -->
             <div class="bg-white">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🏆 Top 3 Earners</h3>
            
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrals</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topusers as $user)
                            <tr>
                                <td>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->referrals_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">₹{{ number_format($user->earnings, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
             </div>


             <!-- New Users shows -->
              <div class="bg-white mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 text-green-600">Today's New Users</h3>
            
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referred By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($newusers as $user)
                            <tr>
                                <td>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($user->referrer)
                                        <div>
                                            <div class="font-medium">{{ $user->referrer->name }}</div>
                                            <div class="text-xs">{{ $user->referrer->referral_code }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Direct signup</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
             </div>

        </div>
    </div>
</div>
@endsection
