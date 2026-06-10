@extends('layouts.app')

@section('title', 'All Pets - PawResort')

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
    .card-box {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
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
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .table-custom tr td {
        background: #fdfdfd;
        border-top: 2px solid var(--paw-border);
        border-bottom: 2px solid var(--paw-border);
        padding: 16px 18px;
        font-weight: 700;
        color: var(--paw-dark);
    }
    .table-custom tr td:first-child {
        border-left: 2px solid var(--paw-border);
        border-top-left-radius: 14px;
        border-bottom-left-radius: 14px;
    }
    .table-custom tr td:last-child {
        border-right: 2px solid var(--paw-border);
        border-top-right-radius: 14px;
        border-bottom-right-radius: 14px;
    }
    .pet-icon { font-size: 1.5rem; margin-right: 8px; }
    .owner-link { color: var(--paw-brown); text-decoration: none; }
    .owner-link:hover { text-decoration: underline; }

    .btn-delete {
        background: #ffebee;
        color: #d32f2f;
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-delete:hover { background: #d32f2f; color: #fff; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <div class="page-header">
        <h1 class="page-title">🐾 All Registered Pets</h1>
        <form action="{{ route('admin.pet.index') }}" method="GET" style="display:flex; gap:10px;">
            <input type="text" name="search" class="paw-input" placeholder="Search pet or owner..." value="{{ request('search') }}" style="width:250px; padding: 10px 15px;">
            <button type="submit" class="btn-paw-sm">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-4" style="font-weight:700;">{{ session('success') }}</div>
    @endif

    <div class="card-box">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Type</th>
                    <th>Breed</th>
                    <th>Owner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pets as $pet)
                <tr>
                    <td>
                        <span class="pet-icon">
                            @if($pet->type === 'dog') 🐕 @elseif($pet->type === 'cat') 🐈 @elseif($pet->type === 'rabbit') 🐇 @else 🐾 @endif
                        </span>
                        {{ $pet->name }}
                    </td>
                    <td style="text-transform: capitalize;">{{ $pet->type }}</td>
                    <td>{{ $pet->breed }}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $pet->user->id) }}" class="owner-link">
                            {{ $pet->user->name }}
                        </a>
                        <div style="font-size: 0.8rem; color: #888; font-weight: 600;">{{ $pet->user->email }}</div>
                    </td>
                    <td>
                        <form action="{{ route('admin.pet.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this pet?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Remove</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 40px; color:#888;">No pets found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $pets->links() }}
        </div>
    </div>

</div>
</div>
@endsection
