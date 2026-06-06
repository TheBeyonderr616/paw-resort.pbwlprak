@extends('layouts.app')
@section('title', 'My Payments - PawResort')

@push('styles')
<style>
.booking-card {
    background:#fff;
    border:2px solid var(--paw-border);
    border-radius:22px;
    padding:28px 32px;
    margin-bottom:18px;
    box-shadow:0 4px 16px var(--paw-shadow);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    transition:.2s;
}
.booking-card:hover { transform:translateY(-3px); box-shadow:0 10px 28px var(--paw-shadow); }

.booking-left { display:flex; align-items:center; gap:22px; }
.pkg-icon { font-size:3rem; }
.pkg-name { font-family:'Baloo 2',cursive; font-size:1.7rem; font-weight:800; color:var(--paw-brown); }
.booking-meta { font-size:1rem; color:#999; font-weight:700; margin-top:4px; }

.booking-right { display:flex; flex-direction:column; align-items:flex-end; gap:12px; }

.empty-state { text-align:center; padding:80px 20px; opacity:.65; }
</style>
@endpush

@section('content')
<div class="page-title">My Payments 💳</div>
<div class="page-tagline">Track and manage your bookings</div>

@if(session('success'))
    <div class="alert paw-alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div style="margin-bottom:24px;">
    <a href="{{ route('user.booking') }}" class="btn-paw">+ New Booking</a>
</div>

@forelse($bookings as $booking)
<div class="booking-card">
    <div class="booking-left">
        <div class="pkg-icon">
            {{ $booking->pawckage==='vip' ? '👑' : ($booking->pawckage==='weekly' ? '📅' : '🐾') }}
        </div>
        <div>
            <div class="pkg-name">{{ ucfirst($booking->pawckage) }} Package</div>
            <div class="booking-meta">
                📅 {{ \Carbon\Carbon::parse($booking->reservation_date)->format('d M Y') }}
                &nbsp;·&nbsp; Booked {{ $booking->created_at->diffForHumans() }}
            </div>
            @if($booking->cage)
                <div class="booking-meta" style="margin-top:2px;">🏠 Cage: {{ $booking->cage->code }}</div>
            @endif
        </div>
    </div>
    <div class="booking-right">
        <span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>

        @if($booking->status === 'pending')
        <form method="POST" action="{{ route('user.booking.cancel', $booking->id) }}"
            onsubmit="return confirm('Cancel this booking?')">
            @csrf @method('PATCH')
            <button type="submit" class="btn-danger-sm">Cancel</button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <div style="font-size:5rem;">🐾</div>
    <p style="font-weight:800;font-size:1.3rem;margin-top:16px;">No bookings yet!</p>
    <a href="{{ route('user.booking') }}" class="btn-paw mt-3">Book Now</a>
</div>
@endforelse

@if($bookings->hasPages())
    <div class="d-flex justify-content-center mt-4">{{ $bookings->links() }}</div>
@endif
@endsection