@extends('layouts.app')

@section('title', 'Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page { padding: 24px 16px; }
    .welcome-banner {
        background: linear-gradient(135deg, var(--paw-brown), #e8953a);
        border-radius: 20px;
        padding: 24px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner h2 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0 0 4px;
    }
    .welcome-banner p { margin: 0; opacity: 0.9; font-weight: 600; }
    .welcome-banner .paw-deco {
        position: absolute;
        right: -10px;
        top: -10px;
        font-size: 80px;
        opacity: 0.2;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 24px;
    }
    .menu-tile {
        background: #fff;
        border: 2.5px solid var(--paw-border);
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s;
    }
    .menu-tile:hover {
        border-color: var(--paw-brown);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px var(--paw-shadow);
        color: var(--paw-dark);
    }
    .menu-tile .tile-emoji { font-size: 2.5rem; margin-bottom: 8px; display: block; }
    .menu-tile h4 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--paw-brown);
        margin: 0 0 4px;
    }
    .menu-tile p { font-size: 0.75rem; color: #888; font-weight: 600; margin: 0; }

    @media(min-width: 600px) {
        .menu-grid { grid-template-columns: repeat(4, 1fr); }
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
        <p style="font-size:0.8rem; margin-top:6px; opacity:0.8;">We take care of your Pets!</p>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid">
        <a href="{{ route('user.booking') }}" class="menu-tile">
            <span class="tile-emoji">🐰</span>
            <h4>Booking</h4>
            <p>Let's have fun!</p>
        </a>
        <a href="{{ route('user.payment') }}" class="menu-tile">
            <span class="tile-emoji">💳</span>
            <h4>Payment</h4>
            <p>Comfort your pets</p>
        </a>
        <a href="{{ route('pawckage') }}" class="menu-tile">
            <span class="tile-emoji">😺</span>
            <h4>Pawckage</h4>
            <p>Choose treatment</p>
        </a>
        <a href="{{ route('user.register-pet') }}" class="menu-tile">
            <span class="tile-emoji">🐕</span>
            <h4>Register Pet</h4>
            <p>Add your pet</p>
        </a>
    </div>

    <!-- Quick Info -->
    <div class="paw-card">
        <h6 class="paw-font fw-bold mb-3" style="color:var(--paw-brown);">🐾 Your Pets</h6>
        @if(isset($pets) && count($pets) > 0)
            @foreach($pets as $pet)
            <div class="d-flex align-items-center gap-3 mb-2 p-2" style="background:var(--paw-cream); border-radius:12px;">
                <span style="font-size:1.8rem;">{{ $pet->type === 'dog' ? '🐕' : ($pet->type === 'cat' ? '🐱' : '🐹') }}</span>
                <div>
                    <div style="font-weight:800; font-size:0.95rem;">{{ $pet->name }}</div>
                    <div style="font-size:0.8rem; color:#888;">{{ $pet->breed }}</div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-3" style="opacity:0.6;">
                <p style="margin:0; font-size:0.9rem;">No pets registered yet.</p>
                <a href="{{ route('user.register-pet') }}" style="color:var(--paw-brown); font-weight:700; font-size:0.85rem;">+ Register your pet</a>
            </div>
        @endif
    </div>

</div>
</div>
@endsection