@extends('layouts.app')

@section('title', 'Sign In - PawResort')

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
        width: 80vw;
        max-width: 780px;
        text-align: center;
    }
    .auth-title { font-size:1.6rem; font-weight:700; color:var(--paw-teal); margin-bottom:6px; }
    .auth-brand { font-family:'Baloo 2',cursive; font-size:3.4rem; font-weight:800; color:var(--paw-brown); line-height:1; margin-bottom:6px; }
    .auth-tagline { font-size:1.4rem; font-weight:700; color:var(--paw-teal); margin-bottom:24px; }
    .auth-pet-img { font-size:110px; display:block; margin:0 auto 14px; animation:float 3s ease-in-out infinite; }
    .auth-form-box { background:#ffffffcc; border-radius:24px; padding:40px 36px; border:2px solid var(--paw-border); backdrop-filter:blur(8px); }
    .input-group-paw { position:relative; margin-bottom:18px; }
    .input-group-paw .input-icon { position:absolute; left:18px; top:50%; transform:translateY(-50%); color:#aaa; font-size:1.1rem; }
    .input-group-paw input { padding-left:50px !important; font-size:1.2rem; padding:18px 18px 18px 50px !important; }
    .btn-paw { font-size:1.25rem; padding:16px 20px; }
    .auth-link { font-size:1rem; font-weight:700; color:var(--paw-dark); margin-top:14px; }
    .auth-link a { color:var(--paw-brown); text-decoration:none; font-weight:800; }
    .auth-link a:hover { text-decoration:underline; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <div class="auth-title">Sign in to</div>
        <div class="auth-brand">PawResort!</div>
        <div class="auth-tagline">We take care of your Pets!</div>

        <span class="auth-pet-img">🐹</span>

        <div class="auth-form-box">
            @if($errors->any())
                <div class="alert paw-alert alert-danger mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-paw"></i></span>
                    <input type="text" name="name" class="paw-input" placeholder="Username"
                           value="{{ old('name') }}" required autofocus>
                </div>

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-at"></i></span>
                    <input type="email" name="email" class="paw-input" placeholder="Email"
                           value="{{ old('email') }}" required>
                </div>

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="paw-input" placeholder="Password" required>
                </div>

                <div class="input-group-paw">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password_confirmation" class="paw-input" placeholder="Confirm Password" required>
                </div>

                <button type="submit" class="btn-paw btn w-100 mt-2">Sign In</button>
            </form>

            <p class="auth-link mt-3 mb-0">
                Already have account? click <a href="{{ route('login') }}">here</a>
            </p>
        </div>
    </div>
</div>
@endsection