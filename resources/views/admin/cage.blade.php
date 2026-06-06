@extends('layouts.app')

@section('title', 'Cage Monitoring - PawResort')

@push('styles')
<style>
    .cage-page { padding: 28px 20px; }

    .page-title { font-family:'Baloo 2',cursive; font-size:2.4rem; font-weight:800; color:var(--paw-brown); text-align:center; margin-bottom:6px; }
    .page-tagline { text-align:center; font-weight:700; color:#888; font-size:1rem; margin-bottom:24px; }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 26px;
    }
    .stat-badge .label { font-size:0.9rem; }
    .stat-badge.occupied .value { color: var(--paw-brown); }
    .stat-badge.available .value { color: var(--paw-green); }

    .cage-section-title {
        font-family: 'Baloo 2', cursive;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--paw-dark);
        margin-bottom: 6px;
    }
    .cage-section-sub { font-size:0.92rem; color:#888; font-weight:600; margin-bottom:16px; }

    .cage-grid-wrap {
        background: #e8f5e9;
        border: 2.5px solid var(--paw-border);
        border-radius: 22px;
        padding: 18px;
        margin-bottom: 20px;
    }
    .cage-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }
    @media(min-width: 500px) {
        .cage-grid { grid-template-columns: repeat(5, 1fr); }
    }

    .cage-cell {
        aspect-ratio: 1;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 800;
        transition: all .2s;
        border: none;
        position: relative;
        color: #fff;
    }
    .cage-cell.occupied { background: #c17a5a; }
    .cage-cell.occupied:hover { background: #a85e3e; transform: scale(1.05); }
    .cage-cell.available { background: #c8f0c8; color: var(--paw-green); }
    .cage-cell.available:hover { background: #a5e0a5; transform: scale(1.05); }
    .cage-cell .cage-num {
        position: absolute;
        bottom: 4px;
        right: 7px;
        font-size: 0.65rem;
        font-weight: 800;
        opacity: 0.7;
        color: inherit;
    }

    .cage-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }
    .page-dot {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid var(--paw-border);
        background: #fff;
        font-weight: 800;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all .2s;
        display:flex; align-items:center; justify-content:center;
        color: var(--paw-dark);
    }
    .page-dot:hover, .page-dot.active {
        background: var(--paw-brown);
        border-color: var(--paw-brown);
        color: #fff;
    }
    .page-arrow {
        font-size: 1.4rem;
        cursor: pointer;
        color: var(--paw-brown);
        font-weight: 900;
        padding: 0 6px;
    }

    .occupancy-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 24px;
    }
    .occupancy-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 18px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .donut-wrap {
        position: relative;
        width: 70px;
        height: 70px;
        flex-shrink: 0;
    }
    .donut-wrap svg { transform: rotate(-90deg); }
    .donut-pct {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        font-family: 'Baloo 2', cursive;
        font-weight: 800;
        font-size: 0.95rem;
        color: var(--paw-brown);
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .legend-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }

    .updated-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 18px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 8px;
    }
    .updated-card span { font-size:0.85rem; font-weight:700; color:#888; }
    .updated-card strong { font-family:'Baloo 2',cursive; font-size:1.1rem; color:var(--paw-brown); }

    .info-note {
        background: #fff8f0;
        border: 2px solid var(--paw-border);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #666;
    }
    .info-note strong { color: var(--paw-brown); }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="cage-page">

    <div class="page-title">Cage Monitoring</div>
    <div class="page-tagline">Real-time overview of all sanctuary units</div>

    <div class="info-note">
        ℹ️ <strong>Info:</strong> Cage status is automatically updated based on user bookings.
        Green = available for booking, Orange = currently occupied by a pet.
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-3" style="font-weight:700;">{{ session('success') }}</div>
    @endif

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-badge">
            <div class="label">Total Cage</div>
            <div class="value" id="statTotal">50</div>
        </div>
        <div class="stat-badge occupied">
            <div class="label">Occupied</div>
            <div class="value" id="statOccupied">0</div>
        </div>
        <div class="stat-badge available">
            <div class="label">Available</div>
            <div class="value" id="statAvailable">50</div>
        </div>
    </div>

    <!-- Cage Grid (READ-ONLY untuk admin, user yg pilih) -->
    <div class="cage-section-title">Real-time Cage Status</div>
    <div class="cage-section-sub">live overview — users select their own cage when booking</div>

    <div class="cage-grid-wrap">
        <div class="cage-grid" id="cageGrid">
            <!-- Rendered by JS -->
        </div>
    </div>

    <!-- Pagination -->
    <div class="cage-pagination" id="cagePagination"></div>

    <!-- Occupancy Info -->
    <div class="occupancy-row">
        <div class="occupancy-card">
            <div class="donut-wrap">
                <svg width="70" height="70" viewBox="0 0 70 70">
                    <circle cx="35" cy="35" r="28" fill="none" stroke="#eee" stroke-width="9"/>
                    <circle cx="35" cy="35" r="28" fill="none" stroke="var(--paw-brown)" stroke-width="9"
                            stroke-dasharray="0 176" stroke-linecap="round" id="donutCircle"
                            style="transition: stroke-dasharray .5s"/>
                </svg>
                <div class="donut-pct" id="donutPct">0%</div>
            </div>
            <div>
                <div style="font-weight:800; font-size:0.95rem; margin-bottom:8px;">Occupancy<br>Ratio</div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:var(--paw-brown);"></div>
                    <span>Occupied</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background:#ddd;"></div>
                    <span>Vacant</span>
                </div>
            </div>
        </div>

        <div class="updated-card">
            <span>last updated</span>
            <strong id="lastUpdated">just now</strong>
            <button onclick="refreshTime()" style="background:none;border:none;font-size:1.3rem;cursor:pointer;">🔄</button>
        </div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
    const TOTAL_CAGES = 50;
    const PER_PAGE = 10;
    let currentPage = 1;
    let totalPages = Math.ceil(TOTAL_CAGES / PER_PAGE);

    // Cage states from server (true = occupied)
    let cageStates = @json($cageStates ?? array_fill(0, 50, false));

    function getPageCages() {
        const start = (currentPage - 1) * PER_PAGE;
        return cageStates.slice(start, start + PER_PAGE);
    }

    function renderCages() {
        const grid = document.getElementById('cageGrid');
        grid.innerHTML = '';
        const start = (currentPage - 1) * PER_PAGE;
        const pageCages = getPageCages();

        pageCages.forEach((occupied, i) => {
            const globalIdx = start + i;
            const cell = document.createElement('div');
            cell.className = `cage-cell ${occupied ? 'occupied' : 'available'}`;
            cell.innerHTML = `
                ${occupied ? '🐾' : '<span style="font-size:1.4rem;color:var(--paw-green);">✔</span>'}
                <span class="cage-num">${globalIdx + 1}</span>
            `;
            grid.appendChild(cell);
        });

        updateStats();
        updateDonut();
    }

    function updateStats() {
        const occupied = cageStates.filter(Boolean).length;
        document.getElementById('statTotal').textContent = TOTAL_CAGES;
        document.getElementById('statOccupied').textContent = occupied;
        document.getElementById('statAvailable').textContent = TOTAL_CAGES - occupied;
    }

    function updateDonut() {
        const occupied = cageStates.filter(Boolean).length;
        const pct = Math.round((occupied / TOTAL_CAGES) * 100);
        const circumference = 2 * Math.PI * 28;
        const dash = (pct / 100) * circumference;
        document.getElementById('donutCircle').setAttribute('stroke-dasharray', `${dash} ${circumference - dash}`);
        document.getElementById('donutPct').textContent = `${pct}%`;
    }

    function renderPagination() {
        const pg = document.getElementById('cagePagination');
        pg.innerHTML = '';

        const prev = document.createElement('span');
        prev.className = 'page-arrow';
        prev.textContent = '<';
        prev.onclick = () => { if(currentPage > 1){ currentPage--; renderCages(); renderPagination(); } };
        pg.appendChild(prev);

        for (let i = 1; i <= totalPages; i++) {
            const dot = document.createElement('div');
            dot.className = `page-dot ${i === currentPage ? 'active' : ''}`;
            dot.textContent = i;
            dot.onclick = () => { currentPage = i; renderCages(); renderPagination(); };
            pg.appendChild(dot);
        }

        const next = document.createElement('span');
        next.className = 'page-arrow';
        next.textContent = '>';
        next.onclick = () => { if(currentPage < totalPages){ currentPage++; renderCages(); renderPagination(); } };
        pg.appendChild(next);
    }

    function refreshTime() {
        document.getElementById('lastUpdated').textContent = 'just now';
    }

    renderCages();
    renderPagination();
</script>
@endpush