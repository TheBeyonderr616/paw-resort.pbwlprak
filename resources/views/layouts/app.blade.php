<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PawResort')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    :root {
        --paw-pink:     #f5eef8;
        --paw-cream:    #fdf6f0;
        --paw-brown:    #c47a3a;
        --paw-dark:     #4a3728;
        --paw-teal:     #3a7d8c;
        --paw-green:    #5bbd72;
        --paw-red:      #e05c5c;
        --paw-light:    #f9f4fb;
        --paw-card:     #ffffffcc;
        --paw-border:   #e8d5c4;
        --paw-shadow:   rgba(196,122,58,0.15);
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--paw-light);
        min-height: 100vh;
        color: var(--paw-dark);

        /* 🔥 GLOBAL TEXT UDAH DIBESARIN */
        font-size: 16px;
        line-height: 1.7;
    }

    .paw-font {
        font-family: 'Baloo 2', cursive;
    }

    /* NAVBAR */
    .paw-navbar {
        background: var(--paw-light);
        border-bottom: 2px solid var(--paw-border);
        padding: 12px 18px;
    }

    .paw-navbar .brand {
        font-family: 'Baloo 2', cursive;
        font-size: 1.7rem;
        color: var(--paw-brown);
        font-weight: 800;
        text-decoration: none;
    }

    .paw-navbar .nav-btn {
        border: 2px solid var(--paw-brown);
        border-radius: 20px;
        padding: 8px 18px;
        color: var(--paw-dark);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        margin-left: 6px;
        transition: 0.2s;
    }

    .paw-navbar .nav-btn:hover,
    .paw-navbar .nav-btn.active {
        background: var(--paw-brown);
        color: #fff;
    }

    /* CARD */
    .paw-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 20px;
        padding: 26px;
        margin-bottom: 16px;
    }

    .paw-card-soft {
        background: var(--paw-cream);
        border: 2px solid var(--paw-border);
        border-radius: 20px;
        padding: 26px;
    }

    /* STAT */
    .stat-badge {
        border: 2px solid var(--paw-border);
        border-radius: 14px;
        padding: 12px 16px;
        text-align: center;
        background: #fff;
    }

    .stat-badge .label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--paw-brown);
        text-transform: uppercase;
    }

    .stat-badge .value {
        font-family: 'Baloo 2', cursive;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--paw-brown);
    }

    /* BUTTON */
    .btn-paw {
        background: var(--paw-brown);
        color: #fff;
        border: none;
        border-radius: 25px;
        font-weight: 700;
        padding: 12px 26px;
        font-size: 1rem;
        transition: 0.2s;
    }

    .btn-paw:hover {
        background: #a66628;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-paw-outline {
        background: transparent;
        color: var(--paw-brown);
        border: 2px solid var(--paw-brown);
        border-radius: 25px;
        font-weight: 700;
        padding: 10px 22px;
    }

    .btn-paw-outline:hover {
        background: var(--paw-brown);
        color: #fff;
    }

    /* INPUT */
    .paw-input {
        border: 2px solid var(--paw-border);
        border-radius: 18px;
        padding: 12px 16px;
        font-size: 1rem;
        background: #f5f0f8;
        width: 100%;
    }

    .paw-input:focus {
        outline: none;
        border-color: var(--paw-brown);
        background: #fff;
    }

    /* PAGE WRAPPER (UI LEBIH BESAR & RESPONSIVE) */
    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
        min-height: 100vh;
        padding: 18px 16px 60px;
    }

    @media (min-width: 768px) {
        .page-wrapper {
            max-width: 1050px;
        }
    }

    @media (min-width: 1024px) {
        .page-wrapper {
            max-width: 1200px;
        }
    }

    /* ALERT */
    .paw-alert {
        border-radius: 14px;
        font-weight: 600;
        font-size: 0.95rem;
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