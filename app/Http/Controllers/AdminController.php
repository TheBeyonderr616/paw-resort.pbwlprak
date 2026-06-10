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
                $prices = config('pawresort.prices');
                
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
            // Check if there are any other active bookings for this cage
            $hasActive = Booking::where('cage_id', $booking->cage_id)
                ->where('id', '!=', $booking->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if (!$hasActive) {
                Cage::where('id', $booking->cage_id)->update(['status' => 'available']);
            }
        }
        return back()->with('success', 'Booking declined.');
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'pawckage' => 'required|in:daily,weekly,vip',
        ]);

        $booking = Booking::with('cage')->findOrFail($id);
        
        // Only allow update if pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Package hanya bisa diubah saat status masih pending.');
        }

        $cage = $booking->cage;

        // Validate Cage Type vs New Package
        if ($request->pawckage === 'vip' && $cage->type !== 'vip') {
            return back()->with('error', 'Package VIP hanya bisa untuk Cage tipe VIP.');
        }
        if ($request->pawckage !== 'vip' && $cage->type === 'vip') {
            return back()->with('error', 'Cage VIP hanya untuk package VIP.');
        }

        // Recalculate end date
        $days = ($request->pawckage === 'weekly') ? 7 : 1;
        $endDate = date('Y-m-d', strtotime($booking->reservation_date->format('Y-m-d') . " + " . ($days - 1) . " days"));

        $booking->update([
            'pawckage' => $request->pawckage,
            'end_date' => $endDate,
        ]);

        return back()->with('success', '✅ Package updated successfully!');
    }

    // ── DELETE Booking (admin) ─────────────────────────────────
    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        
        $cageId = $booking->cage_id;
        $booking->delete();

        if ($cageId) {
            // Check if there are any other active bookings for this cage
            $hasActive = Booking::where('cage_id', $cageId)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if (!$hasActive) {
                Cage::where('id', $cageId)->update(['status' => 'available']);
            }
        }

        return back()->with('success', '🗑️ Booking deleted.');
    }
}