<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CageStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    // ── Admin Dashboard ────────────────────────────────────────────────────────

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // ── Cage Monitoring ────────────────────────────────────────────────────────

    public function cage()
    {
        // Load cage states from cache or DB (50 cages, false = available)
        $cageStates = Cache::get('cage_states', array_fill(0, 50, false));
        return view('admin.cage', compact('cageStates'));
    }

    public function saveCage(Request $request)
    {
        $states = json_decode($request->input('cage_status'), true);
        if (is_array($states) && count($states) === 50) {
            Cache::forever('cage_states', $states);
        }
        return back()->with('success', 'Cage status saved! 🏠');
    }

    // ── Payment Validation ─────────────────────────────────────────────────────

    public function payment()
    {
        $bookings = Booking::with('user')
            ->orderByDesc('created_at')
            ->paginate(10);

        $confirmedCount = Booking::where('status', 'confirmed')->count();
        $totalCount     = Booking::count();

        // Simple total amount calc based on pawckage
        $prices = ['daily' => 75, 'weekly' => 500, 'vip' => 100];
        $totalAmount = Booking::where('status', 'confirmed')->get()->sum(fn($b) => $prices[$b->pawckage] ?? 0) . 'k';

        return view('admin.payment', compact('bookings', 'confirmedCount', 'totalCount', 'totalAmount'));
    }

    public function confirmPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking confirmed! ✅');
    }

    public function declinePayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'declined']);
        return back()->with('success', 'Booking declined.');
    }
}