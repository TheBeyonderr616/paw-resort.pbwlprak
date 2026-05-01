@extends('layouts.app')

@section('title', 'Payment Validation - PawResort Admin')

@push('styles')
<style>
    .payment-page { 
        padding: 24px 16px; 
    }
    
    .page-title { 
        font-family: 'Baloo 2', cursive; 
        font-size: 2.2rem; 
        font-weight: 800; 
        color: #d18854; 
        text-align: center; 
        margin-bottom: 4px; 
    }
    
    .page-tagline { 
        text-align: center; 
        font-family: 'Courier New', Courier, monospace; 
        font-weight: 700; 
        color: #4a6572; 
        font-size: 0.85rem; 
        margin-bottom: 24px; 
    }

    .stats-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 24px;
    }
    .stat-box {
        flex: 1;
        border: 2px solid #d18854;
        border-radius: 16px;
        text-align: center;
        background: #fff;
        overflow: hidden;
    }
    .stat-header {
        background: #e3a67d;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-value {
        padding: 8px 0;
        font-family: 'Baloo 2', cursive;
        font-size: 1.2rem;
        font-weight: 700;
        color: #444;
    }

    /* Transaction Cards */
    .validation-card {
        background: #fffafa;
        border: 2px solid #e3a67d;
        border-radius: 20px;
        padding: 16px;
        margin-bottom: 16px;
        position: relative;
    }
    .card-top {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }
    .pet-img {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        background: #eee;
    }
    .pet-details {
        flex: 1;
        position: relative;
    }
    .pet-name {
        font-family: 'Baloo 2', cursive;
        font-size: 1.8rem;
        font-weight: 800;
        color: #d18854;
        line-height: 1;
        margin-bottom: 10px;
    }
    .paw-watermark {
        position: absolute;
        top: -5px;
        right: 0;
        font-size: 2.5rem;
        color: #e3cbbb;
        opacity: 0.5;
        line-height: 1;
    }
    
    .detail-row {
        display: flex;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.8rem;
        font-weight: 700;
        color: #555;
        margin-bottom: 4px;
    }
    .detail-label {
        width: 80px;
    }
    .detail-colon {
        width: 15px;
    }
    .detail-value {
        flex: 1;
    }

    /* Tombol Action */
    .action-buttons {
        display: flex;
        gap: 12px;
    }
    .btn-action {
        flex: 1;
        border: none;
        border-radius: 50px;
        padding: 10px 0;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s;
        color: #fff;
    }
    .btn-decline {
        background: #e3a67d; 
    }
    .btn-decline:hover { background: #d4956a; }
    
    .btn-confirm {
        background: #d18854; 
    }
    .btn-confirm:hover { background: #b87545; }

    .empty-state { text-align:center; padding:40px 20px; opacity:0.6; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="payment-page">

    <div class="page-title">Payment Validation</div>
    <div class="page-tagline">Review and Confirm Pending Transactions</div>

    <div class="stats-wrapper">
        <div class="stat-box">
            <div class="stat-header">Confirm</div>
            <div class="stat-value">{{ $pendingCount ?? 12 }}</div> 
        </div>
        <div class="stat-box">
            <div class="stat-header">Validated</div>
            <div class="stat-value">{{ $validatedCount ?? 82 }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-header">Amount</div>
            <div class="stat-value">{{ $totalAmount ?? '950k' }}</div>
        </div>
    </div>

    @forelse($bookings as $booking)
    <div class="validation-card">
        <div class="card-top">
            <img src="{{ $booking->pet->image_url ?? asset('images/default-pet.png') }}" alt="Pet Image" class="pet-img">
            
            <div class="pet-details">
                <div class="paw-watermark">🐾</div>
                <div class="pet-name">{{ $booking->pet->name ?? 'Unknown Pet' }}</div>
                
                <div class="detail-row">
                    <div class="detail-label">Breed</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">{{ $booking->pet->breed ?? '-' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Owner</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">{{ $booking->user->name ?? '-' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Pawckage</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">{{ ucfirst($booking->pawckage) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-value" style="margin-top: 4px; color:#888;">
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y - H.i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <form action="{{ route('admin.payment.decline', $booking->id) }}" method="POST" style="flex: 1;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-action btn-decline w-100">Decline</button>
            </form>

            <form action="{{ route('admin.payment.confirm', $booking->id) }}" method="POST" style="flex: 1;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-action btn-confirm w-100">Confirm</button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div style="font-size:3rem; margin-bottom:10px;">🐾</div>
        <p style="font-weight:700;">No pending payments to validate!</p>
    </div>
    @endforelse

    @if(isset($bookings) && $bookings->hasPages())
    <div class="d-flex justify-content-center mt-3">{{ $bookings->links() }}</div>
    @endif

</div>
</div>
@endsection