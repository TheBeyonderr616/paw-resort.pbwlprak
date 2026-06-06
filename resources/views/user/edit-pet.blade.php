@extends('layouts.app')
@section('title', 'Edit Pet - PawResort')

@push('styles')
<style>
.type-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:20px; }
.type-btn {
    border:2.5px solid var(--paw-border); border-radius:20px; padding:16px 8px;
    text-align:center; cursor:pointer; font-size:.9rem; font-weight:800;
    background:#fff; transition:all .2s;
}
.type-btn .type-icon { display:block; font-size:2.2rem; margin-bottom:8px; }
.type-btn:hover { transform:translateY(-3px); border-color:var(--paw-brown); }
.type-btn.selected { border-color:var(--paw-brown); background:var(--paw-cream); box-shadow:0 6px 16px var(--paw-shadow); }
</style>
@endpush

@section('content')
<div style="max-width:680px;margin:0 auto;">
    <div class="page-title">Edit Pet ✏️</div>
    <div class="page-tagline">Update your pet's information</div>

    <div class="paw-card">
        <form method="POST" action="{{ route('user.pet.update', $pet->id) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="form-label-paw">🐾 Pet Name</label>
                <input type="text" name="name" class="paw-input"
                    value="{{ old('name', $pet->name) }}" required>
                @error('name')<div style="color:var(--paw-red);font-weight:700;margin-top:6px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label-paw">🔍 Breed</label>
                <input type="text" name="breed" class="paw-input"
                    value="{{ old('breed', $pet->breed) }}" required>
                @error('breed')<div style="color:var(--paw-red);font-weight:700;margin-top:6px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label-paw">🐾 Pet Type</label>
                <div class="type-grid">
                    @foreach([['dog','🐕','Dog'],['cat','🐱','Cat'],['hamster','🐹','Hamster'],['rabbit','🐰','Rabbit'],['other','🐾','Other']] as [$val,$icon,$lbl])
                        <div class="type-btn {{ old('type',$pet->type)===$val?'selected':'' }}"
                            onclick="selectType('{{ $val }}',this)">
                            <span class="type-icon">{{ $icon }}</span>{{ $lbl }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="type" id="typeInput" value="{{ old('type',$pet->type) }}" required>
            </div>

            <div style="display:flex;gap:14px;">
                <a href="{{ route('user.register-pet') }}" class="btn-outline-paw" style="flex:1;text-align:center;padding:14px;">
                    ← Cancel
                </a>
                <button type="submit" class="btn-paw" style="flex:2;font-size:1.1rem;padding:14px;">
                    Save Changes ✅
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectType(val,el){
    document.querySelectorAll('.type-btn').forEach(b=>b.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('typeInput').value=val;
}
</script>
@endpush