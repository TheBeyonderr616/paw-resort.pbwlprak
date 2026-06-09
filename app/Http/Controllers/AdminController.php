<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cage;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'    => \App\Models\User::where('role', 'user')->count(),
            'pets'     => Pet::count(),
            'bookings' => Booking::where('status', 'confirmed')->count(),
            'pending'  => Booking::where('status', 'pending')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function payment()
    {
        $bookings = Booking::with('user', 'cage', 'pet')
            ->orderByDesc('created_at')
            ->paginate(10);

        $pendingCount   = Booking::where('status', 'pending')->count();
        $validatedCount = Booking::where('status', 'confirmed')->count();

        // Calculate Revenue with Cage Type consideration
        $totalRaw = Booking::where('status', 'confirmed')->with('cage')->get()
            ->sum(function($b) {
                $type = $b->cage->type ?? 'standard';
                $prices = [
                    'standard' => ['daily' => 75, 'weekly' => 500, 'vip' => 100], // vip package in standard cage? 
                    'vip'      => ['daily' => 150, 'weekly' => 900, 'vip' => 200],
                ];
                // Fallback for package
                $pkg = $b->pawckage;
                return $prices[$type][$pkg] ?? $prices['standard'][$pkg] ?? 0;
            });

        $totalAmount = 'Rp ' . number_format($totalRaw) . 'k';

        return view('admin.payment', compact('bookings', 'pendingCount', 'validatedCount', 'totalAmount'));
    }

    public function showBooking($id)
    {
        $booking = Booking::with(['user', 'cage', 'pet'])->findOrFail($id);
        return view('admin.booking-show', compact('booking'));
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