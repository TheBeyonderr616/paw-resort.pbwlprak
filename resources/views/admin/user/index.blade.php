@extends('layouts.app')

@section('title', 'Manage Users - PawResort')

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
    .badge-role {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .badge-admin { background: #ffe0b2; color: #fb8c00; }
    .badge-user { background: #e1f5fe; color: #039be5; }

    .btn-action {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-edit { background: #fff3e0; color: #f57c00; margin-right: 5px; }
    .btn-edit:hover { background: #f57c00; color: #fff; }
    .btn-delete { background: #ffebee; color: #d32f2f; }
    .btn-delete:hover { background: #d32f2f; color: #fff; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <div class="page-header">
        <h1 class="page-title">👥 Manage Users</h1>
        <div style="display:flex; gap:15px; align-items:center;">
            <a href="{{ route('admin.user.create') }}" class="btn-paw-sm">➕ Create New User</a>
            <form action="{{ route('admin.user.index') }}" method="GET" style="display:flex; gap:10px;">
                <input type="text" name="search" class="paw-input" placeholder="Search name or email..." value="{{ request('search') }}" style="width:250px; padding: 10px 15px;">
                <button type="submit" class="btn-paw-sm">Search</button>
            </form>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge-role {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action btn-edit">Edit</a>
                            
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 40px; color:#888;">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $users->links() }}
        </div>
    </div>

</div>
</div>
@endsection
