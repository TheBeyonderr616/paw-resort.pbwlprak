@extends('layouts.app')

@section('title', 'Login - PawResort')

@push('styles')
<style>
    .auth-page {
        min-height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .auth-box {
        width: 100%;
        max-width: 380px;
        text-align: center;
    }
    .auth-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--paw-teal);
        margin-bottom: 4px;
    }
    .auth-brand {
        font-family: 'Baloo 2', cursive;
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--paw-brown);
        line-height: 1;
        margin-bottom: 4px;
    }
    .auth-tagline {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--paw-teal);
        margin-bottom: 20px;
    }
    .auth-pet-img {
        font-size: 90px;
        display: block;
        margin: 0 auto 10px;
        animation: float 3s ease-in-out infinite;
    }
    .auth-form-box {
        background: #ffffffcc;
        border-radius: 24px;
        padding: 28px 24px;
        border: 2px solid var(--paw-border);
        backdrop-filter: blur(8px);
    }
    .input-group-paw {
        position: relative;
        margin-bottom: 14px;
    }
    .input-group-paw .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 0.9rem;
    }
    .input-group-paw input {
        padding-left: 42px !important;
    }
    .auth-link {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--paw-dark);
        margin-top: 12px;
    }
    .auth-link a { color: var(--paw-brown); text-decoration: none; font-weight: 800; }
    .auth-link a:hover { text-decoration: underline; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <div class="auth-title">Login to</div>
        <div class="auth-brand">PawResort!</div>
        <div class="auth-tagline">We take care of your Pets!</div>

        <span class="auth-pet-img">🐹</span>

        <div class="auth-form-box">
            @if($errors->any())
                <div class="alert paw-alert alert-danger mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-at"></i></span>
                    <input type="email" name="email" class="paw-input" placeholder="Email"
                        value="{{ old('email') }}" required autofocus>
                </div>

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="paw-input" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-paw btn w-100 mt-2">Login</button>
            </form>

            <p class="auth-link mt-3 mb-0">
                Don't have account? click <a href="{{ route('register') }}">here</a>
            </p>
        </div>
    </div>
</div>
@endsection