<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('user.dashboard', compact('pets'));
    }

    // ── Booking ────────────────────────────────────────────────────────────────

    public function booking(Request $request)
    {
        return view('user.booking');
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'pawckage'         => 'required|in:daily,weekly,vip',
        ]);

        Booking::create([
            'user_id'          => Auth::id(),
            'reservation_date' => $request->reservation_date,
            'pawckage'         => $request->pawckage,
            'status'           => 'pending',
        ]);

        return redirect()->route('user.booking')
            ->with('success', 'Booking submitted! 🐾 Please wait for confirmation.');
    }

    // ── Payment (user view) ────────────────────────────────────────────────────

    public function payment()
    {
        $bookings = Booking::where('user_id', Auth::id())
                        ->orderByDesc('created_at')
                        ->paginate(10);
        return view('user.payment', compact('bookings'));
    }

    // ── Register Pet ───────────────────────────────────────────────────────────

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

        return back()->with('success', 'Pet registered! 🐾');
    }
}