@extends('layouts.app')

@section('title', 'Booking - PawResort')

@push('styles')
<style>
.booking-page {
    padding: 32px 20px;
    max-width: 760px;
    margin: auto;
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
    font-size: 1.05rem;
}
.card-box {
    background: #fff;
    border: 2px solid var(--paw-border);
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 18px;
}
.label {
    font-weight: 800;
    margin-bottom: 8px;
    display: block;
    font-size: 1.05rem;
}
.select, .input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 14px;
    border: 2px solid var(--paw-border);
    font-weight: 600;
    font-size: 1rem;
}
.select:focus, .input:focus {
    border-color: var(--paw-brown);
    outline: none;
}
.btn-submit {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 16px;
    background: var(--paw-brown);
    color: #fff;
    font-weight: 800;
    font-size: 1.15rem;
    cursor: pointer;
    transition: 0.2s;
}
.btn-submit:hover { background: #a66628; transform: translateY(-2px); }

/* Cage grid pilihan user */
.cage-picker-title {
    font-family: 'Baloo 2', cursive;
    font-weight: 800;
    font-size: 1.1rem;
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
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
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
.cage-cell.selected {
    background: var(--paw-brown);
    color: #fff;
    border-color: #8a5010;
    transform: scale(1.1);
}
.cage-legend {
    display: flex;
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

        {{-- RESERVATION DATE --}}
        <div class="card-box">
            <label class="label">📅 Reservation Date</label>
            <input type="date" name="reservation_date" class="input"
                min="{{ date('Y-m-d') }}" required
                value="{{ old('reservation_date') }}">
            @error('reservation_date')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- CAGE PICKER (USER PILIH SENDIRI) --}}
        <div class="card-box">
            <div class="cage-picker-title">🏠 Choose Your Cage</div>
            <p style="font-size:0.9rem; color:#888; font-weight:600; margin-bottom:14px;">
                Click an available cage (green) to select it
            </p>

            <input type="hidden" name="cage_id" id="selectedCageId" required>

            <div class="cage-grid" id="cageGrid">
                @foreach($cages as $cage)
                    @php $isOccupied = $cage->status !== 'available'; @endphp
                    <div class="cage-cell {{ $isOccupied ? 'occupied' : 'available' }}"
                        data-id="{{ $cage->id }}"
                        data-occupied="{{ $isOccupied ? 'true' : 'false' }}"
                        onclick="selectCage(this, {{ $cage->id }}, {{ $isOccupied ? 'true' : 'false' }})">
                        {{ $cage->code ?? $loop->iteration }}
                    </div>
                @endforeach
            </div>

            <div class="cage-legend">
                <span><span class="legend-dot" style="background:#c8f0c8;"></span>Available</span>
                <span><span class="legend-dot" style="background:#f0c8c8;"></span>Occupied</span>
                <span><span class="legend-dot" style="background:var(--paw-brown);"></span>Selected</span>
            </div>

            <div id="selectedCageLabel" style="margin-top:12px; font-weight:700; font-size:1rem; color:var(--paw-brown); display:none;">
                ✅ Selected: Cage <span id="cageName"></span>
            </div>

            @error('cage_id')
                <div style="color:red; font-size:0.88rem; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- PACKAGE --}}
        <div class="card-box">
            <label class="label">📦 Package</label>
            <select name="pawckage" class="select" required>
                <option value="">-- Select Package --</option>
                <option value="daily" {{ old('pawckage') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('pawckage') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="vip" {{ old('pawckage') == 'vip' ? 'selected' : '' }}>VIP</option>
            </select>
            @error('pawckage')
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

    function selectCage(el, cageId, isOccupied) {
        if (isOccupied) return;

        // Deselect previous
        if (selectedCell) {
            selectedCell.classList.remove('selected');
            selectedCell.classList.add('available');
        }

        // Select new
        el.classList.remove('available');
        el.classList.add('selected');
        selectedCell = el;

        // Update hidden input
        document.getElementById('selectedCageId').value = cageId;

        // Show label
        const label = document.getElementById('selectedCageLabel');
        document.getElementById('cageName').textContent = el.textContent.trim();
        label.style.display = 'block';
    }
</script>
@endpush