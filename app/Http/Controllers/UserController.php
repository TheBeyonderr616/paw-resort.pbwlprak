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

    // ── Booking ───────────────────────────────────────────────
    public function booking()
    {
        $cages = Cage::orderBy('code')->get();
        $pets  = Pet::where('user_id', Auth::id())->get();
        return view('user.booking', compact('cages', 'pets'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'pet_id'           => 'required|exists:pets,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'pawckage'         => 'required|in:daily,weekly,vip',
            'cage_id'          => 'required|exists:cages,id',
        ]);

        $cage = Cage::find($request->cage_id);
        if (!$cage || $cage->status !== 'available') {
            return back()->with('error', 'Cage tidak tersedia (sudah ditempati atau di-lock).');
        }

        $exists = Booking::where('cage_id', $request->cage_id)
            ->where('reservation_date', $request->reservation_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Cage sudah dipakai di tanggal ini.');
        }

        // Check if user already has an active booking on this date
        $userHasBooking = Booking::where('user_id', Auth::id())
            ->where('reservation_date', $request->reservation_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($userHasBooking) {
            return back()->with('error', 'Anda sudah memiliki booking aktif di tanggal ini.');
        }

        Booking::create([
            'user_id'          => Auth::id(),
            'pet_id'           => $request->pet_id,
            'cage_id'          => $request->cage_id,
            'reservation_date' => $request->reservation_date,
            'pawckage'         => $request->pawckage,
            'status'           => 'pending',
        ]);

        $cage->update(['status' => 'occupied']);

        return redirect()->route('user.payment')->with('success', 'Booking berhasil! 🐾');
    }

    // ── Cancel Booking ────────────────────────────────────────
    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $booking->update(['status' => 'cancelled']);

        if ($booking->cage_id) {
            Cage::where('id', $booking->cage_id)->update(['status' => 'available']);
        }

        return back()->with('success', 'Booking cancelled. 🐾');
    }

    // ── Payment ───────────────────────────────────────────────
    public function payment()
    {
        $bookings = Booking::with('cage', 'pet')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.payment', compact('bookings'));
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('payments'), $filename);
            $booking->update(['payment_proof' => 'payments/' . $filename]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil di-upload! Admin akan segera memverifikasi.');
    }

    // ── Register Pet (CREATE + READ) ──────────────────────────
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

    // ── Edit Pet (UPDATE) ─────────────────────────────────────
    public function editPet($id)
    {
        $pet = Pet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.edit-pet', compact('pet'));
    }

    public function updatePet(Request $request, $id)
    {
        $pet = Pet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name'  => 'required|string|max:100',
            'breed' => 'required|string|max:100',
            'type'  => 'required|in:dog,cat,hamster,rabbit,other',
        ]);

        $pet->update([
            'name'  => $request->name,
            'breed' => $request->breed,
            'type'  => $request->type,
        ]);

        return redirect()->route('user.register-pet')->with('success', '✅ Pet updated successfully!');
    }

    // ── Delete Pet (DELETE) ───────────────────────────────────
    public function destroyPet($id)
    {
        $pet = Pet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pet->delete();

        return back()->with('success', '🗑️ Pet deleted.');
    }
}
