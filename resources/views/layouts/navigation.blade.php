<nav class="paw-navbar d-flex align-items-center justify-content-between">
    <a href="{{ route('home') }}" class="brand">
        <span>🐾</span> PawResort!
    </a>
    <div class="d-flex align-items-center">
        @auth
            <span class="me-2" style="font-size:0.85rem; font-weight:700; color:var(--paw-teal);">
                Hi, {{ Auth::user()->name }}!
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-btn" style="background:none; cursor:pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('home') }}" class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('login') }}" class="nav-btn {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}" class="nav-btn {{ request()->routeIs('register') ? 'active' : '' }}">Sign In</a>
        @endauth
    </div>
</nav>