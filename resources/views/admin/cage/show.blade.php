@extends('layouts.app')

@section('title', 'Cage Details - PawResort')

@push('styles')
<style>
    .admin-page { padding: 32px 20px; }
    .page-header { margin-bottom: 24px; }
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0;
    }
    .card-box {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .info-item label { font-weight: 800; color: #888; display: block; margin-bottom: 5px; }
    .info-item span { font-weight: 700; font-size: 1.2rem; color: var(--paw-dark); }
    
    .history-title { font-family: 'Baloo 2', cursive; font-size: 1.8rem; font-weight: 800; margin-bottom: 16px; }
    .table-custom { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .table-custom th { text-align: left; padding: 12px 18px; font-weight: 800; color: #888; }
    .table-custom tr td { background: #fdfdfd; border-top: 2px solid var(--paw-border); border-bottom: 2px solid var(--paw-border); padding: 16px 18px; font-weight: 700; }
    .table-custom tr td:first-child { border-left: 2px solid var(--paw-border); border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .table-custom tr td:last-child { border-right: 2px solid var(--paw-border); border-top-right-radius: 14px; border-bottom-right-radius: 14px; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <div class="page-header">
        <h1 class="page-title">🏠 Cage Details: {{ $cage->code }}</h1>
    </div>

    <div class="card-box">
        <div class="info-grid">
            <div class="info-item">
                <label>Code</label>
                <span>{{ $cage->code }}</span>
            </div>
            <div class="info-item">
                <label>Name</label>
                <span>{{ $cage->name }}</span>
            </div>
            <div class="info-item">
                <label>Type</label>
                <span style="text-transform: capitalize;">{{ $cage->type }}</span>
            </div>
            <div class="info-item">
                <label>Current Status</label>
                <span class="badge-{{ $cage->status }}">{{ ucfirst($cage->status) }}</span>
            </div>
        </div>
    </div>

    <h2 class="history-title">📅 Usage History</h2>
    <div class="card-box">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Pet</th>
                    <th>Date</th>
                    <th>Package</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cage->bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->pet->name ?? '-' }}</td>
                    <td>{{ $booking->reservation_date->format('d M Y') }}</td>
                    <td>{{ ucfirst($booking->pawckage) }}</td>
                    <td><span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 40px; color:#888;">No usage history found for this cage.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.cage.index') }}" class="btn-paw-sm">← Back to List</a>

</div>
</div>
@endsection
