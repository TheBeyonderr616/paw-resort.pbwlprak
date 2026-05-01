<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PawResort')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
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

        * { box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--paw-light);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4b8e0' fill-opacity='0.12'%3E%3Cellipse cx='20' cy='20' rx='6' ry='5'/%3E%3Cellipse cx='32' cy='14' rx='4' ry='3.5'/%3E%3Cellipse cx='42' cy='14' rx='4' ry='3.5'/%3E%3Cellipse cx='54' cy='20' rx='6' ry='5'/%3E%3Cellipse cx='37' cy='32' rx='12' ry='10'/%3E%3C/g%3E%3C/svg%3E");
            min-height: 100vh;
            color: var(--paw-dark);
        }

        .paw-font { font-family: 'Baloo 2', cursive; }

        /* ---- Navbar ---- */
        .paw-navbar {
            background: var(--paw-light);
            border-bottom: 2px solid var(--paw-border);
            padding: 10px 20px;
        }
        .paw-navbar .brand {
            font-family: 'Baloo 2', cursive;
            font-size: 1.4rem;
            color: var(--paw-brown);
            font-weight: 800;
            text-decoration: none;
        }
        .paw-navbar .nav-btn {
            border: 2px solid var(--paw-brown);
            border-radius: 20px;
            padding: 4px 18px;
            color: var(--paw-dark);
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all .2s;
            margin-left: 6px;
        }
        .paw-navbar .nav-btn:hover,
        .paw-navbar .nav-btn.active {
            background: var(--paw-brown);
            color: #fff;
        }

        /* ---- Cards ---- */
        .paw-card {
            background: #fff;
            border: 2px solid var(--paw-border);
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 16px;
        }
        .paw-card-soft {
            background: var(--paw-cream);
            border: 2px solid var(--paw-border);
            border-radius: 18px;
            padding: 18px;
        }

        /* ---- Stat Badges ---- */
        .stat-badge {
            border: 2px solid var(--paw-border);
            border-radius: 14px;
            padding: 10px 16px;
            text-align: center;
            background: #fff;
        }
        .stat-badge .label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--paw-brown);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-badge .value {
            font-family: 'Baloo 2', cursive;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--paw-brown);
            line-height: 1.1;
        }

        /* ---- Buttons ---- */
        .btn-paw {
            background: var(--paw-brown);
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            padding: 8px 24px;
            font-family: 'Nunito', sans-serif;
            transition: all .2s;
        }
        .btn-paw:hover { background: #a66628; color: #fff; transform: translateY(-1px); }
        .btn-paw-outline {
            background: transparent;
            color: var(--paw-brown);
            border: 2px solid var(--paw-brown);
            border-radius: 25px;
            font-weight: 700;
            padding: 6px 22px;
            transition: all .2s;
        }
        .btn-paw-outline:hover { background: var(--paw-brown); color: #fff; }
        .btn-paw-red {
            background: var(--paw-red);
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            padding: 8px 24px;
        }
        .btn-paw-red:hover { background: #c04040; color: #fff; }
        .btn-paw-green {
            background: var(--paw-green);
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            padding: 8px 24px;
        }
        .btn-paw-green:hover { background: #3ea055; color: #fff; }

        /* ---- Inputs ---- */
        .paw-input {
            border: 2px solid var(--paw-border);
            border-radius: 25px;
            padding: 10px 18px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            background: #f5f0f8;
            color: var(--paw-dark);
            width: 100%;
        }
        .paw-input:focus {
            outline: none;
            border-color: var(--paw-brown);
            background: #fff;
        }
        .paw-input::placeholder { color: #aaa; }

        /* ---- Page wrapper max-width for mobile look on desktop ---- */
        .page-wrapper {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        @media (min-width: 768px) {
            .page-wrapper { max-width: 700px; }
        }
        @media (min-width: 1024px) {
            .page-wrapper { max-width: 900px; }
        }

        /* ---- Alert ---- */
        .paw-alert {
            border-radius: 14px;
            border: none;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>