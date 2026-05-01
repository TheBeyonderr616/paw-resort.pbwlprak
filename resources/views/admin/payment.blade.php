@extends('layouts.app')

@section('title', 'My Payments - PawResort')

@push('styles')
<style>
    .payment-page { padding: 20px 16px; }
    .page-title { font-family:'Baloo 2',cursive; font-size:2rem; font-weight:800; color:var(--paw-brown); text-align:center; margin-bottom:4px; }
    .page-tagline { text-align:center; font-weight:700; color:#888; font-size:0.85rem; margin-bottom:24px; }

    .booking-item {
        background: #fff;
        border: 2.5px solid var(--paw-border);
        border-radius: 18px;
        padding: 16px;
        margin-bottom: 14px;
    }
    .booking-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .booking-pkg {
        font-family: 'Baloo 2', cursive;
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--paw-brown);
    }
    .status-badge {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
    }
    .status-pending  { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d1e7dd; color: #0a5c36; }
    .status-declined { background: #f8d7da; color: #842029; }

    .booking-meta { font-size:0.82rem; font-weight:600; color:#888; }
    .booking-date { font-family:'Courier New', monospace; font-size:0.85rem; font-weight:700; color:var(--paw-dark); }

    .empty-state { text-align:center; padding:40px 20px; opacity:0.6; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="payment-page">

    <div class="page-title">My Payments 💳</div>
    <div class="page-tagline">Track your booking status</div>

    @forelse($bookings as $booking)
    <div class="booking-item">
        <div class="booking-item-header">
            <div class="booking-pkg">{{ ucfirst($booking->pawckage) }} Pawckage</div>
            <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
        </div>
        <div class="booking-date">📅 {{ \Carbon\Carbon::parse($booking->reservation_date)->format('d M Y') }}</div>
        <div class="booking-meta mt-1">Booked: {{ $booking->created_at->format('d M Y H:i') }}</div>
    </div>
    @empty
    <div class="empty-state">
        <div style="font-size:3rem; margin-bottom:10px;">🐾</div>
        <p style="font-weight:700;">No bookings yet!</p>
        <a href="{{ route('user.booking') }}" class="btn-paw btn px-4">Book Now</a>
    </div>
    @endforelse

    @if($bookings->hasPages())
    <div class="d-flex justify-content-center mt-3">{{ $bookings->links() }}</div>
    @endif

    <div class="mt-3">
        <a href="{{ route('user.booking') }}" class="btn-paw btn w-100">+ New Booking</a>
    </div>
</div>
</div>
@endsection