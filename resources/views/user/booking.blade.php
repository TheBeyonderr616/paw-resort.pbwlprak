@extends('layouts.app')

@section('title', 'Booking - PawResort')

@push('styles')
<style>
.page-wrapper { display:flex; justify-content:center; }
.booking-page {
    padding: 32px 20px;
    width: 80vw;
    max-width: none;
    margin: auto;
    box-sizing: border-box;
}
/* page title */
.page-title { font-size: 2.8rem; }
.page-tagline { font-size: 1.1rem; }
.label { font-size: 1.1rem; }
.select, .input { font-size: 1rem; }
.btn-submit { font-size: 1.25rem; }
.cage-picker-title { font-size: 1.35rem; }
.cage-cell { font-size: 1.1rem; }
.cage-legend { font-size: 0.9rem; }
/* Make all direct divs inside booking-page occupy 100% (which equals 80vw)
   so visually every section fills ~80% of the viewport */
.booking-page > div,
.booking-page .card-box,
.booking-page .cage-grid,
.booking-page .cage-legend {
    width: 100%;
    box-sizing: border-box;
}
.page-title {
    font-family: 'Baloo 2', cursive;
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--paw-brown);
    text-align: center;
}
.page-tagline {
    text-align: center;
    font-weight: 600;
    color: #777;
    margin-bottom: 26px;
    font-size: 1.4rem;
}
.card-box {
    background: #fff;
    border: 2px solid var(--paw-border);
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 18px;
}
.card-box.cage-card {
    padding: 12px 14px;
}
.label {
    font-weight: 800;
    margin-bottom: 8px;
    display: block;
    font-size: 1.05rem;
}
.select, .input {
    width: 100%;
    padding: 18px 20px;
    border-radius: 16px;
    border: 2px solid var(--paw-border);
    font-weight: 700;
    font-size: 1.25rem;
}
.select:focus, .input:focus {
    border-color: var(--paw-brown);
    outline: none;
}
.btn-submit {
    width: 100%;
    padding: 20px;
    border: none;
    border-radius: 18px;
    background: var(--paw-brown);
    color: #fff;
    font-weight: 800;
    font-size: 1.45rem;
    cursor: pointer;
    transition: 0.2s;
}
.btn-submit:hover { background: #a66628; transform: translateY(-2px); }

/* Cage grid pilihan user */
.cage-picker-title {
    font-family: 'Baloo 2', cursive;
    font-weight: 800;
    font-size: 1.55rem;
    margin-bottom: 10px;
    color: var(--paw-dark);
}
.cage-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    margin-bottom: 12px;
}
.cage-cell {
    aspect-ratio: 1;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    font-weight: 800;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all .2s;
    position: relative;
}
.cage-cell.available {
    background: #c8f0c8;
    color: #2d7a2d;
}
.cage-cell.available:hover {
    background: #a0dca0;
    transform: scale(1.08);
}
.cage-cell.occupied {
    background: #f0c8c8;
    color: #8a2020;
    cursor: not-allowed;
    opacity: 0.6;
}
.cage-cell.locked {
    background: #e0e0e0;
    color: #888;
    cursor: not-allowed;
    opacity: 0.7;
}
.cage-cell.selected {
    background: var(--paw-brown);
    color: #fff;
    border-color: #8a5010;
    transform: scale(1.1);
}
.cage-cell.vip-cage {
    border: 3px solid #ffd700;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.4);
}
.cage-cell.vip-cage::after {
    content: 'VIP';
    font-size: 0.7rem;
    position: absolute;
    top: 4px;
    right: 6px;
    color: #b8860b;
}
.cage-cell.selected.vip-cage::after {
    color: #fff;
}
.cage-cell.dimmed {
    opacity: 0.3;
    filter: grayscale(80%);
}

