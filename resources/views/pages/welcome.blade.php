@extends('layouts.app')

@section('title', 'PawResort - We take care of your Pets!')

@push('styles')
<style>
    .hero-section {
        min-height: 65vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 50px 24px 24px;
        position: relative;
    }
    .hero-title {
        font-family: 'Baloo 2', cursive;
        font-size: clamp(2.8rem, 7vw, 4.5rem);
        color: var(--paw-brown);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 10px;
    }
    .hero-subtitle {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--paw-teal);
        margin-bottom: 36px;
    }
    .login-bone-btn {
        background: #d9c4a8;
        color: var(--paw-dark);
        font-family: 'Baloo 2', cursive;
        font-size: 1.5rem;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 14px 70px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        margin-top: 18px;
        box-shadow: 0 4px 12px var(--paw-shadow);
        transition: all .2s;
    }
    .login-bone-btn:hover {
        background: var(--paw-brown);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Feature menu cards */
    .menu-section { padding: 24px; }
    .menu-card {
        background: var(--paw-cream);
        border: 2.5px solid var(--paw-border);
        border-radius: 24px;
        padding: 28px 28px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s;
        overflow: hidden;
        position: relative;
        min-height: 120px;
    }
    .menu-card:hover {
        border-color: var(--paw-brown);
        transform: translateX(5px);
        box-shadow: 0 8px 24px var(--paw-shadow);
        color: var(--paw-dark);
    }
    .menu-card-text h3 {
        font-family: 'Baloo 2', cursive;
        font-size: 2rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0 0 6px;
    }
    .menu-card-text p {
        font-size: 1rem;
        font-weight: 600;
        color: #888;
        margin: 0;
    }
    .menu-card-img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 64px;
        line-height: 1;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-14px); }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    <!-- Hero -->
    <div class="hero-section">
        <p style="font-weight:700; font-size:1.15rem; color:var(--paw-dark);">Welcome to</p>
        <h1 class="hero-title">PawResort!</h1>
        <p class="hero-subtitle">We take care of your Pets!</p>

        <div style="position:relative; width:min(280px,80vw); height:200px; margin:0 auto 10px;">
            <div style="font-size: clamp(90px, 28vw, 145px); line-height:1; text-align:center; animation: float 3s ease-in-out infinite; display:block;">🐶</div>
            <div style="background: #5b8fa8; height: 58px; border-radius: 14px 14px 0 0; position:absolute; bottom:0; left:0; right:0; display:flex; align-items:center; justify-content:center;">
                <a href="{{ route('login') }}" class="login-bone-btn">
                    🦴 Login
                </a>
            </div>
        </div>
    </div>

    <!-- Menu Cards (only visible when logged in) -->
    @auth
    <div class="menu-section">

        @if(Auth::user()->role === 'admin')
            <!-- Admin Menu -->
            <a href="{{ route('admin.cage') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Cage Monitor</h3>
                    <p>Manage sanctuary units!</p>
                </div>
                <span class="menu-card-img">🏠</span>
            </a>
            <a href="{{ route('admin.payment') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Payment</h3>
                    <p>Validate transactions!</p>
                </div>
                <span class="menu-card-img">💳</span>
            </a>
        @else
            <!-- User Menu -->
            <a href="{{ route('user.booking') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Booking</h3>
                    <p>Let's have fun with us!</p>
                </div>
                <span class="menu-card-img">🐰</span>
            </a>
            <a href="{{ route('user.payment') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Payment</h3>
                    <p>Help us to comfort your pets!</p>
                </div>
                <span class="menu-card-img">🐱</span>
            </a>
            <a href="{{ route('pawckage') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Pawckage</h3>
                    <p>Choose purrfect treatment for your pets!</p>
                </div>
                <span class="menu-card-img">😺</span>
            </a>
            <a href="{{ route('user.register-pet') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Register Pet</h3>
                    <p>Do your other pets wanna play with us too?</p>
                </div>
                <span class="menu-card-img">🐕</span>
            </a>
        @endif
    </div>
    @endauth

    @guest
    <div class="menu-section">
        <div class="text-center py-5" style="opacity:0.65;">
            <p style="font-weight:700; font-size:1.1rem;">Please login to access features 🐾</p>
            <a href="{{ route('login') }}" class="btn-paw btn px-5" style="font-size:1.1rem;">Login Now</a>
        </div>
    </div>
    @endguest

</div>
@endsection