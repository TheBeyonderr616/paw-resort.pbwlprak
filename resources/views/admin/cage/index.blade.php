@extends('layouts.app')

@section('title', 'Cage Management - PawResort')

@push('styles')
<style>
    .admin-page { padding: 32px 20px; }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin: 0;
    }
    .btn-add {
        background: var(--paw-brown);
        color: #fff;
        padding: 12px 20px;
        border-radius: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-add:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 123, 91, 0.3); }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 26px;
    }
    .stat-badge {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 18px;
        padding: 16px;
        text-align: center;
    }
    .stat-badge .label { font-size: 0.9rem; font-weight: 700; color: #888; }
    .stat-badge .value { font-family: 'Baloo 2', cursive; font-size: 1.8rem; font-weight: 800; color: var(--paw-dark); }
    .stat-badge.occupied .value { color: #c17a5a; }
    .stat-badge.available .value { color: var(--paw-green); }

    .card-box {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 24px;
    }
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .table-custom th {
        text-align: left;
        padding: 12px 18px;
        font-weight: 800;
        color: #888;
    }
    .table-custom tr td {
        background: #fdfdfd;
        border-top: 2px solid var(--paw-border);
        border-bottom: 2px solid var(--paw-border);
        padding: 16px 18px;
        font-weight: 700;
    }
    .table-custom tr td:first-child { border-left: 2px solid var(--paw-border); border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .table-custom tr td:last-child { border-right: 2px solid var(--paw-border); border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .badge-status {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .badge-available { background: #e8f5e9; color: #2e7d32; }
    .badge-occupied { background: #efebe9; color: #5d4037; }
    .badge-locked { background: #ffebee; color: #c62828; }

    .btn-action {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .btn-edit { background: #fff3e0; color: #f57c00; margin-right: 5px; }
    .btn-delete { background: #ffebee; color: #d32f2f; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <div class="page-header">
        <h1 class="page-title">🏠 Cage Management</h1>
        <div style="display:flex; gap:10px; align-items:center;">
            <form action="{{ route('admin.cage.index') }}" method="GET" style="display:flex; gap:10px;">
                <input type="text" name="search" class="paw-input" placeholder="Search code/name..." value="{{ request('search') }}" style="width:200px; padding: 10px 15px;">
                <button type="submit" class="btn-paw-sm">Search</button>
            </form>
            <a href="{{ route('admin.cage.create') }}" class="btn-add">+ Add New</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-badge">
            <div class="label">Total Cages</div>
            <div class="value">{{ $totalCages }}</div>
        </div>
        <div class="stat-badge occupied">
            <div class="label">Occupied</div>
            <div class="value">{{ $occupiedCount }}</div>
        </div>
        <div class="stat-badge available">
            <div class="label">Available</div>
            <div class="value">{{ $availableCount }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-4" style="font-weight:700;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4 mb-4" style="font-weight:700;">{{ session('error') }}</div>
    @endif

    <div class="card-box">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cages as $cage)
                <tr>
                    <td>{{ $cage->code }}</td>
                    <td>{{ $cage->name }}</td>
                    <td style="text-transform: capitalize;">{{ $cage->type }}</td>
                    <td>
                        <span class="badge-status badge-{{ $cage->status }}">
                            {{ $cage->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;">
                            <a href="{{ route('admin.cage.show', $cage->id) }}" class="btn-action" style="background:#e3f2fd; color:#1565c0; margin-right:5px;">Details</a>
                            <a href="{{ route('admin.cage.edit', $cage->id) }}" class="btn-action btn-edit">Edit</a>
                            <form action="{{ route('admin.cage.destroy', $cage->id) }}" method="POST" onsubmit="return confirm('Delete this cage?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 40px; color:#888;">No cages found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $cages->links() }}
        </div>
    </div>

</div>
</div>
@endsection
