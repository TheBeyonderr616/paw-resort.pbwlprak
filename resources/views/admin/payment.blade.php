@extends('layouts.app')
@section('title', 'Payment Validation - PawResort Admin')

@push('styles')
<style>
.stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px; }
.stat-box { background:#fff; border:2px solid var(--paw-border); border-radius:22px; padding:28px; text-align:center; }
.stat-box .stat-label { font-size:1rem; font-weight:800; color:#999; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }
.stat-box .stat-value { font-family:'Baloo 2',cursive; font-size:3rem; font-weight:800; color:var(--paw-brown); }

.booking-card {
    background:#fff;
    border:2px solid var(--paw-border);
    border-radius:22px;
    padding:28px 32px;
    margin-bottom:18px;
    box-shadow:0 4px 14px var(--paw-shadow);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
}
.booking-info {
    flex:1;
    font-size:1.5rem;
    line-height:1.9;
}
.booking-name { font-family:'Baloo 2',cursive; font-size:1.85rem; font-weight:800; color:var(--paw-brown); }
.booking-meta { font-size:1.3rem; color:#666; font-weight:700; margin-top:8px; line-height:2.1; }
.action-btns { display:flex; gap:12px; flex-shrink:0; }
.btn-confirm { background:var(--paw-green); color:#fff; border:none; border-radius:20px; padding:12px 28px; font-weight:800; font-size:1rem; cursor:pointer; transition:.2s; }
.btn-confirm:hover { background:#3a9463; }
.btn-decline { background:var(--paw-red); color:#fff; border:none; border-radius:20px; padding:12px 28px; font-weight:800; font-size:1rem; cursor:pointer; transition:.2s; }
.btn-decline:hover { background:#c04444; }
.btn-delete { background:#888; color:#fff; border:none; border-radius:20px; padding:12px 20px; font-weight:800; font-size:1rem; cursor:pointer; transition:.2s; }
.btn-delete:hover { background:#555; }

.empty-state { text-align:center; padding:80px 20px; opacity:.65; }
</style>
@endpush

@section('content')
<div class="page-title">Payment Validation 💳</div>
<div class="page-tagline">Review and confirm pending transactions</div>

@if(session('success'))
    <div class="alert paw-alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $pendingCount }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Confirmed</div>
        <div class="stat-value">{{ $validatedCount }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Revenue</div>
        <div class="stat-value">{{ $totalAmount }}</div>
    </div>
</div>

@forelse($bookings as $booking)
<div class="booking-card">
    <div style="font-size:3rem;">
        {{ $booking->pawckage==='vip'?'👑':($booking->pawckage==='weekly'?'📅':'🐾') }}
    </div>
    <div class="booking-info">
        <div class="booking-name">{{ $booking->user->name ?? 'Unknown' }}</div>
        <div class="booking-meta">
            📦 {{ ucfirst($booking->pawckage) }} Package<br>
            📅 {{ \Carbon\Carbon::parse($booking->reservation_date)->format('d M Y') }}<br>
            🏠 Cage: {{ $booking->cage->code ?? '-' }}<br>
            🕐 Booked: {{ $booking->created_at->format('d M Y H:i') }}
        </div>
    </div>
    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;">
        <span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
        <div class="action-btns">
            @if($booking->status === 'pending')
                <form method="POST" action="{{ route('admin.payment.confirm', $booking->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-confirm">✅ Confirm</button>
                </form>
                <form method="POST" action="{{ route('admin.payment.decline', $booking->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-decline">❌ Decline</button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.booking.destroy', $booking->id) }}"
                onsubmit="return confirm('Delete this booking?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">🗑️</button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="empty-state">
    <div style="font-size:5rem;">🐾</div>
    <p style="font-weight:800;font-size:1.3rem;margin-top:16px;">No bookings found!</p>
</div>
@endforelse

@if($bookings->hasPages())
    <div class="d-flex justify-content-center mt-4">{{ $bookings->links() }}</div>
@endif
@endsection