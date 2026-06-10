@extends('layouts.app')

@section('title', 'Create User - PawResort')

@section('content')
<div class="page-wrapper" style="max-width: 700px; margin: 0 auto;">
    <div class="paw-card">
        <h1 class="page-title">➕ Create New User</h1>
        <p class="page-tagline">Register a new user or administrator</p>

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label-paw">Full Name</label>
                <input type="text" name="name" class="paw-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label-paw">Email Address</label>
                <input type="email" name="email" class="paw-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label-paw">Role</label>
                <select name="role" class="paw-select @error('role') is-invalid @enderror" required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label-paw">Password</label>
                    <input type="password" name="password" class="paw-input @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-paw">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="paw-input" required>
                </div>
            </div>

            <div class="mt-4" style="display:flex; gap:15px;">
                <button type="submit" class="btn-paw" style="flex:1;">Save User</button>
                <a href="{{ route('admin.user.index') }}" class="btn-outline-paw" style="padding: 14px 30px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
