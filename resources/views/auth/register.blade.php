@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Create Account</h2>
    
    <form method="POST" action="{{route('user.register_store')}}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name " required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" Enter Email Address"required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label for="referral_code" class="block text-sm font-medium text-gray-700 mb-2">Referral Code (Optional)</label>
            <input type="text" id="referral_code" name="referral_code" value="{{ $referralCode ?? old('referral_code') }}" placeholder="Enter Referral Code"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('referral_code') border-red-500 @enderror">
            @error('referral_code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p id="referral-message" class="mt-1 text-sm">
                @if($referralUser)
                    <span class="text-green-600 text-m">Referred By: {{ $referralUser->name }}</span>
                @endif
            </p>
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-200">
            Create Account
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="{{route('user.login')}}" class="text-primary-600 hover:text-primary-500">Sign in</a>
    </p>
</div>
<!-- Code to show Real time name error if referral code change -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const referralInput = document.getElementById('referral_code');
    const message = document.getElementById('referral-message');

    referralInput.addEventListener('input', function () {
        const code = this.value.trim();

        if (code === '') {
            message.textContent = '';
            message.className = 'mt-1 text-sm';
            return;
        }

        fetch("{{ route('check.referral') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ referral_code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                message.textContent = 'Referred By: ' + data.name;
                message.className = 'mt-1 text-sm text-green-600';
            } else {
                message.textContent = data.message;
                message.className = 'mt-1 text-sm text-red-600';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>


@endsection
