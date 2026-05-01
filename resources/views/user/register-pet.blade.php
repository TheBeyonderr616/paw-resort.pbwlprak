@extends('layouts.app')

@section('title', 'Register Pet - PawResort')

@push('styles')
<style>
    .pet-reg-page { padding: 20px 16px; }
    .page-title { font-family:'Baloo 2',cursive; font-size:2rem; font-weight:800; color:var(--paw-brown); text-align:center; margin-bottom:4px; }
    .page-tagline { text-align:center; font-weight:700; color:var(--paw-teal); font-size:0.9rem; margin-bottom:24px; }

    .form-label-paw { font-weight:800; font-size:0.85rem; color:var(--paw-dark); margin-bottom:6px; display:block; }

    .type-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }
    .type-btn {
        border: 2px solid var(--paw-border);
        border-radius: 14px;
        padding: 10px 4px;
        text-align: center;
        cursor: pointer;
        font-size: 0.7rem;
        font-weight: 700;
        background: #fff;
        transition: all .2s;
    }
    .type-btn .type-icon { display:block; font-size:1.5rem; margin-bottom:2px; }
    .type-btn:hover, .type-btn.selected {
        border-color: var(--paw-brown);
        background: var(--paw-cream);
    }
    input[name="type"] { display:none; }

    .pet-list { margin-top: 24px; }
    .pet-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--paw-cream);
        border: 2px solid var(--paw-border);
        border-radius: 14px;
        padding: 12px 16px;
        margin-bottom: 10px;
    }
    .pet-list-emoji { font-size:2rem; }
    .pet-list-name { font-weight:800; font-size:0.95rem; }
    .pet-list-breed { font-size:0.8rem; color:#888; font-weight:600; }
</style>
@endpush

@section('content')
<div class="page-wrapper">
<div class="pet-reg-page">

    <div class="page-title">Register Pet 🐾</div>
    <div class="page-tagline">Do your other pets wanna play with us too?</div>

    @if(session('success'))
    <div class="alert paw-alert alert-success mb-3">{{ session('success') }}</div>
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
                @foreach([['dog','🐕','Dog'],['cat','🐱','Cat'],['hamster','🐹','Hamster'],['rabbit','🐰','Rabbit'],['other','🐾','Other']] as [$val,$icon,$label])
                <div class="type-btn {{ old('type') === $val ? 'selected' : '' }}"
                    onclick="selectType('{{ $val }}', this)">
                    <span class="type-icon">{{ $icon }}</span>
                    {{ $label }}
                </div>
                @endforeach
            </div>
            <input type="hidden" name="type" id="typeInput" value="{{ old('type', 'dog') }}" required>

            @if($errors->any())
            <div class="alert paw-alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <button type="submit" class="btn-paw btn w-100 mt-2">Register Pet 🐾</button>
        </form>
    </div>

    <!-- Registered Pets -->
    @if(count($pets) > 0)
    <div class="pet-list">
        <h6 class="paw-font fw-bold mb-3" style="color:var(--paw-brown);">Your Pets</h6>
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
    // Set initial selection
    const initial = document.getElementById('typeInput').value;
    document.querySelectorAll('.type-btn').forEach((btn, i) => {
        const types = ['dog','cat','hamster','rabbit','other'];
        if(types[i] === initial) btn.classList.add('selected');
    });
</script>
@endpush