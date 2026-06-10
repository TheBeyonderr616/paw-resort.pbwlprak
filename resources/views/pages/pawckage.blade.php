@extends('layouts.app')

@section('title', 'Pawckage - PawResort')

@push('styles')
<style>
    .pawckage-page { padding: 24px 16px; }
    .page-header { text-align: center; margin-bottom: 28px; }
    .page-subtitle { font-weight: 700; color: var(--paw-teal); font-size: 1rem; }
    .paw-title { font-family:'Baloo 2',cursive; font-size:3rem; font-weight:800; color:var(--paw-brown); margin:0; }
    .page-tagline { font-weight:700; color:var(--paw-teal); font-size:1.5rem; margin-top:4px; }

    .pkg-card {
        border: 2.5px solid var(--paw-border);
        border-radius: 20px;
        padding: 0;
        margin-bottom: 20px;
        overflow: hidden;
        background: #fff;
    }
    .pkg-header {
        background: var(--paw-brown);
        color: #fff;
        text-align: center;
        padding: 12px 20px;
        font-family: 'Baloo 2', cursive;
        font-weight: 700;
        font-size: 1.7rem;
        letter-spacing: 0.3px;
    }
    .pkg-body { padding: 20px 22px; }
    .pkg-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }
    .pkg-paw { font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
    .pkg-item p {
        font-size: 1.3rem;
        font-weight: 600;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    .pkg-card.vip .pkg-header {
        background: linear-gradient(135deg, #6a5acd, #9b59b6);
    }
    .pkg-card.weekly .pkg-header {
        background: linear-gradient(135deg, #3a7d8c, #5ba8b8);
    }

    .select-pkg-btn {
        width: 100%;
        margin-top: 8px;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="pawckage-page">

    <div class="page-header">
        <div class="page-subtitle">Choose your fav</div>
        <div class="paw-title">Pawckage</div>
        <div class="page-tagline">We take care of your Pets!</div>
    </div>

    <div class="pkg-card daily">
        <div class="pkg-header">Daily Pawckage - 75k</div>
        <div class="pkg-body">
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>daycare or boarding daily!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>You'll get a standard cage, meals twice a day, and regular hygiene checks!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>purrfect for those with a busy daily routine!</p>
            </div>
            @auth
                <a href="{{ route('user.booking') }}?pawckage=daily" class="btn-paw btn select-pkg-btn">
                    Select Daily 🐾
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline-paw btn select-pkg-btn">
                    Login to Select 🐾
                </a>
            @endauth
        </div>
    </div>

    <div class="pkg-card weekly">
        <div class="pkg-header">Weekly Pawckage - 500k</div>
        <div class="pkg-body">
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>daycare or boarding weeekly, so affordable!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>You'll get all daily pawckage + free grooming once (bath &amp; nail trim)!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>purrfect for those on vacation!</p>
            </div>
            @auth
                <a href="{{ route('user.booking') }}?pawckage=weekly" class="btn-paw btn select-pkg-btn">
                    Select Weekly 🐾
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline-paw btn select-pkg-btn">
                    Login to Select 🐾
                </a>
            @endauth
        </div>
    </div>

    <div class="pkg-card vip">
        <div class="pkg-header">VIP Pawckage - 100k</div>
        <div class="pkg-body">
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>exclusive care &amp; extra comfort!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>Your pet will enjoy a spacious with AC, vitamins, playtime, and daily photo/video updates!</p>
            </div>
            <div class="pkg-item">
                <span class="pkg-paw">🐾</span>
                <p>purrfect for pets that need extra attention!</p>
            </div>
            @auth
                <a href="{{ route('user.booking') }}?pawckage=vip" class="btn-paw btn select-pkg-btn">
                    Select VIP ✨
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline-paw btn select-pkg-btn">
                    Login to Select ✨
                </a>
            @endauth
        </div>
    </div>

</div>
</div>
@endsection