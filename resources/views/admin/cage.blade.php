@extends('layouts.app')

@section('title', 'Cage Monitoring - PawResort')

@push('styles')
<style>
    .cage-page { padding: 20px 16px; }

    .page-title { font-family:'Baloo 2',cursive; font-size:2rem; font-weight:800; color:var(--paw-brown); text-align:center; margin-bottom:4px; }
    .page-tagline { text-align:center; font-weight:700; color:#888; font-size:0.85rem; margin-bottom:20px; }

    /* Stat badges row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 22px;
    }
    .stat-badge .label { font-size:0.7rem; }
    .stat-badge.occupied .value { color: var(--paw-brown); }
    .stat-badge.available .value { color: var(--paw-green); }

    /* Cage grid */
    .cage-section-title {
        font-family: 'Baloo 2', cursive;
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--paw-dark);
        margin-bottom: 4px;
    }
    .cage-section-sub { font-size:0.8rem; color:#888; font-weight:600; margin-bottom:14px; }

    .cage-grid-wrap {
        background: #e8f5e9;
        border: 2.5px solid var(--paw-border);
        border-radius: 20px;
        padding: 16px;
        margin-bottom: 18px;
    }
    .cage-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    @media(min-width: 500px) {
        .cage-grid { grid-template-columns: repeat(5, 1fr); }
    }

    .cage-cell {
        aspect-ratio: 1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.4rem;
        font-weight: 800;
        transition: all .2s;
        border: none;
        position: relative;
        color: #fff;
    }
    .cage-cell.occupied {
        background: #c17a5a;
    }
    .cage-cell.occupied:hover { background: #a85e3e; transform: scale(1.05); }
    .cage-cell.available {
        background: #c8f0c8;
        color: var(--paw-green);
    }
    .cage-cell.available:hover { background: #a5e0a5; transform: scale(1.05); }
    .cage-cell .cage-num {
        position: absolute;
        bottom: 3px;
        right: 6px;
        font-size: 0.6rem;
        font-weight: 800;
        opacity: 0.7;
        color: inherit;
    }

    /* Pagination */
    .cage-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-bottom: 20px;
    }
    .page-dot {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 2px solid var(--paw-border);
        background: #fff;
        font-weight: 800;
        font-size: 0.85rem;
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
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--paw-brown);
        font-weight: 900;
        padding: 0 4px;
    }

    /* Occupancy chart */
    .occupancy-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }
    .occupancy-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .donut-wrap {
        position: relative;
        width: 60px;
        height: 60px;
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
        font-size: 0.85rem;
        color: var(--paw-brown);
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

    .updated-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 6px;
    }
    .updated-card span { font-size:0.75rem; font-weight:700; color:#888; }
    .updated-card strong { font-family:'Baloo 2',cursive; font-size:1rem; color:var(--paw-brown); }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="cage-page">

    <div class="page-title">Cage Monitoring</div>
    <div class="page-tagline">Review and Confirm Pending Transactions</div>

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

    <!-- Real-time Cage Grid -->
    <div class="cage-section-title">Real-time Cage Status</div>
    <div class="cage-section-sub">live overview of all sanctuary units</div>

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
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle cx="30" cy="30" r="24" fill="none" stroke="#eee" stroke-width="8"/>
                    <circle cx="30" cy="30" r="24" fill="none" stroke="var(--paw-brown)" stroke-width="8"
                            stroke-dasharray="0 151" stroke-linecap="round" id="donutCircle"
                            style="transition: stroke-dasharray .5s"/>
                </svg>
                <div class="donut-pct" id="donutPct">0%</div>
            </div>
            <div>
                <div style="font-weight:800; font-size:0.85rem; margin-bottom:6px;">Occupancy<br>Ratio</div>
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
            <button onclick="refreshTime()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;">🔄</button>
        </div>
    </div>

    <!-- Save Button -->
    <form method="POST" action="{{ route('admin.cage.save') }}" id="cageSaveForm">
        @csrf
        <input type="hidden" name="cage_status" id="cageStatusInput">
        <button type="submit" class="btn-paw btn w-100">💾 Save Cage Status</button>
    </form>

</div>
</div>
@endsection

<!-- Save Button -->
<form method="POST" action="{{ route('admin.cage.save') }}" id="cageSaveForm">
    <div class="paw-card mb-4">

    <h4 class="mb-3">Manage Cage</h4>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cages as $cage)
            <tr>
                <td>{{ $cage->name }}</td>

                <td>
                    @if($cage->status === 'available')
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-danger">Locked</span>
                    @endif
                </td>

                <td>
                    <form method="POST"
                          action="{{ route('admin.cage.toggle', $cage->id) }}">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-sm btn-dark">

                            {{ $cage->status === 'available'
                                ? 'Lock'
                                : 'Unlock' }}

                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@push('scripts')
<script>
    const TOTAL_CAGES = 50;
    const PER_PAGE = 10;
    let currentPage = 1;
    let totalPages = Math.ceil(TOTAL_CAGES / PER_PAGE);

    // Initialize cage states from server or all available
    let cageStates = @json($cageStates ?? array_fill(0, 50, false));
    // true = occupied, false = available

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
                ${occupied ? '🐾' : '<span style="font-size:1.6rem;color:var(--paw-green);">✔</span>'}
                <span class="cage-num">${globalIdx + 1}</span>
            `;
            cell.addEventListener('click', () => toggleCage(globalIdx));
            grid.appendChild(cell);
        });

        updateStats();
        updateDonut();
    }

    function toggleCage(idx) {
        cageStates[idx] = !cageStates[idx];
        renderCages();
        refreshTime();
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
        const circumference = 2 * Math.PI * 24; // ~150.8
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

    // Before form submit, serialize cage states
    document.getElementById('cageSaveForm').addEventListener('submit', function() {
        document.getElementById('cageStatusInput').value = JSON.stringify(cageStates);
    });

    // Init
    renderCages();
    renderPagination();
</script>
@endpush