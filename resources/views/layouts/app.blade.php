<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PawResort')</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    :root {
        --paw-pink:   #f5eef8;
        --paw-cream:  #fdf6f0;
        --paw-brown:  #c47a3a;
        --paw-dark:   #3a2c1e;
        --paw-teal:   #3a7d8c;
        --paw-green:  #4caf7d;
        --paw-red:    #e05c5c;
        --paw-light:  #faf6f2;
        --paw-border: #e0cbb8;
        --paw-shadow: rgba(196,122,58,0.13);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Nunito', sans-serif;
        background: var(--paw-light);
        min-height: 100vh;
        color: var(--paw-dark);
        font-size: 17px;
        line-height: 1.7;
    }

    h1,h2,h3,h4,h5,h6 { font-family: 'Baloo 2', cursive; }

    /* ── NAVBAR ── */
    .paw-navbar {
        background: #fff;
        border-bottom: 2.5px solid var(--paw-border);
        padding: 16px 40px;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .paw-navbar .brand {
        font-family: 'Baloo 2', cursive;
        font-size: 2.1rem;
        color: var(--paw-brown);
        font-weight: 800;
        text-decoration: none;
    }
    .paw-navbar .nav-btn {
        border: 2px solid var(--paw-brown);
        border-radius: 25px;
        padding: 10px 26px;
        color: var(--paw-dark);
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
        margin-left: 10px;
        transition: .2s;
    }
    .paw-navbar .nav-btn:hover,
    .paw-navbar .nav-btn.active {
        background: var(--paw-brown);
        color: #fff;
    }

    /* ── PAGE WRAPPER ── */
    .page-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 36px 40px 80px;
        min-height: calc(100vh - 74px);
    }

    /* ── CARDS ── */
    .paw-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 24px;
        padding: 36px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px var(--paw-shadow);
    }

    /* ── BUTTONS ── */
    .btn-paw {
        background: var(--paw-brown);
        color: #fff !important;
        border: none;
        border-radius: 30px;
        font-weight: 800;
        padding: 14px 36px;
        font-size: 1.1rem;
        transition: .2s;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }
    .btn-paw:hover { background: #a66228; transform: translateY(-2px); }

    .btn-paw-sm {
        background: var(--paw-brown);
        color: #fff !important;
        border: none;
        border-radius: 20px;
        font-weight: 800;
        padding: 9px 22px;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        transition: .2s;
    }
    .btn-paw-sm:hover { background: #a66228; }

    .btn-danger-sm {
        background: var(--paw-red);
        color: #fff !important;
        border: none;
        border-radius: 20px;
        font-weight: 800;
        padding: 9px 22px;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        transition: .2s;
    }
    .btn-danger-sm:hover { background: #c04444; }

    .btn-outline-paw {
        background: transparent;
        color: var(--paw-brown) !important;
        border: 2.5px solid var(--paw-brown);
        border-radius: 20px;
        font-weight: 800;
        padding: 9px 22px;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        transition: .2s;
    }
    .btn-outline-paw:hover { background: var(--paw-brown); color: #fff !important; }

    /* ── INPUTS ── */
    .paw-input, .paw-select {
        width: 100%;
        padding: 14px 18px;
        border: 2.5px solid var(--paw-border);
        border-radius: 16px;
        font-size: 1.05rem;
        font-family: 'Nunito', sans-serif;
        font-weight: 600;
        background: #faf8f5;
        transition: .2s;
    }
    .paw-input:focus, .paw-select:focus {
        outline: none;
        border-color: var(--paw-brown);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(196,122,58,0.12);
    }

    /* ── FORM LABEL ── */
    .form-label-paw {
        font-weight: 800;
        font-size: 1rem;
        color: var(--paw-dark);
        margin-bottom: 8px;
        display: block;
    }

    /* ── STATUS BADGES ── */
    .badge-pending  { background:#fff4d6; color:#8a6d1d; border-radius:20px; padding:5px 14px; font-weight:800; font-size:.9rem; }
    .badge-confirmed{ background:#d7f5e6; color:#146c43; border-radius:20px; padding:5px 14px; font-weight:800; font-size:.9rem; }
    .badge-declined { background:#ffe0e3; color:#a61b29; border-radius:20px; padding:5px 14px; font-weight:800; font-size:.9rem; }

    /* ── ALERT ── */
    .paw-alert { border-radius: 16px; font-weight: 700; padding: 16px 22px; font-size: 1rem; }

    /* ── PAGE TITLE ── */
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--paw-brown);
        text-align: center;
        margin-bottom: 6px;
    }
    .page-tagline {
        text-align: center;
        font-weight: 600;
        color: #999;
        font-size: 1.1rem;
        margin-bottom: 32px;
    }

    @media(max-width: 768px) {
        .page-wrapper { padding: 20px 16px 60px; }
        .paw-navbar { padding: 14px 16px; }
        .page-title { font-size: 2.1rem; }
    }
    </style>

    @stack('styles')
</head>
<body>
    @include('layouts.navigation')
    <main class="page-wrapper">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>