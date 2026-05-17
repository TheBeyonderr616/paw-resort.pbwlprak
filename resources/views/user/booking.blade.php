@extends('layouts.app')

@section('title', 'Booking - PawResort')

@push('styles')
<style>
.booking-page {
    padding: 28px 16px;
    max-width: 720px;
    margin: auto;
}

.page-title {
    font-family: 'Baloo 2', cursive;
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--paw-brown);
    text-align: center;
}

.page-tagline {
    text-align: center;
    font-weight: 600;
    color: #777;
    margin-bottom: 20px;
}

.card-box {
    background: #fff;
    border: 2px solid var(--paw-border);
    border-radius: 16px;
    padding: 16px;
    margin-bottom: 16px;
}

.label {
    font-weight: 800;
    margin-bottom: 6px;
    display: block;
}

.select, .input {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 2px solid var(--paw-border);
    font-weight: 600;
}

.btn-paw {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 14px;
    background: var(--paw-brown);
    color: #fff;
    font-weight: 800;
    cursor: pointer;
}

.btn-paw:hover {
    background: #a66628;
}
</style>
@endpush

@section('content')

<div class="page-wrapper">
<div class="booking-page">

    <div class="page-title">🐾 PawResort Booking</div>
    <div class="page-tagline">Select cage and reservation date</div>

    <form method="POST" action="{{ route('user.booking.store') }}">
        @csrf

        {{-- RESERVATION DATE --}}
        <div class="card-box">
            <label class="label">Reservation Date</label>
            <input type="date" name="reservation_date" class="input" required>
        </div>

        {{-- CAGE SELECT --}}
        <div class="card-box">
            <label class="label">Choose Cage</label>

            <select name="cage_id" class="select" required>
                <option value="">-- Select Cage --</option>

                @foreach($cages as $cage)
                    <option value="{{ $cage->id }}">
                        {{ $cage->code }} - {{ $cage->type }}
                        @if($cage->status !== 'available')
                            (Locked)
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        {{-- PACKAGE --}}
        <div class="card-box">
            <label class="label">Package</label>

            <select name="pawckage" class="select" required>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="vip">VIP</option>
            </select>
        </div>

        <button type="submit" class="btn-paw">
            Confirm Booking 🐾
        </button>

    </form>

</div>
</div>

@endsection