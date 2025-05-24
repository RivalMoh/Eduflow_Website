@extends('layouts.auth')

@section('title', 'Reset Password - EduFlow')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <a href="{{ route('home') }}">
            <div class="w-16 h-16 rounded-lg bg-indigo-100 flex items-center justify-center mb-2">
                <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-indigo-600">EduFlow</h1>
        </a>
    </div>
    
    <h2 class="auth-title">Reset your password</h2>
    <p class="auth-subtitle">Enter your email and we'll send you a link to reset your password</p>
    
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 rounded-lg text-green-700">
            {{ session('status') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('password.email') }}" class="mt-6">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <div class="relative">
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="form-input pl-10 @error('email') border-red-500 @enderror" 
                    placeholder="you@example.com"
                    required 
                    autocomplete="email" 
                    autofocus
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="btn-primary w-full mt-8">
            <i class="fas fa-paper-plane mr-2"></i>
            Send Reset Link
        </button>
    </form>
    
    <p class="auth-footer">
        Remember your password? 
        <a href="{{ route('login') }}" class="font-medium">Sign in</a>
    </p>
</div>
@endsection
