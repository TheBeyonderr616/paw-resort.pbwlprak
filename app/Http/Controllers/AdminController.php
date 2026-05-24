<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function cage()
    {
        $totalCages = 50;
        $occupiedIds = Cage::where('status', 'occupied')->pluck('id')->toArray();
        $cageStates = [];
        for ($i = 1; $i <= $totalCages; $i++) {
            $cageStates[] = in_array($i, $occupiedIds);
        }
        return view('admin.cage', compact('cageStates'));
    }

    public function payment()
    {
        $bookings = Booking::with('user', 'cage')
            ->orderByDesc('created_at')
            ->paginate(10);

        $pendingCount   = Booking::where('status', 'pending')->count();
        $validatedCount = Booking::where('status', 'confirmed')->count();

        $prices = ['daily' => 75, 'weekly' => 500, 'vip' => 100];
        $totalRaw = Booking::where('status', 'confirmed')->get()
            ->sum(fn($b) => $prices[$b->pawckage] ?? 0);
        $totalAmount = 'Rp ' . number_format($totalRaw) . 'k';

        return view('admin.payment', compact('bookings', 'pendingCount', 'validatedCount', 'totalAmount'));
    }

    public function confirmPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', '✅ Booking confirmed!');
    }

    public function declinePayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'declined']);
        if ($booking->cage_id) {
            Cage::where('id', $booking->cage_id)->update(['status' => 'available']);
        }
        return back()->with('success', 'Booking declined.');
    }

    // ── DELETE Booking (admin) ─────────────────────────────────
    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->cage_id && $booking->status !== 'declined') {
            Cage::where('id', $booking->cage_id)->update(['status' => 'available']);
        }
        $booking->delete();
        return back()->with('success', '🗑️ Booking deleted.');
    }
}