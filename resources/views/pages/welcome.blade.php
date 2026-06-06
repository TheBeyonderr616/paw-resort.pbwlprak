@extends('layouts.app')

@section('title', 'PawResort - We take care of your Pets!')

@push('styles')
<style>
    .landing-hero {
        min-height: 80vh;
        display: grid;
        place-items: center;
        text-align: center;
        background: #f9f1e8;
        padding: 70px 24px 40px;
        border-radius: 40px;
        position: relative;
        overflow: hidden;
    }
    .landing-hero::after {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(196, 122, 58, 0.12);
        top: -40px;
        right: -80px;
    }
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 0 auto;
    }
    .hero-tagline {
        font-weight: 700;
        color: var(--paw-teal);
        font-size: 1.1rem;
        margin-bottom: 16px;
    }
    .hero-title {
        font-family: 'Baloo 2', cursive;
        font-size: clamp(3.8rem, 6vw, 5.8rem);
        color: var(--paw-brown);
        margin-bottom: 18px;
        line-height: 0.95;
    }
    .hero-description {
        max-width: 760px;
        margin: 0 auto 32px;
        color: #775a3f;
        font-size: 1.05rem;
        font-weight: 600;
        line-height: 1.8;
    }
    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        margin-top: 12px;
    }
    .hero-actions .btn-paw,
    .hero-actions .btn-outline-paw {
        padding: 18px 40px;
        font-size: 1.15rem;
    }
    .hero-graphic {
        margin: 0 auto 10px;
        width: min(240px, 70vw);
        height: min(240px, 70vw);
        border-radius: 50%;
        background: #fff;
        border: 12px solid rgba(255,255,255,.9);
        box-shadow: 0 24px 60px rgba(100,50,20,0.12);
        display: grid;
        place-items: center;
        position: relative;
    }
    .hero-graphic span {
        font-size: clamp(5rem, 18vw, 8rem);
        line-height: 1;
        animation: float 3s ease-in-out infinite;
    }

    .service-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        margin: 64px 0;
    }
    .service-card {
        background: #fff;
        border-radius: 26px;
        border: 2px solid var(--paw-border);
        padding: 28px 24px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: transform .2s, border-color .2s;
    }
    .service-card:hover {
        transform: translateY(-4px);
        border-color: rgba(196,122,58,0.35);
    }
    .service-card-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        display: grid;
        place-items: center;
        border-radius: 24px;
        background: rgba(196,122,58,0.1);
        font-size: 1.6rem;
    }
    .service-card h3 {
        font-size: 1.3rem;
        margin-bottom: 12px;
        color: var(--paw-brown);
    }
    .service-card p {
        font-size: 0.99rem;
        color: #7d6a56;
        font-weight: 600;
        line-height: 1.7;
    }

    .featured-row {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        align-items: stretch;
        margin-bottom: 60px;
    }
    .feature-main {
        border-radius: 32px;
        overflow: hidden;
        min-height: 420px;
        display: grid;
        align-items: end;
        position: relative;
        background: linear-gradient(180deg, #f7e7d5 0%, #f0d7c0 100%);
    }
    .feature-main::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.pexels.com/photos/4587997/pexels-photo-4587997.jpeg?auto=compress&cs=tinysrgb&w=1200') center/cover no-repeat;
        opacity: 0.45;
    }
    .feature-main-content {
        position: relative;
        padding: 36px;
        backdrop-filter: blur(2px);
        background: rgba(255,255,255,0.55);
        border-top-left-radius: 32px;
        border-top-right-radius: 32px;
        margin: 24px;
    }
    .feature-main-content h3 {
        font-size: 2.4rem;
        margin-bottom: 16px;
        color: var(--paw-brown);
    }
    .feature-main-content p {
        font-size: 1.05rem;
        color: #5e4837;
        font-weight: 600;
        line-height: 1.8;
    }

    .feature-side {
        display: grid;
        gap: 20px;
    }
    .feature-card {
        background: #fff;
        border-radius: 28px;
        border: 1px solid rgba(196,122,58,0.12);
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        padding: 28px 24px;
        display: grid;
        gap: 16px;
    }
    .feature-card.light {
        background: #f7e7d5;
    }
    .feature-card.dark {
        background: #f8dad0;
    }
    .feature-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: rgba(196,122,58,0.14);
        font-size: 1.4rem;
    }
    .feature-card h4 {
        margin: 0;
        font-size: 1.6rem;
        color: var(--paw-brown);
    }
    .feature-card p {
        margin: 0;
        color: #6d5543;
        line-height: 1.8;
        font-weight: 600;
    }

    @media(max-width: 1100px) {
        .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .featured-row { grid-template-columns: 1fr; }
    }
    @media(max-width: 720px) {
        .page-wrapper { padding: 20px 16px 50px; }
        .landing-hero { border-radius: 24px; padding: 50px 18px 30px; }
        .hero-title { font-size: 3.6rem; }
        .hero-description { font-size: 1rem; }
        .hero-actions { flex-direction: column; }
        .service-grid { grid-template-columns: 1fr; }
        .featured-row { gap: 18px; }
        .feature-main { min-height: 320px; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <section class="landing-hero">
        <div class="hero-content">
            <p class="hero-tagline">Tempat kemewahan bertemu dengan kibasan ekor bahagia.</p>
            <h1 class="hero-title">PawResort!</h1>
            <p class="hero-description">Rasakan liburan terbaik untuk sahabat berbulu Anda di surga organik kami yang bebas stres.</p>
            <div class="hero-actions">
                <a href="{{ route('user.booking') }}" class="btn-paw">Pesan Sekarang</a>
                <a href="{{ route('pawckage') }}" class="btn-outline-paw">Jelajahi Kamar</a>
            </div>
        </div>
        <div class="hero-graphic">
            <span>🐶</span>
        </div>
    </section>

    <section class="service-grid">
        <div class="service-card">
            <div class="service-card-icon">📅</div>
            <h3>Reservasi</h3>
            <p>Jadwalkan liburan impian hewan peliharaan Anda hanya dalam beberapa klik.</p>
        </div>
        <div class="service-card">
            <div class="service-card-icon">💳</div>
            <h3>Pembayaran</h3>
            <p>Manajemen transaksi yang aman, transparan, dan bebas repot.</p>
        </div>
        <div class="service-card">
            <div class="service-card-icon">🎁</div>
            <h3>Paket Paw</h3>
            <p>Paket kurasi termasuk hari spa dan suguhan gourmet.</p>
        </div>
        <div class="service-card">
            <div class="service-card-icon">🐾</div>
            <h3>Daftar Hewan</h3>
            <p>Buat profil detail untuk kebutuhan unik sahabat Anda.</p>
        </div>
    </section>
</div>
@endsection