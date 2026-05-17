@extends('layouts.app')

@section('title', 'My Payments - PawResort')

@push('styles')
<style>
    .payment-page {
        padding: 26px 16px;
    }

    /* ===== HEADER ===== */
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--paw-brown);
        text-align: center;
        margin-bottom: 6px;
    }

    .page-tagline {
        text-align: center;
        font-weight: 600;
        color: #888;
        font-size: 0.9rem;
        margin-bottom: 26px;
    }

    /* ===== BOOKING CARD ===== */
    .booking-item {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 20px;
        padding: 18px;
        margin-bottom: 14px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
        transition: 0.2s;
    }

    .booking-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.08);
    }

    .booking-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .booking-pkg {
        font-family: 'Baloo 2', cursive;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--paw-brown);
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.3px;
    }

    .status-pending {
        background: #fff4d6;
        color: #8a6d1d;
    }

    .status-confirmed {
        background: #d7f5e6;
        color: #146c43;
    }

    .status-declined {
        background: #ffe0e3;
        color: #a61b29;
    }

    /* ===== META ===== */
    .booking-date {
        font-family: 'Baloo 2', cursive;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--paw-dark);
        margin-bottom: 4px;
    }

    .booking-meta {
        font-size: 0.82rem;
        font-weight: 600;
        color: #999;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        opacity: 0.75;
    }

    .empty-state p {
        font-weight: 700;
        margin-top: 10px;
    }

    /* ===== BUTTON ===== */
    .btn-paw {
        background: var(--paw-brown);
        color: #fff;
        border-radius: 14px;
        padding: 12px 16px;
        font-weight: 700;
        border: none;
        text-decoration: none;
        display: inline-block;
        transition: 0.2s;
    }

    .btn-paw:hover {
        background: #a85c1a;
        transform: translateY(-2px);
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="payment-page">

    <div class="page-title">My Payments 💳</div>
    <div class="page-tagline">Track your booking status in real time</div>

    @forelse($bookings as $booking)
        <div class="booking-item">

            <div class="booking-item-header">
                <div class="booking-pkg">
                    {{ ucfirst($booking->pawckage) }} Pawckage
                </div>

                <span class="status-badge status-{{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div class="booking-date">
                📅 {{ \Carbon\Carbon::parse($booking->reservation_date)->format('d M Y') }}
            </div>

            <div class="booking-meta">
                Booked: {{ $booking->created_at->format('d M Y H:i') }}
            </div>

        </div>
    @empty
        <div class="empty-state">
            <div style="font-size:3.5rem;">🐾</div>
            <p>No bookings yet!</p>
            <a href="{{ route('user.booking') }}" class="btn-paw mt-2">
                Book Now
            </a>
        </div>
    @endforelse

    @if($bookings->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $bookings->links() }}
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('user.booking') }}" class="btn-paw w-100 text-center">
            + New Booking
        </a>
    </div>

</div>
</div>
@endsection