.cage-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 0.88rem;
    font-weight: 700;
    margin-top: 8px;
}
.legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 4px;
    display: inline-block;
    margin-right: 5px;
}
.legend-item { display: flex; align-items: center; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="booking-page">

    <div class="page-title">🐾 PawResort Booking</div>
    <div class="page-tagline">Choose your cage and reservation date</div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-3" style="font-weight:700;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4 mb-3" style="font-weight:700;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('user.booking.store') }}">
        @csrf

        {{-- PET SELECTION --}}
        <div class="card-box">
            <label class="label">🐾 Choose Your Pet</label>
            @if($pets->isEmpty())
                <p style="color:orange; font-weight:700;">You haven't registered any pets yet! 
                    <a href="{{ route('user.register-pet') }}" style="color:var(--paw-brown);">Register now</a>
                </p>
            @else
                <select name="pet_id" class="select" required>
                    <option value="">-- Select Your Pet --</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                            {{ $pet->name }} ({{ $pet->breed }})
                        </option>
                    @endforeach
                </select>
            @endif
            @error('pet_id')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- RESERVATION DATE --}}
        <div class="card-box">
            <label class="label">📅 Reservation Date</label>
            <input type="date" name="reservation_date" class="input"
                min="{{ date('Y-m-d') }}" required
                value="{{ old('reservation_date', date('Y-m-d')) }}">
            @error('reservation_date')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- PACKAGE --}}
        <div class="card-box">
            <label class="label">📦 Package</label>
            <select name="pawckage" id="packageSelect" class="select" required onchange="filterCages()">
                <option value="">-- Select Package --</option>
                <option value="daily" {{ (old('pawckage') ?? $selectedPackage) == 'daily' ? 'selected' : '' }}>Daily (Standard Cage)</option>
                <option value="weekly" {{ (old('pawckage') ?? $selectedPackage) == 'weekly' ? 'selected' : '' }}>Weekly (Standard Cage)</option>
                <option value="vip" {{ (old('pawckage') ?? $selectedPackage) == 'vip' ? 'selected' : '' }}>VIP (VIP Cage)</option>
            </select>
            @error('pawckage')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- CAGE PICKER (USER PILIH SENDIRI) --}}
        <div class="card-box cage-card">
            <div class="cage-picker-title">🏠 Choose Your Cage</div>
            <p id="cageHint" style="font-size:0.95rem; color:#888; font-weight:600; margin-bottom:12px;">
                Please select a package first
            </p>

            <input type="hidden" name="cage_id" id="selectedCageId" required>

            <div class="cage-grid" id="cageGrid">
                @foreach($cages as $cage)
                    @php 
                        $status = $cage->status ?? 'available';
                        $statusClass = ($status === 'available') ? 'available' : (($status === 'locked') ? 'locked' : 'occupied');
                        $typeClass = ($cage->type === 'vip') ? 'vip-cage' : 'standard-cage';
                    @endphp
                    <div class="cage-cell {{ $statusClass }} {{ $typeClass }}"
                        data-id="{{ $cage->id }}"
                        data-status="{{ $status }}"
                        data-type="{{ $cage->type }}"
                        onclick="selectCage(this, {{ $cage->id }}, '{{ $status }}', '{{ $cage->type }}')">
                        <span class="cage-code">{{ $cage->code ?? $loop->iteration }}</span>
                    </div>
                @endforeach
            </div>

            <div class="cage-legend">
                <div class="legend-item"><span class="legend-dot" style="background:#c8f0c8;"></span>Available</div>
                <div class="legend-item"><span class="legend-dot" style="background:#f0c8c8;"></span>Occupied</div>
                <div class="legend-item"><span class="legend-dot" style="background:#e0e0e0;"></span>Maintenance</div>
                <div class="legend-item"><span class="legend-dot" style="background:var(--paw-brown);"></span>Selected</div>
                <div class="legend-item"><span class="legend-dot" style="border:2px solid #ffd700; background:#fff;"></span>VIP Cage</div>
            </div>

            <div id="selectedCageLabel" style="margin-top:12px; font-weight:700; font-size:1rem; color:var(--paw-brown); display:none;">
                ✅ Selected: Cage <span id="cageName"></span>
            </div>

            @error('cage_id')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            Confirm Booking 🐾
        </button>

    </form>

</div>
</div>
@endsection

@push('scripts')
<script>
    let selectedCell = null;

    function selectCage(el, cageId, status, type) {
        if (status !== 'available') return;
        
        const selectedPkg = document.getElementById('packageSelect').value;
        if (!selectedPkg) {
            alert('Please select a package first!');
            return;
        }

        // Validate type against package
        if (selectedPkg === 'vip' && type !== 'vip') {
            alert('VIP package requires a VIP cage!');
            return;
        }
        if (selectedPkg !== 'vip' && type === 'vip') {
            alert('Daily/Weekly packages require a Standard cage!');
            return;
        }

        // Deselect previous
        if (selectedCell) {
            selectedCell.classList.remove('selected');
        }

        // Select new
        el.classList.add('selected');
        selectedCell = el;

        // Update hidden input
        document.getElementById('selectedCageId').value = cageId;

        // Show label
        const label = document.getElementById('selectedCageLabel');
        document.getElementById('cageName').textContent = el.querySelector('.cage-code').textContent.trim();
        label.style.display = 'block';
    }

    function filterCages() {
        const pkg = document.getElementById('packageSelect').value;
        const cages = document.querySelectorAll('.cage-cell');
        const hint = document.getElementById('cageHint');

        if (!pkg) {
            hint.textContent = 'Please select a package first';
            cages.forEach(c => c.classList.remove('dimmed'));
            return;
        }

        hint.textContent = pkg === 'vip' ? 'Showing VIP cages' : 'Showing Standard cages';

        cages.forEach(c => {
            const type = c.getAttribute('data-type');
            if (pkg === 'vip') {
                if (type === 'vip') {
                    c.classList.remove('dimmed');
                } else {
                    c.classList.add('dimmed');
                }
            } else {
                if (type === 'standard') {
                    c.classList.remove('dimmed');
                } else {
                    c.classList.add('dimmed');
                }
            }
        });

        // Reset selection if it's now dimmed
        if (selectedCell && selectedCell.classList.contains('dimmed')) {
            selectedCell.classList.remove('selected');
            selectedCell = null;
            document.getElementById('selectedCageId').value = '';
            document.getElementById('selectedCageLabel').style.display = 'none';
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', filterCages);
</script>
@endpush