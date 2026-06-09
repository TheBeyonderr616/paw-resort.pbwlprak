@extends('layouts.app')

@section('title', 'Admin Dashboard - PawResort')

@push('styles')
<style>
    .dashboard-page { padding: 32px 20px; }
    @media(max-width: 768px) {
        .dashboard-page { padding: 20px 15px; }
        .welcome-banner { padding: 25px 20px; border-radius: 20px; }
        .welcome-banner h2 { font-size: 1.6rem; }
        .menu-tile { padding: 20px 10px; border-radius: 20px; }
        .menu-tile .tile-emoji { font-size: 2.5rem; }
        .menu-tile h4 { font-size: 1.1rem; }
    }
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
    @media(min-width: 768px) {
        .menu-grid { grid-template-columns: repeat(4, 1fr); }
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

    .stats-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }
    @media(min-width: 768px) {
        .stats-row { grid-template-columns: repeat(4, 1fr); }
    }
    .stat-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #fef4e8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-info .label { font-size: 0.85rem; font-weight: 800; color: #888; }
    .stat-info .value { font-family: 'Baloo 2', cursive; font-size: 1.4rem; font-weight: 800; color: var(--paw-brown); }
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

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <div class="label">Total Users</div>
                <div class="value">{{ $stats['users'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🐾</div>
            <div class="stat-info">
                <div class="label">Total Pets</div>
                <div class="value">{{ $stats['pets'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <div class="label">Active Bookings</div>
                <div class="value">{{ $stats['bookings'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <div class="label">Pending Payments</div>
                <div class="value">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>

    <div class="menu-grid">
        <a href="{{ route('admin.user.index') }}" class="menu-tile">
            <span class="tile-emoji">👥</span>
            <h4>Manage Users</h4>
            <p>Admin & Customers</p>
        </a>

        <a href="{{ route('admin.pet.index') }}" class="menu-tile">
            <span class="tile-emoji">🐾</span>
            <h4>Manage Pets</h4>
            <p>All client animals</p>
        </a>

        <a href="{{ route('admin.cage.index') }}" class="menu-tile">
            <span class="tile-emoji">🏠</span>
            <h4>Cage Units</h4>
            <p>Manage sanctuary status</p>
        </a>

        <a href="{{ route('admin.payment') }}" class="menu-tile">
            <span class="tile-emoji">💳</span>
            <h4>Payments</h4>
            <p>Validate transactions</p>
        </a>
    </div>

</div>
</div>
@endsection