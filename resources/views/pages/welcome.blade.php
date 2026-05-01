@extends('layouts.app')

@section('title', 'PawResort - We take care of your Pets!')

@push('styles')
<style>
    .hero-section {
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px 20px;
        position: relative;
    }
    .hero-title {
        font-family: 'Baloo 2', cursive;
        font-size: clamp(2rem, 6vw, 3.5rem);
        color: var(--paw-brown);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 6px;
    }
    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--paw-teal);
        margin-bottom: 30px;
    }
    .hero-dog {
        width: min(280px, 80vw);
        margin: 0 auto;
        display: block;
        animation: float 3s ease-in-out infinite;
    }
    .login-bone-btn {
        background: #d9c4a8;
        color: var(--paw-dark);
        font-family: 'Baloo 2', cursive;
        font-size: 1.3rem;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 12px 60px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        margin-top: 16px;
        box-shadow: 0 4px 12px var(--paw-shadow);
        transition: all .2s;
    }
    .login-bone-btn:hover {
        background: var(--paw-brown);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Feature menu cards */
    .menu-section { padding: 20px; }
    .menu-card {
        background: var(--paw-cream);
        border: 2.5px solid var(--paw-border);
        border-radius: 22px;
        padding: 22px 24px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s;
        overflow: hidden;
        position: relative;
        min-height: 100px;
    }
    .menu-card:hover {
        border-color: var(--paw-brown);
        transform: translateX(4px);
        box-shadow: 0 6px 20px var(--paw-shadow);
        color: var(--paw-dark);
    }
    .menu-card-text h3 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0 0 4px;
    }
    .menu-card-text p {
        font-size: 0.85rem;
        font-weight: 600;
        color: #888;
        margin: 0;
    }
    .menu-card-img {
        width: 90px;
        height: 90px;
        object-fit: contain;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    <!-- Hero -->
    <div class="hero-section">
        <p style="font-weight:700; font-size:1rem; color:var(--paw-dark);">Welcome to</p>
        <h1 class="hero-title">PawResort!</h1>
        <p class="hero-subtitle">We take care of your Pets!</p>

        <!-- Dog illustration placeholder (using emoji + CSS art) -->
        <div style="position:relative; width:min(260px,80vw); height:180px; margin:0 auto 10px;">
            <div style="font-size: clamp(80px, 25vw, 130px); line-height:1; text-align:center; animation: float 3s ease-in-out infinite; display:block;">🐶</div>
            <div style="background: #5b8fa8; height: 50px; border-radius: 12px 12px 0 0; position:absolute; bottom:0; left:0; right:0; display:flex; align-items:center; justify-content:center;">
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
                <span class="menu-card-img" style="font-size:60px;">🏠</span>
            </a>
            <a href="{{ route('admin.payment') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Payment</h3>
                    <p>Validate transactions!</p>
                </div>
                <span class="menu-card-img" style="font-size:60px;">💳</span>
            </a>
        @else
            <!-- User Menu -->
            <a href="{{ route('user.booking') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Booking</h3>
                    <p>Let's have fun with us!</p>
                </div>
                <span class="menu-card-img" style="font-size:60px;">🐰</span>
            </a>
            <a href="{{ route('user.payment') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Payment</h3>
                    <p>Help us to comfort your pets!</p>
                </div>
                <span class="menu-card-img" style="font-size:60px;">🐱</span>
            </a>
            <a href="{{ route('pawckage') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Pawckage</h3>
                    <p>Choose purrfect treatment for your pets!</p>
                </div>
                <span class="menu-card-img" style="font-size:60px;">😺</span>
            </a>
            <a href="{{ route('user.register-pet') }}" class="menu-card">
                <div class="menu-card-text">
                    <h3>Register</h3>
                    <p>Do your other pets wanna play with us too?</p>
                </div>
                <span class="menu-card-img" style="font-size:60px;">🐕</span>
            </a>
        @endif
    </div>
    @endauth

    @guest
    <div class="menu-section">
        <div class="text-center py-4" style="opacity:0.6;">
            <p style="font-weight:700;">Please login to access features 🐾</p>
            <a href="{{ route('login') }}" class="btn-paw btn px-4">Login Now</a>
        </div>
    </div>
    @endguest

</div>
@endsection