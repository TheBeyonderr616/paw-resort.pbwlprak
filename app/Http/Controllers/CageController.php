<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cage;
use App\Models\Booking;

class CageController extends Controller
{
    /**
     * Show cage monitoring page
     */
    public function index()
    {
        // ambil semua cage
        $cages = Cage::all();

        // default 50 cage kalau belum ada data DB
        $totalCages = 50;

        // ambil booking yang statusnya aktif/confirmed
        $occupiedCages = Booking::where('status', 'confirmed')
            ->pluck('cage_id')
            ->toArray();

        // build array status (true = occupied)
        $cageStates = [];

        for ($i = 1; $i <= $totalCages; $i++) {
            $cageStates[] = in_array($i, $occupiedCages);
        }

        return view('admin.cage', compact('cageStates'));
    }

    /**
     * Save cage status from admin UI
     */
    public function save(Request $request)
    {
        $data = json_decode($request->cage_status, true);

        if (!$data) {
            return back()->with('error', 'Invalid cage data');
        }

        foreach ($data as $index => $status) {
            Cage::updateOrCreate(
                ['id' => $index + 1],
                ['is_occupied' => $status]
            );
        }

        return back()->with('success', 'Cage status updated successfully!');
    }

    /**
     * Toggle single cage (optional API style)
     */
    public function toggle($id)
    {
        $cage = Cage::findOrFail($id);

        $cage->is_occupied = !$cage->is_occupied;
        $cage->save();

        return response()->json([
            'success' => true,
            'status' => $cage->is_occupied
        ]);
    }
}