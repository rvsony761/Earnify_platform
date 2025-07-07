@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow mt-10">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">New Investment</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="#">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Investment Amount (₹)</label>
            <input type="number" name="amount" min="1" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary-500 @error('amount') border-red-500 @enderror"
                   placeholder="Enter amount">

            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded shadow transition duration-300">
            Invest Now
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" class="text-primary-600 hover:underline">← Back to Dashboard</a>
    </div>

</div>
@endsection
