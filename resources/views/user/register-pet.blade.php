@extends('layouts.app')
@section('title', 'Register Pet - PawResort')

@push('styles')
<style>
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; }
.type-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 20px; }
.type-btn {
    border: 2.5px solid var(--paw-border);
    border-radius: 20px;
    padding: 16px 8px;
    text-align: center;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 800;
    background: #fff;
    transition: all .2s;
}
.type-btn .type-icon { display:block; font-size:2.2rem; margin-bottom:8px; }
.type-btn:hover { transform: translateY(-3px); border-color: var(--paw-brown); }
.type-btn.selected { border-color: var(--paw-brown); background: var(--paw-cream); box-shadow: 0 6px 16px var(--paw-shadow); }

.pet-table { width:100%; border-collapse:separate; border-spacing:0 10px; }
.pet-table th { font-size:0.95rem; color:#999; font-weight:800; padding:0 14px 6px; }
.pet-table td { background:#fff; padding:16px 18px; font-size:1rem; font-weight:700; }
.pet-table td:first-child { border-radius:16px 0 0 16px; }
.pet-table td:last-child  { border-radius:0 16px 16px 0; }
.pet-table tr td { border-top:2px solid var(--paw-border); border-bottom:2px solid var(--paw-border); }
.pet-table tr td:first-child { border-left:2px solid var(--paw-border); }
.pet-table tr td:last-child  { border-right:2px solid var(--paw-border); }
.pet-emoji { font-size:1.8rem; }

@media(max-width:768px){ .two-col{ grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="page-title">Register Pet 🐾</div>
<div class="page-tagline">Add and manage your furry family members</div>

@if(session('success'))
    <div class="alert paw-alert alert-success mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert paw-alert alert-danger mb-4">{{ session('error') }}</div>
@endif

<div class="two-col">

    {{-- FORM CREATE --}}
    <div>
        <div class="paw-card">
            <h4 style="color:var(--paw-brown);margin-bottom:24px;">➕ Add New Pet</h4>

            <form method="POST" action="{{ route('user.register-pet') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label-paw">🐾 Pet Name</label>
                    <input type="text" name="name" class="paw-input"
                        placeholder="e.g. Luna, Mochi..." value="{{ old('name') }}" required>
                    @error('name')<div style="color:var(--paw-red);font-weight:700;margin-top:6px;font-size:.9rem;">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-paw">🔍 Breed</label>
                    <input type="text" name="breed" class="paw-input"
                        placeholder="e.g. Shiba Inu, Domestic Cat..." value="{{ old('breed') }}" required>
                    @error('breed')<div style="color:var(--paw-red);font-weight:700;margin-top:6px;font-size:.9rem;">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-paw">🐾 Pet Type</label>
                    <div class="type-grid" id="typeGrid">
                        @foreach([['dog','🐕','Dog'],['cat','🐱','Cat'],['hamster','🐹','Hamster'],['rabbit','🐰','Rabbit'],['other','🐾','Other']] as [$val,$icon,$lbl])
                            <div class="type-btn {{ old('type','dog')===$val?'selected':'' }}"
                                onclick="selectType('{{ $val }}',this)">
                                <span class="type-icon">{{ $icon }}</span>{{ $lbl }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="type" id="typeInput" value="{{ old('type','dog') }}" required>
                </div>

                <button type="submit" class="btn-paw w-100" style="font-size:1.15rem;padding:16px;">
                    Register Pet 🐾
                </button>
            </form>
        </div>
    </div>

    {{-- PET LIST + EDIT/DELETE --}}
    <div>
        <div class="paw-card">
            <h4 style="color:var(--paw-brown);margin-bottom:24px;">🐾 Your Pets ({{ count($pets) }})</h4>

            @if(count($pets) > 0)
                <table class="pet-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $pet)
                        <tr>
                            <td class="pet-emoji">
                                {{ $pet->type==='dog'?'🐕':($pet->type==='cat'?'🐱':($pet->type==='hamster'?'🐹':($pet->type==='rabbit'?'🐰':'🐾'))) }}
                            </td>
                            <td>{{ $pet->name }}</td>
                            <td style="color:#999;">{{ $pet->breed }}</td>
                            <td>{{ ucfirst($pet->type) }}</td>
                            <td>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <a href="{{ route('user.pet.edit', $pet->id) }}" class="btn-outline-paw" style="padding:6px 16px;font-size:.85rem;">Edit</a>
                                    <form method="POST" action="{{ route('user.pet.destroy', $pet->id) }}"
                                        onsubmit="return confirm('Delete {{ $pet->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger-sm" style="padding:6px 16px;font-size:.85rem;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align:center;opacity:.6;padding:40px 0;">
                    <div style="font-size:3.5rem;">🐾</div>
                    <p style="margin-top:12px;font-weight:700;">No pets registered yet.</p>
                </div>
            @endif
        </div>
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