@extends('layouts.app')

@section('title', 'Booking Details - PawResort')

@push('styles')
<style>
    .admin-page { padding: 32px 20px; max-width: 800px; margin: 0 auto; }
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin-bottom: 24px;
        text-align: center;
    }
    .card-box {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .info-section { margin-bottom: 20px; }
    .info-section h3 { font-family: 'Baloo 2', cursive; font-size: 1.4rem; color: var(--paw-brown); margin-bottom: 12px; border-bottom: 1px solid var(--paw-border); padding-bottom: 5px; }
    .info-grid { display: grid; grid-template-columns: 150px 1fr; gap: 10px; }
    .info-label { font-weight: 800; color: #888; }
    .info-value { font-weight: 700; color: var(--paw-dark); }
    
    .payment-proof { max-width: 100%; border-radius: 14px; border: 2px solid var(--paw-border); margin-top: 10px; }
    .status-banner { text-align: center; padding: 15px; border-radius: 16px; font-weight: 800; font-size: 1.2rem; margin-bottom: 24px; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <h1 class="page-title">🎟️ Booking Details #{{ $booking->id }}</h1>

    <div class="status-banner badge-{{ $booking->status }}">
        Status: {{ ucfirst($booking->status) }}
    </div>

    <div class="card-box">
        <div class="info-section">
            <h3>👤 Customer Information</h3>
            <div class="info-grid">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $booking->user->name }}</div>
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $booking->user->email }}</div>
            </div>
        </div>

        <div class="info-section">
            <h3>🐾 Pet Details</h3>
            <div class="info-grid">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $booking->pet->name ?? ($booking->pet_name ?? '-') }}</div>
                <div class="info-label">Type:</div>
                <div class="info-value">{{ ucfirst($booking->pet->type ?? ($booking->pet_type ?? '-')) }}</div>
                <div class="info-label">Breed:</div>
                <div class="info-value">{{ $booking->pet->breed ?? ($booking->breed ?? '-') }}</div>
            </div>
        </div>

        <div class="info-section">
            <h3>🏠 Reservation Info</h3>
            <div class="info-grid">
                <div class="info-label">Date:</div>
                <div class="info-value">{{ $booking->reservation_date->format('l, d M Y') }}</div>
                <div class="info-label">Package:</div>
                <div class="info-value">{{ ucfirst($booking->pawckage) }}</div>
                <div class="info-label">Cage:</div>
                <div class="info-value">{{ $booking->cage->code }} ({{ $booking->cage->name }})</div>
            </div>
        </div>

        <div class="info-section">
            <h3>💳 Payment Proof</h3>
            @if($booking->payment_proof)
                <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Payment Proof" class="payment-proof">
            @else
                <div class="info-value" style="color:#888;">No payment proof uploaded yet.</div>
            @endif
        </div>
    </div>

    <div style="display:flex; justify-content:center; gap:15px;">
        <a href="{{ route('admin.payment') }}" class="btn-outline-paw">← Back to Payments</a>
        
        @if($booking->status === 'pending')
            <form action="{{ route('admin.payment.confirm', $booking->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-paw">✅ Confirm Booking</button>
            </form>
            <form action="{{ route('admin.payment.confirm', $booking->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-danger-sm" style="padding:14px 30px;">❌ Decline</button>
            </form>
        @endif
    </div>

</div>
</div>
@endsection
