@extends('layouts.app')

@section('title', 'Add Cage - PawResort')

@push('styles')
<style>
    .admin-page { padding: 32px 20px; max-width: 600px; margin: 0 auto; }
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--paw-brown);
        margin-bottom: 24px;
        text-align: center;
    }
    .card-box {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .form-group { margin-bottom: 20px; }
    .label {
        display: block;
        font-weight: 800;
        color: var(--paw-dark);
        margin-bottom: 8px;
        font-size: 1rem;
    }
    .input-field {
        width: 100%;
        padding: 14px 18px;
        border-radius: 14px;
        border: 2px solid var(--paw-border);
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .input-field:focus {
        border-color: var(--paw-brown);
        outline: none;
        box-shadow: 0 0 0 4px rgba(168, 123, 91, 0.1);
    }
    .btn-submit {
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        background: var(--paw-brown);
        color: #fff;
        border: none;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 10px;
    }
    .btn-submit:hover { background: #8a5e3e; transform: translateY(-2px); }
    .btn-back {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #888;
        text-decoration: none;
        font-weight: 700;
    }
    .btn-back:hover { color: var(--paw-brown); }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="admin-page">

    <h1 class="page-title">➕ Add New Cage</h1>

    <div class="card-box">
        <form action="{{ route('admin.cage.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="label">Cage Code (e.g. A-01)</label>
                <input type="text" name="code" class="input-field" placeholder="A-01" value="{{ old('code') }}" required>
                @error('code') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="label">Display Name</label>
                <input type="text" name="name" class="input-field" placeholder="Unit A-01" value="{{ old('name') }}" required>
                @error('name') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="label">Type</label>
                <select name="type" class="input-field" required>
                    <option value="standard" {{ old('type') === 'standard' ? 'selected' : '' }}>Standard</option>
                    <option value="vip" {{ old('type') === 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
                @error('type') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Register Cage</button>
        </form>
    </div>

    <a href="{{ route('admin.cage.index') }}" class="btn-back">← Back to Management</a>

</div>
</div>
@endsection
