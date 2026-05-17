<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pet;
use App\Models\Cage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────
    public function dashboard()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('user.dashboard', compact('pets'));
    }

    // ── Booking Page ──────────────────────────────────────────
    public function booking()
{
    $cages = \App\Models\Cage::where('status', 'available')->get();
    return view('user.booking', compact('cages'));
}

    // ── Store Booking (WITH CAGE LOCK SYSTEM) ────────────────
    public function storeBooking(Request $request)
{
    $request->validate([
        'reservation_date' => 'required|date|after_or_equal:today',
        'pawckage' => 'required|in:daily,weekly,vip',
        'cage_id' => 'required|exists:cages,id',
    ]);

    // CEK DOUBLE BOOKING
    $exists = Booking::where('cage_id', $request->cage_id)
        ->where('reservation_date', $request->reservation_date)
        ->whereIn('status', ['pending', 'confirmed'])
        ->exists();

    if ($exists) {
        return back()->with('error', 'Cage sudah dipakai di tanggal ini');
    }

    // SIMPAN BOOKING
    Booking::create([
        'user_id' => auth()->id(),
        'cage_id' => $request->cage_id,
        'reservation_date' => $request->reservation_date,
        'pawckage' => $request->pawckage,
        'status' => 'pending',
    ]);

    Cage::where('id', $request->cage_id)
        ->update(['status' => 'occupied']);

    return redirect()->route('user.booking')
        ->with('success', 'Booking berhasil 🐾');
}

    // ── Payment ───────────────────────────────────────────────
    public function payment()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.payment', compact('bookings'));
    }

    // ── Register Pet ──────────────────────────────────────────
    public function registerPetForm()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('user.register-pet', compact('pets'));
    }

    public function registerPetStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'breed' => 'required|string|max:100',
            'type'  => 'required|in:dog,cat,hamster,rabbit,other',
        ]);

        Pet::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'breed'   => $request->breed,
            'type'    => $request->type,
        ]);

        return back()->with('success', '🐾 Pet registered successfully!');
    }
}