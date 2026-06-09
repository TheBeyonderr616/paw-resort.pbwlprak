@extends('layouts.app')

@section('title', 'Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page {
        width: 80vw;
        max-width: none;
        margin: 0 auto;
        padding: 40px 20px;
    }
    @media(max-width: 768px) {
        .dashboard-page { width: 95vw; padding: 20px 10px; }
        .welcome-banner { padding: 25px 20px; border-radius: 20px; }
        .welcome-banner h2 { font-size: 1.6rem; }
        .menu-tile { padding: 20px 10px; border-radius: 20px; }
        .menu-tile .tile-emoji { font-size: 2.5rem; }
        .menu-tile h4 { font-size: 1.2rem; }
        .menu-tile p { font-size: 0.95rem; }
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--paw-brown), #e8953a);
        border-radius: 26px;
        padding: 34px 28px;
        color: #fff;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(0,0,0,0.10);
    }
    .welcome-banner h2 {
        font-family: 'Baloo 2', cursive;
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0 0 8px;
    }
    .welcome-banner p {
        margin: 0;
        opacity: 0.92;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .welcome-banner .paw-deco {
        position: absolute;
        right: -10px;
        top: -10px;
        font-size: 110px;
        opacity: 0.15;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .menu-tile {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 30px;
        padding: 36px 26px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .menu-tile:hover {
        border-color: var(--paw-brown);
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.09);
    }
    .menu-tile .tile-emoji {
        font-size: 4.6rem;
        margin-bottom: 16px;
        display: block;
    }
    .menu-tile h4 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0 0 10px;
    }
    .menu-tile p {
        font-size: 1.15rem;
        color: #6f624f;
        font-weight: 700;
        margin: 0;
    }

    .paw-card {
        background: #fff;
        border-radius: 30px;
        padding: 36px;
        border: 2px solid var(--paw-border);
        box-shadow: 0 10px 28px rgba(0,0,0,0.05);
    }

    .pet-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 22px;
        border-radius: 22px;
        background: var(--paw-cream);
        margin-bottom: 16px;
        transition: 0.2s;
    }
    .pet-item:hover {
        transform: scale(1.01);
        background: #fff3e6;
    }
    .pet-item span {
        font-size: 3rem;
    }
    .pet-name { font-weight: 800; font-size: 1.35rem; }
    .pet-breed { font-size: 1.05rem; color: #7a6a58; }

    @media(min-width: 900px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="dashboard-page">

    <div class="welcome-banner">
        <span class="paw-deco">🐾</span>
        <h2>Hi, {{ Auth::user()->name }}! 👋</h2>
        <p>Welcome back to PawResort!</p>
        <p style="font-size:0.95rem; margin-top:8px;">We take care of your pets with love 💛</p>
    </div>

    <div class="menu-grid">
        <a href="{{ route('user.booking') }}" class="menu-tile">
            <span class="tile-emoji">🐰</span>
            <h4>Booking</h4>
            <p>Book care service</p>
        </a>
        <a href="{{ route('user.payment') }}" class="menu-tile">
            <span class="tile-emoji">💳</span>
            <h4>Payment</h4>
            <p>Easy transaction</p>
        </a>
        <a href="{{ route('pawckage') }}" class="menu-tile">
            <span class="tile-emoji">😺</span>
            <h4>Pawckage</h4>
            <p>Choose service</p>
        </a>
        <a href="{{ route('user.register-pet') }}" class="menu-tile">
            <span class="tile-emoji">🐕</span>
            <h4>Register Pet</h4>
            <p>Add new pet</p>
        </a>
    </div>

    <div class="paw-card">
        <h6 style="color:var(--paw-brown); font-weight:800; margin-bottom:14px; font-size:1.1rem;">
            🐾 Your Pets
        </h6>

        @if(isset($pets) && count($pets) > 0)
            @foreach($pets as $pet)
                <div class="pet-item">
                    <span style="font-size:2.2rem;">
                        {{ $pet->type === 'dog' ? '🐕' : ($pet->type === 'cat' ? '🐱' : '🐹') }}
                    </span>
                    <div>
                        <div class="pet-name">{{ $pet->name }}</div>
                        <div class="pet-breed">{{ $pet->breed }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align:center; opacity:0.6; padding:16px;">
                <p style="margin:0; font-size:1rem;">No pets registered yet.</p>
                <a href="{{ route('user.register-pet') }}"
                style="color:var(--paw-brown); font-weight:700; font-size:0.95rem;">
                + Register your pet
                </a>
            </div>
        @endif
    </div>

</div>
</div>
@endsection