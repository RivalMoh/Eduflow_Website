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
    
    <h2 class="auth-title">Create new password</h2>
    <p class="auth-subtitle">Enter your new password below</p>
    
    <form method="POST" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        
        <input type="hidden" name="token" value="{{ $token }}">
        
        <!-- Email (hidden) -->
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
        
        <!-- New Password -->
        <div class="form-group">
            <label for="password" class="form-label">New Password</label>
            <div class="relative">
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    class="form-input pl-10 @error('password') border-red-500 @enderror" 
                    placeholder="••••••••"
                    required 
                    autocomplete="new-password"
                    autofocus
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                    <i class="far fa-eye text-gray-400 hover:text-gray-500"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
        </div>
        
        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password-confirm" class="form-label">Confirm New Password</label>
            <div class="relative">
                <input 
                    id="password-confirm" 
                    type="password" 
                    name="password_confirmation" 
                    class="form-input pl-10" 
                    placeholder="••••••••"
                    required 
                    autocomplete="new-password"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password-confirm')">
                    <i class="far fa-eye text-gray-400 hover:text-gray-500"></i>
                </button>
            </div>
        </div>
        
        <button type="submit" class="btn-primary w-full mt-8">
            <i class="fas fa-sync-alt mr-2"></i>
            Reset Password
        </button>
    </form>
    
    <p class="auth-footer">
        Remember your password? 
        <a href="{{ route('login') }}" class="font-medium">Sign in</a>
    </p>
</div>

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = event.currentTarget.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
