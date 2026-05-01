@extends('layouts.app')

@section('title', 'Admin Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page { padding: 24px 16px; }
    .welcome-banner {
        background: linear-gradient(135deg, #5b8fa8, #e8953a); 
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
        padding: 24px 16px; 
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s;
    }
    .menu-tile:hover {
        border-color: #a87b5b;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px var(--paw-shadow);
        color: var(--paw-dark);
    }
    .menu-tile .tile-emoji { font-size: 3rem; margin-bottom: 12px; display: block; }
    .menu-tile h4 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.2rem;
        font-weight: 700;
        color: #a87b5b;
        margin: 0 0 4px;
    }
    .menu-tile p { font-size: 0.85rem; color: #888; font-weight: 600; margin: 0; }

    @media(min-width: 600px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); max-width: 600px; margin: 0 auto; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="dashboard-page">

    <div class="welcome-banner">
        <span class="paw-deco">👑</span>
        <h2>Hi, {{ Auth::user()->name }}! 👋</h2>
        <p>Welcome to Admin Control Panel</p>
        <p style="font-size:0.8rem; margin-top:6px; opacity:0.8;">Manage sanctuary units and transactions</p>
    </div>

    <div class="menu-grid">
        <a href="{{ route('admin.cage') }}" class="menu-tile">
            <span class="tile-emoji">🏠</span>
            <h4>Cage Monitor</h4>
            <p>Manage sanctuary units!</p>
        </a>
        
        <a href="{{ route('admin.payment') }}" class="menu-tile">
            <span class="tile-emoji">💳</span>
            <h4>Payment Validation</h4>
            <p>Validate transactions!</p>
        </a>
    </div>

</div>
</div>
@endsection