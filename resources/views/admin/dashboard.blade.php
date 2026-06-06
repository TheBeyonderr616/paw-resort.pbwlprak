@extends('layouts.app')

@section('title', 'Admin Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page { padding: 32px 20px; }
    .welcome-banner {
        background: linear-gradient(135deg, #5b8fa8, #e8953a);
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
    .welcome-banner p { margin: 0; opacity: 0.92; font-weight: 600; font-size: 1.05rem; }
    .welcome-banner .paw-deco {
        position: absolute;
        right: -10px;
        top: -10px;
        font-size: 110px;
        opacity: 0.2;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 28px;
    }
    .menu-tile {
        background: #fff;
        border: 2.5px solid var(--paw-border);
        border-radius: 24px;
        padding: 30px 18px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: var(--paw-dark);
        transition: all .25s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .menu-tile:hover {
        border-color: #a87b5b;
        transform: translateY(-5px);
        box-shadow: 0 12px 28px var(--paw-shadow);
        color: var(--paw-dark);
    }
    .menu-tile .tile-emoji { font-size: 3.4rem; margin-bottom: 14px; display: block; }
    .menu-tile h4 {
        font-family: 'Baloo 2', cursive;
        font-size: 1.35rem;
        font-weight: 800;
        color: #a87b5b;
        margin: 0 0 6px;
    }
    .menu-tile p { font-size: 0.92rem; color: #888; font-weight: 600; margin: 0; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="dashboard-page">

    <div class="welcome-banner">
        <span class="paw-deco">👑</span>
        <h2>Hi, {{ Auth::user()->name }}! 👋</h2>
        <p>Welcome to Admin Control Panel</p>
        <p style="font-size:0.9rem; margin-top:8px; opacity:0.85;">Manage sanctuary units and transactions</p>
    </div>

    <div class="menu-grid">
        <a href="{{ route('admin.cage') }}" class="menu-tile">
            <span class="tile-emoji">🏠</span>
            <h4>Cage Monitor</h4>
            <p>View sanctuary status!</p>
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