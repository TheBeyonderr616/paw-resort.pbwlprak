@extends('layouts.app')

@section('title', 'Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page {
        padding: 28px 16px;
    }

    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, var(--paw-brown), #e8953a);
        border-radius: 24px;
        padding: 28px 22px;
        color: #fff;
        margin-bottom: 26px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .welcome-banner h2 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .welcome-banner p {
        margin: 0;
        opacity: 0.9;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .welcome-banner .paw-deco {
        position: absolute;
        right: -10px;
        top: -10px;
        font-size: 90px;
        opacity: 0.15;
    }

    /* ===== MENU GRID ===== */
    .menu-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 26px;
    }

    .menu-tile {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 22px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .menu-tile:hover {
        border-color: var(--paw-brown);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .menu-tile .tile-emoji {
        font-size: 2.8rem;
        margin-bottom: 10px;
        display: block;
    }

    .menu-tile h4 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0 0 4px;
    }

    .menu-tile p {
        font-size: 0.8rem;
        color: #888;
        font-weight: 600;
        margin: 0;
    }

    /* ===== PET CARD ===== */
    .paw-card {
        background: #fff;
        border-radius: 22px;
        padding: 18px;
        border: 2px solid var(--paw-border);
        box-shadow: 0 6px 18px rgba(0,0,0,0.04);
    }

    .pet-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 14px;
        background: var(--paw-cream);
        margin-bottom: 10px;
        transition: 0.2s;
    }

    .pet-item:hover {
        transform: scale(1.01);
        background: #fff3e6;
    }

    .pet-name {
        font-weight: 800;
        font-size: 0.95rem;
    }

    .pet-breed {
        font-size: 0.8rem;
        color: #888;
    }

    @media(min-width: 600px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="dashboard-page">

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <span class="paw-deco">🐾</span>
        <h2>Hi, {{ Auth::user()->name }}! 👋</h2>
        <p>Welcome back to PawResort!</p>
        <p style="font-size:0.85rem; margin-top:6px;">We take care of your pets with love 💛</p>
    </div>

    <!-- Menu Grid -->
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

    <!-- PET SECTION -->
    <div class="paw-card">
        <h6 style="color:var(--paw-brown); font-weight:800; margin-bottom:12px;">
            🐾 Your Pets
        </h6>

        @if(isset($pets) && count($pets) > 0)
            @foreach($pets as $pet)
                <div class="pet-item">
                    <span style="font-size:1.8rem;">
                        {{ $pet->type === 'dog' ? '🐕' : ($pet->type === 'cat' ? '🐱' : '🐹') }}
                    </span>
                    <div>
                        <div class="pet-name">{{ $pet->name }}</div>
                        <div class="pet-breed">{{ $pet->breed }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align:center; opacity:0.6; padding:10px;">
                <p style="margin:0; font-size:0.9rem;">No pets registered yet.</p>
                <a href="{{ route('user.register-pet') }}"
                   style="color:var(--paw-brown); font-weight:700; font-size:0.85rem;">
                   + Register your pet
                </a>
            </div>
        @endif
    </div>

</div>
</div>
@endsection