@extends('layouts.app')

@section('title', 'Register Pet - PawResort')

@push('styles')
<style>
    .pet-reg-page {
        padding: 26px 16px;
    }

    /* ===== HEADER ===== */
    .page-title {
        font-family: 'Baloo 2', cursive;
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--paw-brown);
        text-align: center;
        margin-bottom: 6px;
    }

    .page-tagline {
        text-align: center;
        font-weight: 600;
        color: #777;
        font-size: 0.9rem;
        margin-bottom: 26px;
    }

    /* ===== CARD FORM ===== */
    .paw-card {
        background: #fff;
        border: 2px solid var(--paw-border);
        border-radius: 22px;
        padding: 18px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    }

    /* ===== LABEL ===== */
    .form-label-paw {
        font-weight: 800;
        font-size: 0.85rem;
        color: var(--paw-dark);
        margin-bottom: 6px;
        display: block;
    }

    /* ===== INPUT ===== */
    .paw-input {
        width: 100%;
        padding: 12px 14px;
        border-radius: 14px;
        border: 2px solid var(--paw-border);
        font-size: 0.9rem;
        outline: none;
        transition: 0.2s;
    }

    .paw-input:focus {
        border-color: var(--paw-brown);
        box-shadow: 0 0 0 3px rgba(232, 149, 58, 0.15);
    }

    /* ===== TYPE GRID ===== */
    .type-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }

    .type-btn {
        border: 2px solid var(--paw-border);
        border-radius: 16px;
        padding: 10px 6px;
        text-align: center;
        cursor: pointer;
        font-size: 0.72rem;
        font-weight: 700;
        background: #fff;
        transition: all .2s ease;
        user-select: none;
    }

    .type-btn .type-icon {
        display: block;
        font-size: 1.6rem;
        margin-bottom: 4px;
    }

    .type-btn:hover {
        transform: translateY(-2px);
        border-color: var(--paw-brown);
    }

    .type-btn.selected {
        border-color: var(--paw-brown);
        background: var(--paw-cream);
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
    }

    input[name="type"] {
        display: none;
    }

    /* ===== PET LIST ===== */
    .pet-list {
        margin-top: 26px;
    }

    .pet-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--paw-cream);
        border: 2px solid var(--paw-border);
        border-radius: 16px;
        padding: 12px 14px;
        margin-bottom: 10px;
        transition: 0.2s;
    }

    .pet-list-item:hover {
        transform: scale(1.01);
        background: #fff3e6;
    }

    .pet-list-emoji {
        font-size: 2rem;
    }

    .pet-list-name {
        font-weight: 800;
        font-size: 0.95rem;
    }

    .pet-list-breed {
        font-size: 0.8rem;
        color: #888;
        font-weight: 600;
    }

    /* ===== BUTTON ===== */
    .btn-paw {
        background: var(--paw-brown);
        color: #fff;
        border-radius: 14px;
        padding: 12px 16px;
        font-weight: 800;
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

    /* ===== ALERT ===== */
    .paw-alert {
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="pet-reg-page">

    <div class="page-title">Register Pet 🐾</div>
    <div class="page-tagline">Add your furry family members</div>

    @if(session('success'))
        <div class="alert paw-alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="paw-card">
        <form method="POST" action="{{ route('user.register-pet') }}">
            @csrf

            <label class="form-label-paw">Pet Name</label>
            <div class="mb-3">
                <input type="text" name="name" class="paw-input"
                    placeholder="e.g. Luna, Mochi..." value="{{ old('name') }}" required>
            </div>

            <label class="form-label-paw">Breed</label>
            <div class="mb-3">
                <input type="text" name="breed" class="paw-input"
                    placeholder="e.g. Shiba Inu, Domestic Cat..." value="{{ old('breed') }}" required>
            </div>

            <label class="form-label-paw">Pet Type</label>

            <div class="type-grid" id="typeGrid">
                @foreach([
                    ['dog','🐕','Dog'],
                    ['cat','🐱','Cat'],
                    ['hamster','🐹','Hamster'],
                    ['rabbit','🐰','Rabbit'],
                    ['other','🐾','Other']
                ] as [$val,$icon,$label])
                    <div class="type-btn {{ old('type','dog') === $val ? 'selected' : '' }}"
                        onclick="selectType('{{ $val }}', this)">
                        <span class="type-icon">{{ $icon }}</span>
                        {{ $label }}
                    </div>
                @endforeach
            </div>

            <input type="hidden" name="type" id="typeInput"
                value="{{ old('type', 'dog') }}" required>

            @if($errors->any())
                <div class="alert paw-alert alert-danger mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="btn-paw w-100 mt-2">
                Register Pet 🐾
            </button>
        </form>
    </div>

    @if(count($pets) > 0)
    <div class="pet-list">
        <h6 style="color:var(--paw-brown); font-weight:800; margin:18px 0 10px;">
            Your Pets
        </h6>

        @foreach($pets as $pet)
        <div class="pet-list-item">
            <span class="pet-list-emoji">
                {{ $pet->type === 'dog' ? '🐕' : ($pet->type === 'cat' ? '🐱' : ($pet->type === 'hamster' ? '🐹' : ($pet->type === 'rabbit' ? '🐰' : '🐾'))) }}
            </span>

            <div>
                <div class="pet-list-name">{{ $pet->name }}</div>
                <div class="pet-list-breed">{{ $pet->breed }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
</div>
@endsection

@push('scripts')
<script>
    function selectType(val, el) {
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('typeInput').value = val;
    }

    const initial = document.getElementById('typeInput').value;
    document.querySelectorAll('.type-btn').forEach((btn) => {
        const types = ['dog','cat','hamster','rabbit','other'];
        if(types.includes(initial) && btn.textContent.toLowerCase().includes(initial)) {
            btn.classList.add('selected');
        }
    });
</script>
@endpush