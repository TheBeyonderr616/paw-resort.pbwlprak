@extends('layouts.app')

@section('title', 'Booking - PawResort')

@push('styles')
<style>
.booking-page {
    padding: 28px 16px;
    max-width: 720px;
    margin: auto;
}

.page-title {
    font-family: 'Baloo 2', cursive;
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--paw-brown);
    text-align: center;
}

<<<<<<< Updated upstream
    .pawckage-select-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--paw-cream);
        border: 2px solid var(--paw-border);
        border-radius: 14px;
        padding: 12px 18px;
        font-weight: 700;
        color: var(--paw-dark);
        cursor: pointer;
        text-decoration: none;
        margin-bottom: 24px;
        transition: border-color .2s;
    }
    .pawckage-select-btn:hover { border-color: var(--paw-brown); color: var(--paw-dark); }
    .pawckage-select-btn span { font-size: 0.9rem; }

    .rabbit-deco {
        text-align: right;
        font-size: 70px;
        margin-bottom: -20px;
        line-height: 1;
    }

    .cal-box {
        background: var(--paw-cream);
        border: 2.5px solid var(--paw-border);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .cal-month-year {
        font-family: 'Baloo 2', cursive;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--paw-brown);
    }
    .cal-nav-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: var(--paw-brown);
        cursor: pointer;
        padding: 4px 10px;
        border-radius: 8px;
        transition: background .2s;
    }
    .cal-nav-btn:hover { background: var(--paw-border); }
=======
.page-tagline {
    text-align: center;
    font-weight: 600;
    color: #777;
    margin-bottom: 20px;
}

.card-box {
    background: #fff;
    border: 2px solid var(--paw-border);
    border-radius: 16px;
    padding: 16px;
    margin-bottom: 16px;
}

.label {
    font-weight: 800;
    margin-bottom: 6px;
    display: block;
}
>>>>>>> Stashed changes

.select, .input {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 2px solid var(--paw-border);
    font-weight: 600;
}

<<<<<<< Updated upstream
    .date-display-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--paw-cream);
        border: 2px solid var(--paw-border);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    .date-display-row label { font-size: 0.85rem; font-weight: 700; color: var(--paw-dark); }
    .date-display-val {
        background: #e8e0ef;
        border-radius: 10px;
        padding: 8px 18px;
        font-weight: 800;
        color: var(--paw-dark);
        font-size: 0.95rem;
        min-width: 130px;
        text-align: center;
    }
=======
.btn-paw {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 14px;
    background: var(--paw-brown);
    color: #fff;
    font-weight: 800;
}
>>>>>>> Stashed changes
</style>
@endpush

@section('content')

<div class="page-wrapper">
<div class="booking-page">

    <div class="page-title">🐾 PawResort Booking</div>
    <div class="page-tagline">Select date and cage</div>

<<<<<<< Updated upstream
    <div style="font-weight:700; font-size:0.9rem; color:var(--paw-dark); margin-bottom:8px;">
        Choose your favourite Pawckage! :
    </div>
    <a href="{{ route('pawckage') }}" class="pawckage-select-btn">
        <span>📦 See Pawckage!</span>
        <i class="fa fa-chevron-right" style="font-size:0.8rem;"></i>
    </a>

    <div class="rabbit-deco">🐰🐰</div>

    <div style="font-weight:700; font-size:0.9rem; color:var(--paw-dark); margin-bottom:10px;">
        Choose reservation :
    </div>
    <div class="cal-box">
        <div class="cal-header">
            <button class="cal-nav-btn" id="prevMonth">&#8249;</button>
            <div class="cal-month-year" id="calMonthYear">January 2026</div>
            <button class="cal-nav-btn" id="nextMonth">&#8250;</button>
        </div>

        <div class="cal-grid" id="calGrid">
            <div class="cal-day-header">Sun</div>
            <div class="cal-day-header">Mon</div>
            <div class="cal-day-header">Tue</div>
            <div class="cal-day-header">Wed</div>
            <div class="cal-day-header">Thu</div>
            <div class="cal-day-header">Fri</div>
            <div class="cal-day-header">Sat</div>
        </div>

        <div class="cal-grid" id="calDays"></div>
    </div>

    <div class="date-display-row">
        <label>Your reservation<br>date is:</label>
        <div class="date-display-val" id="selectedDateDisplay">—</div>
    </div>

    <form method="POST" action="{{ route('user.booking.store') }}" id="bookingForm">
=======
    {{-- FORM --}}
    <form method="POST" action="{{ route('user.booking.store') }}">
>>>>>>> Stashed changes
        @csrf

        {{-- DATE --}}
        <div class="card-box">
            <label class="label">Reservation Date</label>
            <input type="date" name="reservation_date" class="input" required>
        </div>

        {{-- CAGE --}}
        <div class="card-box">
            <label class="label">Choose Cage</label>

            <select name="cage_id" class="select" required>
    <option value="">-- Select Cage --</option>

    @foreach($cages as $cage)
        <option value="{{ $cage->id }}"
            {{ $cage->status !== 'available' ? 'disabled' : '' }}>

            {{ $cage->name }}
            {{ $cage->status !== 'available' ? '(Locked)' : '' }}

        </option>
    @endforeach
</select>
        </div>

        {{-- PACKAGE --}}
        <div class="card-box">
            <label class="label">Package</label>

            <select name="pawckage" class="select">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="vip">VIP</option>
            </select>
        </div>

        <button class="btn-paw">Confirm Booking 🐾</button>
    </form>

</div>
</div>

<<<<<<< Updated upstream
@push('scripts')
<script>
    const MONTHS = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];
    let currentDate = new Date();
    let selectedDate = null;

    function renderCalendar() {
        const y = currentDate.getFullYear();
        const m = currentDate.getMonth();
        const today = new Date();

        document.getElementById('calMonthYear').textContent = `${MONTHS[m]} ${y}`;

        const firstDay = new Date(y, m, 1).getDay();
        const daysInMonth = new Date(y, m + 1, 0).getDate();

        const grid = document.getElementById('calDays');
        grid.innerHTML = '';

        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            empty.className = 'cal-day empty';
            grid.appendChild(empty);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const cell = document.createElement('div');
            cell.className = 'cal-day';
            cell.textContent = d;

            const cellDate = new Date(y, m, d);
            const isToday = cellDate.toDateString() === today.toDateString();
            const isPast = cellDate < new Date(today.setHours(0,0,0,0));

            if (isToday) cell.classList.add('today');
            if (isPast) {
                cell.classList.add('past');
            } else {
                cell.addEventListener('click', () => selectDate(y, m, d));
            }

            if (selectedDate &&
                selectedDate.getFullYear() === y &&
                selectedDate.getMonth() === m &&
                selectedDate.getDate() === d) {
                cell.classList.add('selected');
            }

            grid.appendChild(cell);
        }
    }

    function selectDate(y, m, d) {
        selectedDate = new Date(y, m, d);
        const formatted = `${y}/${String(m+1).padStart(2,'0')}/${String(d).padStart(2,'0')}`;
        document.getElementById('selectedDateDisplay').textContent = formatted;
        document.getElementById('reservationDateInput').value = formatted;
        renderCalendar();
    }

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    function validateForm() {
        if (!selectedDate) {
            alert('Please select a reservation date first! 🐾');
            return false;
        }
        return true;
    }

    renderCalendar();
</script>
@endpush
=======
@endsection
>>>>>>> Stashed changes
